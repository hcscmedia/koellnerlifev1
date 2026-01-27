<?php
/**
 * CMS Seiten Übersicht
 */

require_once '../../config.php';
require_once '../classes/AdminAuth.php';
require_once '../classes/CMSPage.php';

$auth = new AdminAuth();
$auth->requireLogin();

$admin = $auth->getCurrentAdmin();
$cmsPage = new CMSPage();

$pages = $cmsPage->getAll();

// Löschen-Aktion
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    if ($auth->validateCSRFToken($_GET['token'] ?? '')) {
        $cmsPage->delete($_GET['id']);
        $auth->logActivity($admin['id'], 'delete', 'cms_pages', $_GET['id'], 'CMS Seite gelöscht');
        header('Location: pages.php?deleted=1');
        exit;
    }
}

$page_title = 'CMS Seiten';
$current_page = 'pages';

include '../includes/header.php';
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">CMS Seiten verwalten</h2>
        <a href="edit.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Neue Seite
        </a>
    </div>
    
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success">
            Seite wurde erfolgreich gelöscht.
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['saved'])): ?>
        <div class="alert alert-success">
            Seite wurde erfolgreich gespeichert.
        </div>
    <?php endif; ?>
    
    <?php if (empty($pages)): ?>
        <div style="padding: 40px; text-align: center; color: var(--admin-text-muted);">
            <i class="fas fa-file-alt" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
            <p>Noch keine CMS Seiten vorhanden.</p>
            <a href="edit.php" class="btn btn-primary" style="margin-top: 16px;">
                Erste Seite erstellen
            </a>
        </div>
    <?php else: ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Titel</th>
                        <th>Slug</th>
                        <th>Template</th>
                        <th>Status</th>
                        <th>Autor</th>
                        <th>Datum</th>
                        <th>Aktionen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pages as $page): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($page['title']); ?></strong></td>
                        <td><code><?php echo htmlspecialchars($page['slug']); ?></code></td>
                        <td><?php echo htmlspecialchars($page['template']); ?></td>
                        <td>
                            <span class="badge badge-<?php echo $page['status']; ?>">
                                <?php echo ucfirst($page['status']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($page['author_name']); ?></td>
                        <td><?php echo date('d.m.Y', strtotime($page['created_at'])); ?></td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="edit.php?id=<?php echo $page['id']; ?>" 
                                   class="btn btn-sm btn-secondary" 
                                   title="Bearbeiten">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($page['status'] === 'published'): ?>
                                <a href="<?php echo SITE_URL; ?>/page/<?php echo $page['slug']; ?>" 
                                   class="btn btn-sm btn-secondary" 
                                   title="Ansehen" 
                                   target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php endif; ?>
                                <a href="pages.php?action=delete&id=<?php echo $page['id']; ?>&token=<?php echo $auth->generateCSRFToken(); ?>" 
                                   class="btn btn-sm btn-danger" 
                                   title="Löschen"
                                   onclick="return confirmDelete('Möchten Sie diese Seite wirklich löschen?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
