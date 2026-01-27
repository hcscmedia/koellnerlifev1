<?php
/**
 * Blog Category Model Class
 */

class BlogCategory {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getAll() {
        return $this->db->fetchAll(
            "SELECT * FROM blog_categories ORDER BY name ASC"
        );
    }
    
    public function getById($id) {
        return $this->db->fetchOne(
            "SELECT * FROM blog_categories WHERE id = ?",
            [$id]
        );
    }
    
    public function getBySlug($slug) {
        return $this->db->fetchOne(
            "SELECT * FROM blog_categories WHERE slug = ?",
            [$slug]
        );
    }
    
    public function create($data) {
        if (empty($data['slug'])) {
            $data['slug'] = $this->generateSlug($data['name']);
        }
        
        return $this->db->insert(
            "INSERT INTO blog_categories (name, slug, description) VALUES (?, ?, ?)",
            [$data['name'], $data['slug'], $data['description'] ?? null]
        );
    }
    
    public function update($id, $data) {
        return $this->db->execute(
            "UPDATE blog_categories SET name = ?, slug = ?, description = ? WHERE id = ?",
            [$data['name'], $data['slug'], $data['description'] ?? null, $id]
        );
    }
    
    public function delete($id) {
        return $this->db->execute(
            "DELETE FROM blog_categories WHERE id = ?",
            [$id]
        );
    }
    
    private function generateSlug($name) {
        $replacements = [
            'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue',
            'Ä' => 'Ae', 'Ö' => 'Oe', 'Ü' => 'Ue',
            'ß' => 'ss'
        ];
        
        $slug = str_replace(array_keys($replacements), array_values($replacements), $name);
        $slug = strtolower($slug);
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        
        return trim($slug, '-');
    }
}
