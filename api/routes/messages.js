const express = require('express');
const router = express.Router();
const { get, all, run } = require('../database');
const authMiddleware = require('../middleware/auth');

// Submit contact message (public)
router.post('/', async (req, res) => {
    try {
        const { name, email, message } = req.body;

        if (!name || !email || !message) {
            return res.status(400).json({ error: 'All fields are required' });
        }

        const result = await run(
            'INSERT INTO messages (name, email, message) VALUES (?, ?, ?)',
            [name, email, message]
        );

        res.status(201).json({ 
            id: result.id,
            message: 'Message sent successfully' 
        });
    } catch (error) {
        console.error('Error saving message:', error);
        res.status(500).json({ error: 'Failed to send message' });
    }
});

// Get all messages (protected)
router.get('/', authMiddleware, async (req, res) => {
    try {
        const messages = await all('SELECT * FROM messages ORDER BY created_at DESC');
        res.json(messages);
    } catch (error) {
        console.error('Error fetching messages:', error);
        res.status(500).json({ error: 'Failed to fetch messages' });
    }
});

// Mark message as read (protected)
router.put('/:id/read', authMiddleware, async (req, res) => {
    try {
        const result = await run(
            'UPDATE messages SET read = 1 WHERE id = ?',
            [req.params.id]
        );

        if (result.changes === 0) {
            return res.status(404).json({ error: 'Message not found' });
        }

        const message = await get('SELECT * FROM messages WHERE id = ?', [req.params.id]);
        res.json(message);
    } catch (error) {
        console.error('Error updating message:', error);
        res.status(500).json({ error: 'Failed to update message' });
    }
});

// Delete message (protected)
router.delete('/:id', authMiddleware, async (req, res) => {
    try {
        const result = await run('DELETE FROM messages WHERE id = ?', [req.params.id]);
        
        if (result.changes === 0) {
            return res.status(404).json({ error: 'Message not found' });
        }

        res.json({ message: 'Message deleted successfully' });
    } catch (error) {
        console.error('Error deleting message:', error);
        res.status(500).json({ error: 'Failed to delete message' });
    }
});

module.exports = router;
