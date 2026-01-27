<?php
/**
 * Blog Post Einzelansicht (Frontend)
 */

require_once 'config.php';
require_once __DIR__ . '/admin/classes/BlogPost.php';

// Slug aus URL
$slug = $_GET['slug'] ?? basename($_SERVER['REQUEST_URI']);

$blogPost = new BlogPost();
$post = $blogPost->getBySlug($slug);

// 404 wenn Post nicht gefunden
if (!$post) {
    header("HTTP/1.0 404 Not Found");
    echo "Post nicht gefunden.";
    exit;
}

// Views erhöhen
$blogPost->incrementViews($post['id']);

// SEO
$page_title = $post['meta_title'] ?? $post['title'];
$page_description = $post['meta_description'] ?? $post['excerpt'];

include 'includes/header.php';
?>

<!-- Blog Post -->
<article style="padding: 80px 20px 100px;">
    <div class="container" style="max-width: 800px;">
        <!-- Header -->
        <header style="margin-bottom: 40px; text-align: center;">
            <div style="margin-bottom: 20px;">
                <?php if ($post['category_name']): ?>
                    <span class="blog-category">
                        <?php echo htmlspecialchars($post['category_name']); ?>
                    </span>
                <?php endif; ?>
            </div>
            
            <h1 style="font-size: 48px; line-height: 1.2; margin-bottom: 20px;">
                <?php echo htmlspecialchars($post['title']); ?>
            </h1>
            
            <div style="display: flex; align-items: center; justify-content: center; gap: 20px; color: var(--color-text-secondary); font-size: 14px;">
                <span>
                    <i class="fas fa-user"></i> <?php echo htmlspecialchars($post['author_name']); ?>
                </span>
                <span>•</span>
                <span>
                    <i class="fas fa-calendar"></i> 
                    <?php echo date('d. M Y', strtotime($post['published_at'] ?? $post['created_at'])); ?>
                </span>
                <span>•</span>
                <span>
                    <i class="fas fa-eye"></i> <?php echo number_format($post['views_count']); ?> Aufrufe
                </span>
            </div>
        </header>
        
        <!-- Featured Image -->
        <?php if ($post['featured_image']): ?>
            <div style="margin-bottom: 40px; border-radius: 16px; overflow: hidden;">
                <img src="<?php echo htmlspecialchars($post['featured_image']); ?>" 
                     alt="<?php echo htmlspecialchars($post['title']); ?>"
                     style="width: 100%; height: auto; display: block;">
            </div>
        <?php endif; ?>
        
        <!-- Excerpt -->
        <?php if ($post['excerpt']): ?>
            <div class="post-excerpt">
                <?php echo htmlspecialchars($post['excerpt']); ?>
            </div>
        <?php endif; ?>
        
        <!-- Content -->
        <div class="post-content">
            <?php echo nl2br($post['content']); ?>
        </div>
        
        <!-- Back Link -->
        <div style="margin-top: 60px; padding-top: 40px; border-top: 1px solid rgba(255, 255, 255, 0.1);">
            <a href="/blog.php" style="color: var(--color-accent-primary); text-decoration: none; font-weight: 600;">
                ← Zurück zum Blog
            </a>
        </div>
    </div>
</article>

<style>
.post-excerpt {
    font-size: 20px;
    line-height: 1.6;
    color: var(--color-text-secondary);
    padding: 24px;
    background: rgba(99, 102, 241, 0.05);
    border-left: 4px solid var(--color-accent-primary);
    border-radius: 8px;
    margin-bottom: 40px;
}

.post-content {
    font-size: 18px;
    line-height: 1.8;
    color: var(--color-text-primary);
}

.post-content p {
    margin-bottom: 24px;
}

.post-content h2 {
    font-size: 32px;
    margin-top: 48px;
    margin-bottom: 24px;
}

.post-content h3 {
    font-size: 24px;
    margin-top: 36px;
    margin-bottom: 20px;
}

.post-content ul,
.post-content ol {
    margin-bottom: 24px;
    padding-left: 24px;
}

.post-content li {
    margin-bottom: 12px;
}

.post-content code {
    background: rgba(255, 255, 255, 0.05);
    padding: 2px 6px;
    border-radius: 4px;
    font-family: 'Courier New', monospace;
}

.post-content pre {
    background: rgba(255, 255, 255, 0.05);
    padding: 20px;
    border-radius: 8px;
    overflow-x: auto;
    margin-bottom: 24px;
}

.post-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 24px 0;
}

.post-content blockquote {
    border-left: 4px solid var(--color-accent-primary);
    padding-left: 20px;
    margin: 24px 0;
    font-style: italic;
    color: var(--color-text-secondary);
}
</style>

<?php include 'includes/footer.php'; ?>
