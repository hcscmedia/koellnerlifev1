<?php
/**
 * CMS Seite Anzeige (Frontend)
 */

require_once 'config.php';
require_once __DIR__ . '/admin/classes/CMSPage.php';

$slug = $_GET['slug'] ?? basename($_SERVER['REQUEST_URI']);

$cmsPage = new CMSPage();
$page_data = $cmsPage->getBySlug($slug);

if (!$page_data) {
    header("HTTP/1.0 404 Not Found");
    echo "Seite nicht gefunden.";
    exit;
}

$page_title = $page_data['meta_title'] ?? $page_data['title'];
$page_description = $page_data['meta_description'] ?? '';

include 'includes/header.php';
?>

<section style="padding: 80px 20px 100px;">
    <div class="container" style="max-width: <?php echo $page_data['template'] === 'full-width' ? '1400px' : '800px'; ?>;">
        <h1 style="font-size: 48px; margin-bottom: 40px; text-align: center;">
            <?php echo htmlspecialchars($page_data['title']); ?>
        </h1>
        
        <div class="post-content">
            <?php echo nl2br($page_data['content']); ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
