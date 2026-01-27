<?php
/**
 * CMS Seite Erstellen/Bearbeiten
 */

require_once '../../config.php';
require_once '../classes/AdminAuth.php';
require_once '../classes/CMSPage.php';

$auth = new AdminAuth();
$auth->requireLogin();

$admin = $auth->getCurrentAdmin();
$cmsPage = new CMSPage();

// Bearbeitungsmodus?
$edit_mode = isset($_GET['id']);
$page_data = null;

if ($edit_mode) {
    $page_data = $cmsPage->getById($_GET['id']);
    if (!$page_data) {
        header('Location: pages.php');
        exit;
    }
}

$errors = [];

// Formular verarbeiten
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$auth->validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Ungültige Anfrage.';
    } else {
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
                'content' => $_POST['content'],
                'template' => $_POST['template'] ?? 'default',
                'status' => $_POST['status'] ?? 'draft',
                'meta_title' => trim($_POST['meta_title']),
                'meta_description' => trim($_POST['meta_description'])
            ];
            
            if ($edit_mode) {
                $cmsPage->update($page_data['id'], $data);
                $auth->logActivity($admin['id'], 'update', 'cms_pages', $page_data['id'], 'CMS Seite aktualisiert: ' . $data['title']);
            } else {
                $data['author_id'] = $admin['id'];
                $new_id = $cmsPage->create($data);
                $auth->logActivity($admin['id'], 'create', 'cms_pages', $new_id, 'CMS Seite erstellt: ' . $data['title']);
            }
            
            header('Location: pages.php?saved=1');
            exit;
        }
    }
}

$page_title = $edit_mode ? 'Seite bearbeiten' : 'Neue Seite';
$current_page = 'pages';

include '../includes/header.php';
?>

<form method="POST" action="">
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
                       value="<?php echo htmlspecialchars($page_data['title'] ?? ''); ?>">
            </div>
            
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="slug">URL-Slug</label>
                    <input type="text" 
                           id="slug" 
                           name="slug" 
                           value="<?php echo htmlspecialchars($page_data['slug'] ?? ''); ?>">
                    <small style="color: var(--admin-text-muted);">
                        URL: <?php echo SITE_URL; ?>/page/<span id="slugPreview"><?php echo $page_data['slug'] ?? 'url-slug'; ?></span>
                    </small>
                </div>
                
                <div class="form-group">
                    <label for="template">Template</label>
                    <select id="template" name="template">
                        <option value="default" <?php echo ($page_data['template'] ?? 'default') === 'default' ? 'selected' : ''; ?>>Standard</option>
                        <option value="full-width" <?php echo ($page_data['template'] ?? '') === 'full-width' ? 'selected' : ''; ?>>Volle Breite</option>
                        <option value="landing" <?php echo ($page_data['template'] ?? '') === 'landing' ? 'selected' : ''; ?>>Landing Page</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="content">Inhalt *</label>
                <textarea id="content" 
                          name="content" 
                          rows="20"
                          required><?php echo htmlspecialchars($page_data['content'] ?? ''); ?></textarea>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">SEO Einstellungen</h2>
        </div>
        
        <div style="padding: 24px;">
            <div class="form-group">
                <label for="meta_title">Meta Titel</label>
                <input type="text" 
                       id="meta_title" 
                       name="meta_title" 
                       value="<?php echo htmlspecialchars($page_data['meta_title'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="meta_description">Meta Beschreibung</label>
                <textarea id="meta_description" 
                          name="meta_description" 
                          rows="3"><?php echo htmlspecialchars($page_data['meta_description'] ?? ''); ?></textarea>
            </div>
        </div>
    </div>
    
    <div style="display: flex; justify-content: space-between; margin-top: 20px;">
        <a href="pages.php" class="btn btn-secondary">
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
</script>

<?php include '../includes/footer.php'; ?>
