const bcrypt = require('bcryptjs');
const { run, get, all, initDB } = require('../api/database');

// Initialize database and create default data
async function initializeDatabase() {
    try {
        // Initialize tables
        initDB();

        // Wait a bit for tables to be created
        await new Promise(resolve => setTimeout(resolve, 1000));

        // Create default admin user
        const adminUsername = process.env.ADMIN_USERNAME || 'admin';
        const adminPassword = process.env.ADMIN_PASSWORD || 'admin123';
        
        const existingUser = await get('SELECT * FROM users WHERE username = ?', [adminUsername]);
        
        if (!existingUser) {
            const passwordHash = await bcrypt.hash(adminPassword, 10);
            await run('INSERT INTO users (username, password_hash) VALUES (?, ?)', 
                [adminUsername, passwordHash]);
            console.log(`✅ Default admin user created: ${adminUsername}`);
        }

        // Insert default content
        const defaultContent = [
            {
                section: 'hero',
                title: 'Willkommen bei Koellner.life',
                subtitle: 'Moderne digitale Lösungen für die Zukunft mit KI-Innovation',
                description: null
            },
            {
                section: 'about',
                title: 'Über mich',
                subtitle: 'Professionelle digitale Lösungen',
                description: null
            },
            {
                section: 'services',
                title: 'Leistungen',
                subtitle: 'Maßgeschneiderte Lösungen für Ihre Bedürfnisse',
                description: null
            },
            {
                section: 'contact',
                title: 'Kontakt',
                subtitle: 'Lassen Sie uns zusammenarbeiten',
                description: null
            }
        ];

        for (const content of defaultContent) {
            const existing = await get('SELECT * FROM content WHERE section = ?', [content.section]);
            if (!existing) {
                await run(
                    'INSERT INTO content (section, title, subtitle, description) VALUES (?, ?, ?, ?)',
                    [content.section, content.title, content.subtitle, content.description]
                );
            }
        }

        // Insert default services
        const defaultServices = [
            {
                number: '01',
                title: 'Web Development',
                description: 'Moderne, responsive Websites mit neuesten Technologien und Best Practices.',
                icon: 'code',
                order_index: 1
            },
            {
                number: '02',
                title: 'UI/UX Design',
                description: 'Benutzerfreundliche Interfaces mit Fokus auf optimale User Experience.',
                icon: 'design',
                order_index: 2
            },
            {
                number: '03',
                title: 'Digital Consulting',
                description: 'Strategische Beratung für Ihre digitale Transformation und Optimierung.',
                icon: 'consulting',
                order_index: 3
            },
            {
                number: '04',
                title: 'Performance',
                description: 'Optimierung für schnelle Ladezeiten und beste Performance-Werte.',
                icon: 'performance',
                order_index: 4
            }
        ];

        for (const service of defaultServices) {
            const existing = await get('SELECT * FROM services WHERE title = ?', [service.title]);
            if (!existing) {
                await run(
                    'INSERT INTO services (number, title, description, icon, order_index) VALUES (?, ?, ?, ?, ?)',
                    [service.number, service.title, service.description, service.icon, service.order_index]
                );
            }
        }

        console.log('✅ Database initialized with default data');
        console.log(`📝 Admin credentials: ${adminUsername} / ${adminPassword}`);
        console.log('⚠️  Please change the default password in production!');
        
    } catch (error) {
        console.error('Error initializing database:', error);
        process.exit(1);
    }
}

// Run if executed directly
if (require.main === module) {
    require('dotenv').config();
    initializeDatabase().then(() => {
        console.log('Database initialization complete!');
        process.exit(0);
    });
}

module.exports = initializeDatabase;
