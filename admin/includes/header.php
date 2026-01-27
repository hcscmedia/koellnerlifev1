<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Dashboard'; ?> - Admin Panel</title>
    <link rel="stylesheet" href="/assets/css/admin-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <h2><?php echo SITE_NAME; ?></h2>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-item">
                    <a href="/admin/dashboard.php" class="nav-link <?php echo ($current_page ?? '') === 'dashboard' ? 'active' : ''; ?>">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="/admin/blog/posts.php" class="nav-link <?php echo ($current_page ?? '') === 'blog' ? 'active' : ''; ?>">
                        <i class="fas fa-blog"></i>
                        <span>Blog Posts</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="/admin/blog/categories.php" class="nav-link <?php echo ($current_page ?? '') === 'categories' ? 'active' : ''; ?>">
                        <i class="fas fa-folder"></i>
                        <span>Kategorien</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="/admin/cms/pages.php" class="nav-link <?php echo ($current_page ?? '') === 'pages' ? 'active' : ''; ?>">
                        <i class="fas fa-file-alt"></i>
                        <span>CMS Seiten</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="/admin/media/library.php" class="nav-link <?php echo ($current_page ?? '') === 'media' ? 'active' : ''; ?>">
                        <i class="fas fa-images"></i>
                        <span>Medien</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="/admin/contacts.php" class="nav-link <?php echo ($current_page ?? '') === 'contacts' ? 'active' : ''; ?>">
                        <i class="fas fa-envelope"></i>
                        <span>Kontakte</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="/admin/settings.php" class="nav-link <?php echo ($current_page ?? '') === 'settings' ? 'active' : ''; ?>">
                        <i class="fas fa-cog"></i>
                        <span>Einstellungen</span>
                    </a>
                </div>
                
                <div class="nav-item" style="margin-top: 20px; border-top: 1px solid var(--admin-border); padding-top: 20px;">
                    <a href="<?php echo SITE_URL; ?>" class="nav-link" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                        <span>Website ansehen</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="/admin/logout.php" class="nav-link" style="color: var(--admin-danger);">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Abmelden</span>
                    </a>
                </div>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <div>
                    <h1><?php echo $page_title ?? 'Dashboard'; ?></h1>
                </div>
                
                <div class="admin-user">
                    <div class="admin-user-info">
                        <div class="admin-user-name"><?php echo htmlspecialchars($admin['full_name'] ?? 'Admin'); ?></div>
                        <div class="admin-user-role">Administrator</div>
                    </div>
                    <div class="admin-avatar">
                        <i class="fas fa-user-circle" style="font-size: 32px; color: var(--admin-primary);"></i>
                    </div>
                </div>
            </header>
            
            <!-- Content Area -->
            <div class="admin-content">
