<?php
/**
 * Blog Post Erstellen/Bearbeiten
 */

require_once '../../config.php';
require_once '../classes/AdminAuth.php';
require_once '../classes/BlogPost.php';
require_once '../classes/BlogCategory.php';

$auth = new AdminAuth();
$auth->requireLogin();

$admin = $auth->getCurrentAdmin();
$blogPost = new BlogPost();
$blogCategory = new BlogCategory();

$categories = $blogCategory->getAll();

// Bearbeitungsmodus?
$edit_mode = isset($_GET['id']);
$post = null;

if ($edit_mode) {
    $post = $blogPost->getById($_GET['id']);
    if (!$post) {
        header('Location: posts.php');
        exit;
    }
}

$errors = [];
$success = false;

// Formular verarbeiten
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF-Token validieren
    if (!$auth->validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Ungültige Anfrage.';
    } else {
        // Validierung
        if (empty($_POST['title'])) {
            $errors[] = 'Titel ist erforderlich.';
        }
        
        if (empty($_POST['content'])) {
            $errors[] = 'Inhalt ist erforderlich.';
        }
        
        if (empty($errors)) {
            $data = [
                'title' => trim($_POST['title']),
                'slug' => trim($_POST['slug']),
                'excerpt' => trim($_POST['excerpt']),
                'content' => $_POST['content'],
                'featured_image' => trim($_POST['featured_image']),
                'category_id' => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
                'status' => $_POST['status'] ?? 'draft',
                'meta_title' => trim($_POST['meta_title']),
                'meta_description' => trim($_POST['meta_description']),
                'meta_keywords' => trim($_POST['meta_keywords'])
            ];
            
            if ($edit_mode) {
                // Update
                $blogPost->update($post['id'], $data);
                $auth->logActivity($admin['id'], 'update', 'blog_posts', $post['id'], 'Blog Post aktualisiert: ' . $data['title']);
                header('Location: posts.php?saved=1');
                exit;
            } else {
                // Create
                $data['author_id'] = $admin['id'];
                $new_id = $blogPost->create($data);
                $auth->logActivity($admin['id'], 'create', 'blog_posts', $new_id, 'Blog Post erstellt: ' . $data['title']);
                header('Location: posts.php?saved=1');
                exit;
            }
        }
    }
}

$page_title = $edit_mode ? 'Post bearbeiten' : 'Neuer Post';
$current_page = 'blog';

include '../includes/header.php';
?>

