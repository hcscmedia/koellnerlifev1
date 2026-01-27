const express = require('express');
const cors = require('cors');
const bodyParser = require('body-parser');
const path = require('path');
require('dotenv').config();

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(cors());
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// Serve static files
app.use(express.static(path.join(__dirname)));

// API Routes
const authRoutes = require('./api/routes/auth');
const contentRoutes = require('./api/routes/content');
const servicesRoutes = require('./api/routes/services');
const messagesRoutes = require('./api/routes/messages');

app.use('/api/auth', authRoutes);
app.use('/api/content', contentRoutes);
app.use('/api/services', servicesRoutes);
app.use('/api/messages', messagesRoutes);

// Serve admin panel
app.get('/admin*', (req, res) => {
    res.sendFile(path.join(__dirname, 'admin', 'index.html'));
});

// Health check
app.get('/api/health', (req, res) => {
    res.json({ status: 'ok', message: 'CMS API is running' });
});

// Error handling middleware
app.use((err, req, res, next) => {
    console.error(err.stack);
    res.status(500).json({ error: 'Something went wrong!' });
});

// Start server
app.listen(PORT, () => {
    console.log(`🚀 Server running on http://localhost:${PORT}`);
    console.log(`📊 Admin panel: http://localhost:${PORT}/admin`);
    console.log(`🔌 API endpoint: http://localhost:${PORT}/api`);
});
