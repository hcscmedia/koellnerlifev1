<?php
/**
 * Blog Übersichtsseite (Frontend)
 */

require_once 'config.php';

// Blog Post Model laden
require_once __DIR__ . '/admin/classes/BlogPost.php';
require_once __DIR__ . '/admin/classes/BlogCategory.php';

$blogPost = new BlogPost();
$blogCategory = new BlogCategory();

// Pagination
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$per_page = 10;
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : null;

// Posts abrufen
if ($category_id) {
    $posts = $blogPost->getByCategory($category_id, $page, $per_page);
    $total_posts = $blogPost->getTotal('published'); // Vereinfacht
    $current_category = $blogCategory->getById($category_id);
} else {
    $posts = $blogPost->getAll($page, $per_page, 'published');
    $total_posts = $blogPost->getTotal('published');
    $current_category = null;
}

$categories = $blogCategory->getAll();
$total_pages = ceil($total_posts / $per_page);

// SEO
$page_title = $current_category ? $current_category['name'] . ' - Blog' : 'Blog';
$page_description = $current_category['description'] ?? 'Artikel und Insights zu KI, Automation, Webentwicklung und Fotografie.';

include 'includes/header.php';
?>

<!-- Blog Header -->
<section class="hero-section" style="padding: 80px 20px 60px;">
    <div class="container">
        <h1 style="font-size: 48px; margin-bottom: 20px;">
            <?php echo $current_category ? htmlspecialchars($current_category['name']) : 'Blog'; ?>
        </h1>
        <p style="font-size: 18px; color: var(--color-text-secondary); max-width: 600px;">
            <?php echo htmlspecialchars($page_description); ?>
        </p>
    </div>
</section>

<!-- Blog Content -->
<section style="padding: 40px 20px 100px; background: var(--color-bg-secondary);">
    <div class="container" style="max-width: 1200px;">
        <div style="display: grid; grid-template-columns: 1fr 300px; gap: 40px;">
            <!-- Posts -->
            <div>
                <?php if (empty($posts)): ?>
                    <div style="text-align: center; padding: 60px 20px; background: var(--color-bg-primary); border-radius: 16px;">
                        <i class="fas fa-blog" style="font-size: 48px; opacity: 0.3; margin-bottom: 20px; display: block;"></i>
                        <p style="color: var(--color-text-secondary);">Noch keine Blog-Posts vorhanden.</p>
                    </div>
                <?php else: ?>
                    <div class="blog-grid">
                        <?php foreach ($posts as $post): ?>
                        <article class="blog-card">
                            <?php if ($post['featured_image']): ?>
                                <div class="blog-card-image">
                                    <img src="<?php echo htmlspecialchars($post['featured_image']); ?>" 
                                         alt="<?php echo htmlspecialchars($post['title']); ?>">
                                </div>
                            <?php endif; ?>
                            
                            <div class="blog-card-content">
                                <div class="blog-card-meta">
                                    <?php if ($post['category_name']): ?>
                                        <span class="blog-category"><?php echo htmlspecialchars($post['category_name']); ?></span>
                                    <?php endif; ?>
                                    <span class="blog-date">
                                        <?php echo date('d. M Y', strtotime($post['published_at'] ?? $post['created_at'])); ?>
                                    </span>
                                </div>
                                
                                <h2 class="blog-card-title">
                                    <a href="/blog/<?php echo htmlspecialchars($post['slug']); ?>">
                                        <?php echo htmlspecialchars($post['title']); ?>
                                    </a>
                                </h2>
                                
                                <?php if ($post['excerpt']): ?>
                                    <p class="blog-card-excerpt">
                                        <?php echo htmlspecialchars($post['excerpt']); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <a href="/blog/<?php echo htmlspecialchars($post['slug']); ?>" class="blog-read-more">
                                    Weiterlesen →
                                </a>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if ($total_pages > 1): ?>
                        <div class="pagination">
                            <?php if ($page > 1): ?>
                                <a href="?page=<?php echo $page - 1; ?><?php echo $category_id ? '&category=' . $category_id : ''; ?>" 
                                   class="pagination-btn">← Vorherige</a>
                            <?php endif; ?>
                            
                            <span class="pagination-info">
                                Seite <?php echo $page; ?> von <?php echo $total_pages; ?>
                            </span>
                            
                            <?php if ($page < $total_pages): ?>
                                <a href="?page=<?php echo $page + 1; ?><?php echo $category_id ? '&category=' . $category_id : ''; ?>" 
                                   class="pagination-btn">Nächste →</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <aside class="blog-sidebar">
                <div class="sidebar-widget">
                    <h3>Kategorien</h3>
                    <ul class="category-list">
                        <li>
                            <a href="/blog.php" class="<?php echo !$category_id ? 'active' : ''; ?>">
                                Alle Artikel
                            </a>
                        </li>
                        <?php foreach ($categories as $cat): ?>
                            <li>
                                <a href="?category=<?php echo $cat['id']; ?>" 
                                   class="<?php echo $category_id == $cat['id'] ? 'active' : ''; ?>">
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>

<style>
.blog-grid {
    display: grid;
    gap: 32px;
    margin-bottom: 40px;
}

.blog-card {
    background: var(--color-bg-primary);
    border-radius: 16px;
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.blog-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(99, 102, 241, 0.2);
}

.blog-card-image {
    aspect-ratio: 16/9;
    overflow: hidden;
}

.blog-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.blog-card:hover .blog-card-image img {
    transform: scale(1.05);
}

.blog-card-content {
    padding: 24px;
}

.blog-card-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
    font-size: 14px;
}

.blog-category {
    background: rgba(99, 102, 241, 0.1);
    color: var(--color-accent-primary);
    padding: 4px 12px;
    border-radius: 12px;
    font-weight: 600;
}

.blog-date {
    color: var(--color-text-secondary);
}

.blog-card-title a {
    color: var(--color-text-primary);
    text-decoration: none;
    font-size: 24px;
    font-weight: 700;
    line-height: 1.3;
    display: block;
    margin-bottom: 12px;
}

.blog-card-title a:hover {
    color: var(--color-accent-primary);
}

.blog-card-excerpt {
    color: var(--color-text-secondary);
    line-height: 1.6;
    margin-bottom: 16px;
}

.blog-read-more {
    color: var(--color-accent-primary);
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.blog-read-more:hover {
    gap: 12px;
}

.pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    margin-top: 40px;
}

.pagination-btn {
    padding: 12px 24px;
    background: var(--color-bg-primary);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    color: var(--color-text-primary);
    text-decoration: none;
    transition: all 0.3s;
}

.pagination-btn:hover {
    background: var(--color-accent-primary);
    border-color: var(--color-accent-primary);
}

.pagination-info {
    color: var(--color-text-secondary);
}

/* Sidebar */
.blog-sidebar {
    position: sticky;
    top: 20px;
    height: fit-content;
}

.sidebar-widget {
    background: var(--color-bg-primary);
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
}

.sidebar-widget h3 {
    margin-bottom: 20px;
    font-size: 18px;
}

.category-list {
    list-style: none;
}

.category-list li {
    margin-bottom: 8px;
}

.category-list a {
    display: block;
    padding: 10px 16px;
    color: var(--color-text-secondary);
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.2s;
}

.category-list a:hover,
.category-list a.active {
    background: rgba(99, 102, 241, 0.1);
    color: var(--color-accent-primary);
}

@media (max-width: 968px) {
    .container > div {
        grid-template-columns: 1fr !important;
    }
    
    .blog-sidebar {
        position: static;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
