const express = require('express');
const router = express.Router();
const { get, all, run } = require('../database');
const authMiddleware = require('../middleware/auth');

// Get all content (public)
router.get('/', async (req, res) => {
    try {
        const content = await all('SELECT * FROM content');
        res.json(content);
    } catch (error) {
        console.error('Error fetching content:', error);
        res.status(500).json({ error: 'Failed to fetch content' });
    }
});

// Get content by section (public)
router.get('/:section', async (req, res) => {
    try {
        const content = await get('SELECT * FROM content WHERE section = ?', [req.params.section]);
        if (!content) {
            return res.status(404).json({ error: 'Content not found' });
        }
        res.json(content);
    } catch (error) {
        console.error('Error fetching content:', error);
        res.status(500).json({ error: 'Failed to fetch content' });
    }
});

// Update content (protected)
router.put('/:section', authMiddleware, async (req, res) => {
    try {
        const { title, subtitle, description } = req.body;
        const { section } = req.params;

        const result = await run(
            `UPDATE content 
             SET title = ?, subtitle = ?, description = ?, updated_at = CURRENT_TIMESTAMP 
             WHERE section = ?`,
            [title, subtitle, description, section]
        );

        if (result.changes === 0) {
            return res.status(404).json({ error: 'Content not found' });
        }

        const updated = await get('SELECT * FROM content WHERE section = ?', [section]);
        res.json(updated);
    } catch (error) {
        console.error('Error updating content:', error);
        res.status(500).json({ error: 'Failed to update content' });
    }
});

module.exports = router;