<form method="POST" action="" id="postForm">
    <input type="hidden" name="csrf_token" value="<?php echo $auth->generateCSRFToken(); ?>">
    
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><?php echo $page_title; ?></h2>
            <div style="display: flex; gap: 12px;">
                <button type="submit" name="status" value="draft" class="btn btn-secondary">
                    <i class="fas fa-save"></i> Als Entwurf speichern
                </button>
                <button type="submit" name="status" value="published" class="btn btn-success">
                    <i class="fas fa-check"></i> Veröffentlichen
                </button>
            </div>
        </div>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error): ?>
                    <div><?php echo htmlspecialchars($error); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div style="padding: 24px;">
            <div class="form-group">
                <label for="title">Titel *</label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       required 
                       value="<?php echo htmlspecialchars($post['title'] ?? ''); ?>"
                       placeholder="Post-Titel eingeben">
            </div>
            
            <div class="form-group">
                <label for="slug">URL-Slug (automatisch generiert wenn leer)</label>
                <input type="text" 
                       id="slug" 
                       name="slug" 
                       value="<?php echo htmlspecialchars($post['slug'] ?? ''); ?>"
                       placeholder="url-freundlicher-slug">
                <small style="color: var(--admin-text-muted);">
                    URL: <?php echo SITE_URL; ?>/blog/<span id="slugPreview"><?php echo $post['slug'] ?? 'url-slug'; ?></span>
                </small>
            </div>
            
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="category_id">Kategorie</label>
                    <select id="category_id" name="category_id">
                        <option value="">-- Keine Kategorie --</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>" 
                                    <?php echo ($post['category_id'] ?? '') == $category['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="featured_image">Beitragsbild URL</label>
                    <input type="text" 
                           id="featured_image" 
                           name="featured_image" 
                           value="<?php echo htmlspecialchars($post['featured_image'] ?? ''); ?>"
                           placeholder="/uploads/image.jpg">
                </div>
            </div>
            
            <div class="form-group">
                <label for="excerpt">Auszug</label>
                <textarea id="excerpt" 
                          name="excerpt" 
                          rows="3"
                          placeholder="Kurze Zusammenfassung des Posts (optional)"><?php echo htmlspecialchars($post['excerpt'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="content">Inhalt *</label>
                <textarea id="content" 
                          name="content" 
                          rows="20"
                          required
                          placeholder="Post-Inhalt hier eingeben..."><?php echo htmlspecialchars($post['content'] ?? ''); ?></textarea>
                <small style="color: var(--admin-text-muted);">
                    HTML ist erlaubt. Für beste Ergebnisse Markdown oder HTML verwenden.
                </small>
            </div>
        </div>
    </div>
    
    <!-- SEO Meta -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">SEO Einstellungen</h2>
        </div>
        
        <div style="padding: 24px;">
            <div class="form-group">
                <label for="meta_title">Meta Titel (optional)</label>
                <input type="text" 
                       id="meta_title" 
                       name="meta_title" 
                       value="<?php echo htmlspecialchars($post['meta_title'] ?? ''); ?>"
                       placeholder="Leer lassen um Titel zu verwenden">
                <small style="color: var(--admin-text-muted);">Max. 60 Zeichen empfohlen</small>
            </div>
            
            <div class="form-group">
                <label for="meta_description">Meta Beschreibung</label>
                <textarea id="meta_description" 
                          name="meta_description" 
                          rows="3"
                          placeholder="SEO-optimierte Beschreibung"><?php echo htmlspecialchars($post['meta_description'] ?? ''); ?></textarea>
                <small style="color: var(--admin-text-muted);">Max. 160 Zeichen empfohlen</small>
            </div>
            
            <div class="form-group">
                <label for="meta_keywords">Meta Keywords (optional)</label>
                <input type="text" 
                       id="meta_keywords" 
                       name="meta_keywords" 
                       value="<?php echo htmlspecialchars($post['meta_keywords'] ?? ''); ?>"
                       placeholder="keyword1, keyword2, keyword3">
            </div>
        </div>
    </div>
    
    <div style="display: flex; justify-content: space-between; margin-top: 20px;">
        <a href="posts.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Zurück
        </a>
        
        <div style="display: flex; gap: 12px;">
            <button type="submit" name="status" value="draft" class="btn btn-secondary">
                Als Entwurf speichern
            </button>
            <button type="submit" name="status" value="published" class="btn btn-success">
                Veröffentlichen
            </button>
        </div>
    </div>
</form>

<script>
// Auto-Slug-Generierung
document.getElementById('title').addEventListener('input', function() {
    const slug = document.getElementById('slug');
    if (!slug.value || slug.dataset.auto !== 'false') {
        const generatedSlug = generateSlug(this.value);
        slug.value = generatedSlug;
        document.getElementById('slugPreview').textContent = generatedSlug || 'url-slug';
    }
});

document.getElementById('slug').addEventListener('input', function() {
    this.dataset.auto = 'false';
    document.getElementById('slugPreview').textContent = this.value || 'url-slug';
});

function generateSlug(text) {
    const replacements = {
        'ä': 'ae', 'ö': 'oe', 'ü': 'ue',
        'Ä': 'ae', 'Ö': 'oe', 'Ü': 'ue',
        'ß': 'ss'
    };
    
    let slug = text;
    Object.keys(replacements).forEach(key => {
        slug = slug.replace(new RegExp(key, 'g'), replacements[key]);
    });
    
    return slug
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
}

// Formular-Warnung bei ungespeicherten Änderungen
let formChanged = false;
document.getElementById('postForm').addEventListener('change', () => formChanged = true);
window.addEventListener('beforeunload', function(e) {
    if (formChanged) {
        e.preventDefault();
        e.returnValue = '';
    }
});
document.getElementById('postForm').addEventListener('submit', () => formChanged = false);
</script>

<?php include '../includes/footer.php'; ?>
