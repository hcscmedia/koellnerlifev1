<?php
/**
 * Blog Posts Übersicht
 */

require_once '../../config.php';
require_once '../classes/AdminAuth.php';
require_once '../classes/BlogPost.php';

$auth = new AdminAuth();
$auth->requireLogin();

$admin = $auth->getCurrentAdmin();
$blogPost = new BlogPost();

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 20;
$status_filter = $_GET['status'] ?? null;

// Posts abrufen
$posts = $blogPost->getAll($page, $per_page, $status_filter);
$total_posts = $blogPost->getTotal($status_filter);
$total_pages = ceil($total_posts / $per_page);

// Löschen-Aktion
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    if ($auth->validateCSRFToken($_GET['token'] ?? '')) {
        $blogPost->delete($_GET['id']);
        $auth->logActivity($admin['id'], 'delete', 'blog_posts', $_GET['id'], 'Blog Post gelöscht');
        header('Location: posts.php?deleted=1');
        exit;
    }
}

$page_title = 'Blog Posts';
$current_page = 'blog';

include '../includes/header.php';
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Blog Posts verwalten</h2>
        <a href="new.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Neuer Post
        </a>
    </div>
    
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success">
            Post wurde erfolgreich gelöscht.
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['saved'])): ?>
        <div class="alert alert-success">
            Post wurde erfolgreich gespeichert.
        </div>
    <?php endif; ?>
    
    <!-- Filter -->
    <div style="padding: 20px; border-bottom: 1px solid var(--admin-border);">
        <div style="display: flex; gap: 12px;">
            <a href="posts.php" class="btn btn-sm <?php echo !$status_filter ? 'btn-primary' : 'btn-secondary'; ?>">
                Alle (<?php echo $blogPost->getTotal(); ?>)
            </a>
            <a href="posts.php?status=published" class="btn btn-sm <?php echo $status_filter === 'published' ? 'btn-primary' : 'btn-secondary'; ?>">
                Veröffentlicht (<?php echo $blogPost->getTotal('published'); ?>)
            </a>
            <a href="posts.php?status=draft" class="btn btn-sm <?php echo $status_filter === 'draft' ? 'btn-primary' : 'btn-secondary'; ?>">
                Entwürfe (<?php echo $blogPost->getTotal('draft'); ?>)
            </a>
        </div>
    </div>
    
    <?php if (empty($posts)): ?>
        <div style="padding: 40px; text-align: center; color: var(--admin-text-muted);">
            <i class="fas fa-blog" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
            <p>Noch keine Blog Posts vorhanden.</p>
            <a href="new.php" class="btn btn-primary" style="margin-top: 16px;">
                Ersten Post erstellen
            </a>
        </div>
    <?php else: ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Titel</th>
                        <th>Kategorie</th>
                        <th>Autor</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th>Datum</th>
                        <th>Aktionen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($post['title']); ?></strong>
                            <?php if ($post['featured_image']): ?>
                                <i class="fas fa-image" style="color: var(--admin-primary); margin-left: 8px;"></i>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($post['category_name'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($post['author_name']); ?></td>
                        <td>
                            <span class="badge badge-<?php echo $post['status']; ?>">
                                <?php echo ucfirst($post['status']); ?>
                            </span>
                        </td>
                        <td><?php echo number_format($post['views_count']); ?></td>
                        <td><?php echo date('d.m.Y', strtotime($post['created_at'])); ?></td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="edit.php?id=<?php echo $post['id']; ?>" 
                                   class="btn btn-sm btn-secondary" 
                                   title="Bearbeiten">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($post['status'] === 'published'): ?>
                                <a href="<?php echo SITE_URL; ?>/blog/<?php echo $post['slug']; ?>" 
                                   class="btn btn-sm btn-secondary" 
                                   title="Ansehen" 
                                   target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php endif; ?>
                                <a href="posts.php?action=delete&id=<?php echo $post['id']; ?>&token=<?php echo $auth->generateCSRFToken(); ?>" 
                                   class="btn btn-sm btn-danger" 
                                   title="Löschen"
                                   onclick="return confirmDelete('Möchten Sie diesen Post wirklich löschen?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div style="padding: 20px; display: flex; justify-content: center; gap: 8px; border-top: 1px solid var(--admin-border);">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?><?php echo $status_filter ? '&status=' . $status_filter : ''; ?>" 
                   class="btn btn-sm <?php echo $i === $page ? 'btn-primary' : 'btn-secondary'; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
