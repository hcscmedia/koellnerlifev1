<?php
/**
 * Blog Post Model Class
 * CRUD Operationen für Blog Posts
 */

class BlogPost {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Alle Posts abrufen (mit Pagination)
     */
    public function getAll($page = 1, $per_page = 20, $status = null) {
        $offset = ($page - 1) * $per_page;
        
        $where = $status ? "WHERE bp.status = ?" : "";
        $params = $status ? [$status] : [];
        
        $sql = "SELECT bp.*, 
                       au.full_name as author_name,
                       bc.name as category_name
                FROM blog_posts bp
                LEFT JOIN admin_users au ON bp.author_id = au.id
                LEFT JOIN blog_categories bc ON bp.category_id = bc.id
                {$where}
                ORDER BY bp.created_at DESC
                LIMIT ? OFFSET ?";
        
        $params[] = $per_page;
        $params[] = $offset;
        
        return $this->db->fetchAll($sql, $params);
    }
    
    /**
     * Einzelnen Post abrufen
     */
    public function getById($id) {
        return $this->db->fetchOne(
            "SELECT bp.*, 
                    au.full_name as author_name,
                    bc.name as category_name
             FROM blog_posts bp
             LEFT JOIN admin_users au ON bp.author_id = au.id
             LEFT JOIN blog_categories bc ON bp.category_id = bc.id
             WHERE bp.id = ?",
            [$id]
        );
    }
    
    /**
     * Post per Slug abrufen
     */
    public function getBySlug($slug) {
        return $this->db->fetchOne(
            "SELECT bp.*, 
                    au.full_name as author_name,
                    bc.name as category_name
             FROM blog_posts bp
             LEFT JOIN admin_users au ON bp.author_id = au.id
             LEFT JOIN blog_categories bc ON bp.category_id = bc.id
             WHERE bp.slug = ? AND bp.status = 'published'",
            [$slug]
        );
    }
    
    /**
     * Neuen Post erstellen
     */
    public function create($data) {
        // Slug generieren wenn nicht vorhanden
        if (empty($data['slug'])) {
            $data['slug'] = $this->generateSlug($data['title']);
        } else {
            $data['slug'] = $this->sanitizeSlug($data['slug']);
        }
        
        // Slug-Eindeutigkeit prüfen
        $data['slug'] = $this->ensureUniqueSlug($data['slug']);
        
        $sql = "INSERT INTO blog_posts 
                (title, slug, excerpt, content, featured_image, author_id, category_id, 
                 status, published_at, meta_title, meta_description, meta_keywords)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $published_at = ($data['status'] === 'published') ? date('Y-m-d H:i:s') : null;
        
        return $this->db->insert($sql, [
            $data['title'],
            $data['slug'],
            $data['excerpt'] ?? null,
            $data['content'],
            $data['featured_image'] ?? null,
            $data['author_id'],
            $data['category_id'] ?? null,
            $data['status'] ?? 'draft',
            $published_at,
            $data['meta_title'] ?? $data['title'],
            $data['meta_description'] ?? $data['excerpt'] ?? null,
            $data['meta_keywords'] ?? null
        ]);
    }
    
    /**
     * Post aktualisieren
     */
    public function update($id, $data) {
        // Slug aktualisieren wenn geändert
        if (isset($data['slug'])) {
            $data['slug'] = $this->sanitizeSlug($data['slug']);
            $data['slug'] = $this->ensureUniqueSlug($data['slug'], $id);
        }
        
        // Published_at setzen wenn Status auf published geändert wird
        $current = $this->getById($id);
        $published_at_sql = "";
        $published_at_param = null;
        
        if (isset($data['status']) && $data['status'] === 'published' && $current['status'] !== 'published') {
            $published_at_sql = ", published_at = ?";
            $published_at_param = date('Y-m-d H:i:s');
        }
        
        $sql = "UPDATE blog_posts SET 
                title = ?,
                slug = ?,
                excerpt = ?,
                content = ?,
                featured_image = ?,
                category_id = ?,
                status = ?,
                meta_title = ?,
                meta_description = ?,
                meta_keywords = ?
                {$published_at_sql}
                WHERE id = ?";
        
        $params = [
            $data['title'],
            $data['slug'],
            $data['excerpt'] ?? null,
            $data['content'],
            $data['featured_image'] ?? null,
            $data['category_id'] ?? null,
            $data['status'] ?? 'draft',
            $data['meta_title'] ?? $data['title'],
            $data['meta_description'] ?? $data['excerpt'] ?? null,
            $data['meta_keywords'] ?? null
        ];
        
        if ($published_at_param) {
            $params[] = $published_at_param;
        }
        
        $params[] = $id;
        
        return $this->db->execute($sql, $params);
    }
    
