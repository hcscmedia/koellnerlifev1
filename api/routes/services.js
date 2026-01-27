const express = require('express');
const router = express.Router();
const { get, all, run } = require('../database');
const authMiddleware = require('../middleware/auth');

// Get all services (public)
router.get('/', async (req, res) => {
    try {
        const services = await all('SELECT * FROM services WHERE active = 1 ORDER BY order_index');
        res.json(services);
    } catch (error) {
        console.error('Error fetching services:', error);
        res.status(500).json({ error: 'Failed to fetch services' });
    }
});

// Get service by ID (protected)
router.get('/:id', authMiddleware, async (req, res) => {
    try {
        const service = await get('SELECT * FROM services WHERE id = ?', [req.params.id]);
        if (!service) {
            return res.status(404).json({ error: 'Service not found' });
        }
        res.json(service);
    } catch (error) {
        console.error('Error fetching service:', error);
        res.status(500).json({ error: 'Failed to fetch service' });
    }
});

// Create service (protected)
router.post('/', authMiddleware, async (req, res) => {
    try {
        const { number, title, description, icon, order_index } = req.body;

        const result = await run(
            'INSERT INTO services (number, title, description, icon, order_index) VALUES (?, ?, ?, ?, ?)',
            [number, title, description, icon, order_index]
        );

        const service = await get('SELECT * FROM services WHERE id = ?', [result.id]);
        res.status(201).json(service);
    } catch (error) {
        console.error('Error creating service:', error);
        res.status(500).json({ error: 'Failed to create service' });
    }
});

// Update service (protected)
router.put('/:id', authMiddleware, async (req, res) => {
    try {
        const { number, title, description, icon, active, order_index } = req.body;

        const result = await run(
            `UPDATE services 
             SET number = ?, title = ?, description = ?, icon = ?, active = ?, order_index = ?
             WHERE id = ?`,
            [number, title, description, icon, active ? 1 : 0, order_index, req.params.id]
        );

        if (result.changes === 0) {
            return res.status(404).json({ error: 'Service not found' });
        }

        const service = await get('SELECT * FROM services WHERE id = ?', [req.params.id]);
        res.json(service);
    } catch (error) {
        console.error('Error updating service:', error);
        res.status(500).json({ error: 'Failed to update service' });
    }
});

// Delete service (protected)
router.delete('/:id', authMiddleware, async (req, res) => {
    try {
        const result = await run('DELETE FROM services WHERE id = ?', [req.params.id]);
        
        if (result.changes === 0) {
            return res.status(404).json({ error: 'Service not found' });
        }

        res.json({ message: 'Service deleted successfully' });
    } catch (error) {
        console.error('Error deleting service:', error);
        res.status(500).json({ error: 'Failed to delete service' });
    }
});

module.exports = router;
