<?php
/**
 * Admin Dashboard
 */

require_once '../config.php';
require_once __DIR__ . '/classes/AdminAuth.php';

$auth = new AdminAuth();
$auth->requireLogin();

$admin = $auth->getCurrentAdmin();
$db = Database::getInstance();

// Statistiken abrufen
$stats = [
    'total_posts' => $db->fetchOne("SELECT COUNT(*) as count FROM blog_posts")['count'] ?? 0,
    'published_posts' => $db->fetchOne("SELECT COUNT(*) as count FROM blog_posts WHERE status = 'published'")['count'] ?? 0,
    'draft_posts' => $db->fetchOne("SELECT COUNT(*) as count FROM blog_posts WHERE status = 'draft'")['count'] ?? 0,
    'total_pages' => $db->fetchOne("SELECT COUNT(*) as count FROM cms_pages")['count'] ?? 0,
    'total_categories' => $db->fetchOne("SELECT COUNT(*) as count FROM blog_categories")['count'] ?? 0,
    'total_media' => $db->fetchOne("SELECT COUNT(*) as count FROM media_library")['count'] ?? 0,
    'new_contacts' => $db->fetchOne("SELECT COUNT(*) as count FROM contact_submissions WHERE status = 'new'")['count'] ?? 0,
    'total_views' => $db->fetchOne("SELECT SUM(views_count) as total FROM blog_posts")['total'] ?? 0
];

// Letzte Blog-Posts
$recent_posts = $db->fetchAll(
    "SELECT bp.*, au.full_name as author_name, bc.name as category_name 
     FROM blog_posts bp 
     LEFT JOIN admin_users au ON bp.author_id = au.id 
     LEFT JOIN blog_categories bc ON bp.category_id = bc.id 
     ORDER BY bp.created_at DESC 
     LIMIT 5"
);

// Letzte Kontaktanfragen
$recent_contacts = $db->fetchAll(
    "SELECT * FROM contact_submissions 
     ORDER BY submitted_at DESC 
     LIMIT 5"
);

// Seiten-Variablen
$page_title = 'Dashboard';
$current_page = 'dashboard';

// Header laden
include __DIR__ . '/includes/header.php';
?>

<!-- Dashboard Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary">
            <i class="fas fa-blog"></i>
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['total_posts']; ?></h3>
            <p>Gesamt Blog Posts</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon success">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['published_posts']; ?></h3>
            <p>Veröffentlicht</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon warning">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['draft_posts']; ?></h3>
            <p>Entwürfe</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon danger">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['new_contacts']; ?></h3>
            <p>Neue Kontakte</p>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 24px;">
    <!-- Letzte Blog Posts -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Letzte Blog Posts</h2>
            <a href="/admin/blog/posts.php" class="btn btn-sm btn-primary">Alle anzeigen</a>
        </div>
        
        <?php if (empty($recent_posts)): ?>
            <p style="color: var(--admin-text-muted); text-align: center; padding: 20px;">
                Noch keine Blog Posts vorhanden.
            </p>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Titel</th>
                            <th>Autor</th>
                            <th>Status</th>
                            <th>Datum</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_posts as $post): ?>
                        <tr>
                            <td>
                                <a href="/admin/blog/edit.php?id=<?php echo $post['id']; ?>" 
                                   style="color: var(--admin-primary); text-decoration: none;">
                                    <?php echo htmlspecialchars($post['title']); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($post['author_name']); ?></td>
                            <td>
                                <span class="badge badge-<?php echo $post['status']; ?>">
                                    <?php echo ucfirst($post['status']); ?>
                                </span>
                            </td>
                            <td><?php echo date('d.m.Y', strtotime($post['created_at'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Letzte Kontaktanfragen -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Letzte Kontaktanfragen</h2>
            <a href="/admin/contacts.php" class="btn btn-sm btn-primary">Alle anzeigen</a>
        </div>
        
        <?php if (empty($recent_contacts)): ?>
            <p style="color: var(--admin-text-muted); text-align: center; padding: 20px;">
                Keine Kontaktanfragen vorhanden.
            </p>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Betreff</th>
                            <th>Status</th>
                            <th>Datum</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_contacts as $contact): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($contact['name']); ?></td>
                            <td><?php echo htmlspecialchars(substr($contact['subject'] ?? 'Kein Betreff', 0, 30)); ?></td>
                            <td>
                                <span class="badge badge-<?php echo $contact['status']; ?>">
                                    <?php echo ucfirst($contact['status']); ?>
                                </span>
                            </td>
                            <td><?php echo date('d.m.Y', strtotime($contact['submitted_at'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Schnellaktionen -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Schnellaktionen</h2>
    </div>
    
    <div style="display: flex; gap: 16px; flex-wrap: wrap;">
        <a href="/admin/blog/new.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Neuer Blog Post
        </a>
        <a href="/admin/cms/new.php" class="btn btn-secondary">
            <i class="fas fa-file"></i> Neue Seite
        </a>
        <a href="/admin/media/upload.php" class="btn btn-secondary">
            <i class="fas fa-upload"></i> Medien hochladen
        </a>
        <a href="/admin/settings.php" class="btn btn-secondary">
            <i class="fas fa-cog"></i> Einstellungen
        </a>
    </div>
</div>

<style>
.badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}
.badge-published { background: rgba(16, 185, 129, 0.1); color: #10b981; }
.badge-draft { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
.badge-archived { background: rgba(148, 163, 184, 0.1); color: #94a3b8; }
.badge-new { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
.badge-read { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
.badge-replied { background: rgba(16, 185, 129, 0.1); color: #10b981; }
</style>

<?php include __DIR__ . '/includes/footer.php'; ?>