    /**
     * Post löschen
     */
    public function delete($id) {
        return $this->db->execute("DELETE FROM blog_posts WHERE id = ?", [$id]);
    }
    
    /**
     * Views erhöhen
     */
    public function incrementViews($id) {
        return $this->db->execute(
            "UPDATE blog_posts SET views_count = views_count + 1 WHERE id = ?",
            [$id]
        );
    }
    
    /**
     * Slug aus Titel generieren
     */
    private function generateSlug($title) {
        // Umlaute ersetzen
        $replacements = [
            'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue',
            'Ä' => 'Ae', 'Ö' => 'Oe', 'Ü' => 'Ue',
            'ß' => 'ss'
        ];
        
        $slug = str_replace(array_keys($replacements), array_values($replacements), $title);
        $slug = strtolower($slug);
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        
        return $slug;
    }
    
    /**
     * Slug bereinigen
     */
    private function sanitizeSlug($slug) {
        $slug = strtolower($slug);
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return trim($slug, '-');
    }
    
    /**
     * Eindeutigen Slug sicherstellen
     */
    private function ensureUniqueSlug($slug, $exclude_id = null) {
        $original_slug = $slug;
        $counter = 1;
        
        while (true) {
            $sql = "SELECT COUNT(*) as count FROM blog_posts WHERE slug = ?";
            $params = [$slug];
            
            if ($exclude_id) {
                $sql .= " AND id != ?";
                $params[] = $exclude_id;
            }
            
            $result = $this->db->fetchOne($sql, $params);
            
            if ($result['count'] == 0) {
                break;
            }
            
            $slug = $original_slug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
    
    /**
     * Gesamt-Anzahl Posts
     */
    public function getTotal($status = null) {
        $where = $status ? "WHERE status = ?" : "";
        $params = $status ? [$status] : [];
        
        $result = $this->db->fetchOne(
            "SELECT COUNT(*) as count FROM blog_posts {$where}",
            $params
        );
        
        return $result['count'] ?? 0;
    }
    
    /**
     * Posts nach Kategorie
     */
    public function getByCategory($category_id, $page = 1, $per_page = 10) {
        $offset = ($page - 1) * $per_page;
        
        return $this->db->fetchAll(
            "SELECT bp.*, au.full_name as author_name, bc.name as category_name
             FROM blog_posts bp
             LEFT JOIN admin_users au ON bp.author_id = au.id
             LEFT JOIN blog_categories bc ON bp.category_id = bc.id
             WHERE bp.category_id = ? AND bp.status = 'published'
             ORDER BY bp.published_at DESC
             LIMIT ? OFFSET ?",
            [$category_id, $per_page, $offset]
        );
    }
    
    /**
     * Suche
     */
    public function search($query, $page = 1, $per_page = 10) {
        $offset = ($page - 1) * $per_page;
        $search_term = '%' . $query . '%';
        
        return $this->db->fetchAll(
            "SELECT bp.*, au.full_name as author_name, bc.name as category_name
             FROM blog_posts bp
             LEFT JOIN admin_users au ON bp.author_id = au.id
             LEFT JOIN blog_categories bc ON bp.category_id = bc.id
             WHERE (bp.title LIKE ? OR bp.content LIKE ?) AND bp.status = 'published'
             ORDER BY bp.published_at DESC
             LIMIT ? OFFSET ?",
            [$search_term, $search_term, $per_page, $offset]
        );
    }
}
