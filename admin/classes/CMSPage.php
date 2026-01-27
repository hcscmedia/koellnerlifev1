<?php
/**
 * CMS Page Model Class
 */

class CMSPage {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getAll() {
        return $this->db->fetchAll(
            "SELECT cp.*, au.full_name as author_name
             FROM cms_pages cp
             LEFT JOIN admin_users au ON cp.author_id = au.id
             ORDER BY cp.created_at DESC"
        );
    }
    
    public function getById($id) {
        return $this->db->fetchOne(
            "SELECT cp.*, au.full_name as author_name
             FROM cms_pages cp
             LEFT JOIN admin_users au ON cp.author_id = au.id
             WHERE cp.id = ?",
            [$id]
        );
    }
    
    public function getBySlug($slug) {
        return $this->db->fetchOne(
            "SELECT * FROM cms_pages WHERE slug = ? AND status = 'published'",
            [$slug]
        );
    }
    
    public function create($data) {
        if (empty($data['slug'])) {
            $data['slug'] = $this->generateSlug($data['title']);
        }
        
        $data['slug'] = $this->ensureUniqueSlug($data['slug']);
        
        $published_at = ($data['status'] === 'published') ? date('Y-m-d H:i:s') : null;
        
        return $this->db->insert(
            "INSERT INTO cms_pages 
             (title, slug, content, template, status, author_id, published_at, meta_title, meta_description)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $data['title'],
                $data['slug'],
                $data['content'],
                $data['template'] ?? 'default',
                $data['status'] ?? 'draft',
                $data['author_id'],
                $published_at,
                $data['meta_title'] ?? $data['title'],
                $data['meta_description'] ?? null
            ]
        );
    }
    
    public function update($id, $data) {
        $current = $this->getById($id);
        $published_at_sql = "";
        $published_at_param = null;
        
        if (isset($data['status']) && $data['status'] === 'published' && $current['status'] !== 'published') {
            $published_at_sql = ", published_at = ?";
            $published_at_param = date('Y-m-d H:i:s');
        }
        
        $sql = "UPDATE cms_pages SET 
                title = ?,
                slug = ?,
                content = ?,
                template = ?,
                status = ?,
                meta_title = ?,
                meta_description = ?
                {$published_at_sql}
                WHERE id = ?";
        
        $params = [
            $data['title'],
            $data['slug'],
            $data['content'],
            $data['template'] ?? 'default',
            $data['status'] ?? 'draft',
            $data['meta_title'] ?? $data['title'],
            $data['meta_description'] ?? null
        ];
        
        if ($published_at_param) {
            $params[] = $published_at_param;
        }
        
        $params[] = $id;
        
        return $this->db->execute($sql, $params);
    }
    
    public function delete($id) {
        return $this->db->execute("DELETE FROM cms_pages WHERE id = ?", [$id]);
    }
    
    private function generateSlug($title) {
        $replacements = [
            'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue',
            'Ä' => 'Ae', 'Ö' => 'Oe', 'Ü' => 'Ue',
            'ß' => 'ss'
        ];
        
        $slug = str_replace(array_keys($replacements), array_values($replacements), $title);
        $slug = strtolower($slug);
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        
        return trim($slug, '-');
    }
    
    private function ensureUniqueSlug($slug, $exclude_id = null) {
        $original_slug = $slug;
        $counter = 1;
        
        while (true) {
            $sql = "SELECT COUNT(*) as count FROM cms_pages WHERE slug = ?";
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
}
