// Admin Panel JavaScript
const API_URL = window.location.origin + '/api';
let authToken = localStorage.getItem('adminToken');

// Elements
const loginScreen = document.getElementById('login-screen');
const adminDashboard = document.getElementById('admin-dashboard');
const loginForm = document.getElementById('login-form');
const loginError = document.getElementById('login-error');
const logoutBtn = document.getElementById('logout-btn');
const userName = document.getElementById('user-name');

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    if (authToken) {
        verifyToken();
    } else {
        showLogin();
    }
});

// Login
loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(loginForm);
    const credentials = {
        username: formData.get('username'),
        password: formData.get('password')
    };

    try {
        const response = await fetch(`${API_URL}/auth/login`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(credentials)
        });

        const data = await response.json();

        if (response.ok) {
            authToken = data.token;
            localStorage.setItem('adminToken', authToken);
            showDashboard(data.user);
        } else {
            showError(data.error || 'Login fehlgeschlagen');
        }
    } catch (error) {
        showError('Verbindungsfehler');
    }
});

// Verify token
async function verifyToken() {
    try {
        const response = await fetch(`${API_URL}/auth/verify`, {
            headers: { 'Authorization': `Bearer ${authToken}` }
        });

        const data = await response.json();

        if (data.valid) {
            showDashboard(data.user);
        } else {
            showLogin();
        }
    } catch (error) {
        showLogin();
    }
}

// Logout
logoutBtn.addEventListener('click', () => {
    localStorage.removeItem('adminToken');
    authToken = null;
    showLogin();
});

// Show/Hide screens
function showLogin() {
    loginScreen.style.display = 'flex';
    adminDashboard.style.display = 'none';
}

function showDashboard(user) {
    loginScreen.style.display = 'none';
    adminDashboard.style.display = 'block';
    userName.textContent = user.username;
    loadDashboard();
}

function showError(message) {
    loginError.textContent = message;
    loginError.style.display = 'block';
}

// Navigation
document.querySelectorAll('.menu-item').forEach(item => {
    item.addEventListener('click', (e) => {
        e.preventDefault();
        const section = item.dataset.section;
        switchSection(section);
    });
});

function switchSection(section) {
    // Update menu
    document.querySelectorAll('.menu-item').forEach(item => {
        item.classList.remove('active');
    });
    document.querySelector(`[data-section="${section}"]`).classList.add('active');

    // Update sections
    document.querySelectorAll('.admin-section').forEach(sec => {
        sec.style.display = 'none';
    });
    document.getElementById(`section-${section}`).style.display = 'block';

    // Load data
    if (section === 'dashboard') loadDashboard();
    if (section === 'content') loadContent();
    if (section === 'services') loadServices();
    if (section === 'messages') loadMessages();
}

// Dashboard
async function loadDashboard() {
    try {
        const [content, services, messages] = await Promise.all([
            fetchAPI('/content'),
            fetchAPI('/services'),
            fetchAPI('/messages')
        ]);

        document.getElementById('content-count').textContent = content.length;
        document.getElementById('services-count').textContent = services.length;
        document.getElementById('messages-count').textContent = messages.length;
        
        const unread = messages.filter(m => !m.read).length;
        document.getElementById('unread-messages').textContent = unread;
        
        const unreadBadge = document.getElementById('unread-count');
        if (unread > 0) {
            unreadBadge.textContent = unread;
            unreadBadge.style.display = 'inline-block';
        } else {
            unreadBadge.style.display = 'none';
        }
    } catch (error) {
        console.error('Error loading dashboard:', error);
    }
}

// Content Management
async function loadContent() {
    try {
        const content = await fetchAPI('/content');
        const container = document.getElementById('content-list');
        
        container.innerHTML = content.map(item => `
            <div class="content-card glass-card">
                <h3>${item.section}</h3>
                <p><strong>Titel:</strong> ${item.title || 'N/A'}</p>
                <p><strong>Untertitel:</strong> ${item.subtitle || 'N/A'}</p>
                <button onclick="editContent('${item.section}')" class="btn btn-primary">Bearbeiten</button>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading content:', error);
    }
}

window.editContent = async function(section) {
    try {
        const content = await fetchAPI(`/content/${section}`);
        
        document.getElementById('edit-section').value = content.section;
        document.getElementById('edit-title').value = content.title || '';
        document.getElementById('edit-subtitle').value = content.subtitle || '';
        document.getElementById('edit-description').value = content.description || '';
        
        showModal('edit-content-modal');
    } catch (error) {
        alert('Fehler beim Laden des Inhalts');
    }
};

document.getElementById('edit-content-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const section = formData.get('section');
    const data = {
        title: formData.get('title'),
        subtitle: formData.get('subtitle'),
        description: formData.get('description')
    };

    try {
        await fetchAPI(`/content/${section}`, 'PUT', data);
        hideModal('edit-content-modal');
        loadContent();
        alert('Inhalt erfolgreich aktualisiert!');
    } catch (error) {
        alert('Fehler beim Speichern');
    }
});

// Services Management
async function loadServices() {
    try {
        const services = await fetchAPI('/services');
        const container = document.getElementById('services-list');
        
        container.innerHTML = services.map(service => `
            <div class="service-card glass-card">
                <div class="service-number">${service.number}</div>
                <h3>${service.title}</h3>
                <p>${service.description}</p>
                <div class="service-actions">
                    <button onclick="editService(${service.id})" class="btn btn-primary">Bearbeiten</button>
                    <button onclick="deleteService(${service.id})" class="btn btn-danger">Löschen</button>
                </div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading services:', error);
    }
}

document.getElementById('add-service-btn').addEventListener('click', () => {
    document.getElementById('service-modal-title').textContent = 'Neue Leistung';
    document.getElementById('edit-service-form').reset();
    document.getElementById('edit-service-id').value = '';
    showModal('edit-service-modal');
});

window.editService = async function(id) {
    try {
        const service = await fetchAPI(`/services/${id}`);
        
        document.getElementById('service-modal-title').textContent = 'Leistung bearbeiten';
        document.getElementById('edit-service-id').value = service.id;
        document.getElementById('edit-service-number').value = service.number || '';
        document.getElementById('edit-service-title').value = service.title;
        document.getElementById('edit-service-description').value = service.description;
        document.getElementById('edit-service-icon').value = service.icon || '';
        document.getElementById('edit-service-order').value = service.order_index || 1;
        document.getElementById('edit-service-active').checked = service.active;
        
        showModal('edit-service-modal');
    } catch (error) {
        alert('Fehler beim Laden der Leistung');
    }
};

window.deleteService = async function(id) {
    if (!confirm('Möchten Sie diese Leistung wirklich löschen?')) return;
    
    try {
        await fetchAPI(`/services/${id}`, 'DELETE');
        loadServices();
        alert('Leistung gelöscht!');
    } catch (error) {
        alert('Fehler beim Löschen');
    }
};

document.getElementById('edit-service-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const id = formData.get('id');
    const data = {
        number: formData.get('number'),
        title: formData.get('title'),
        description: formData.get('description'),
        icon: formData.get('icon'),
        order_index: parseInt(formData.get('order_index')),
        active: document.getElementById('edit-service-active').checked
    };

    try {
        if (id) {
            await fetchAPI(`/services/${id}`, 'PUT', data);
        } else {
            await fetchAPI('/services', 'POST', data);
        }
        hideModal('edit-service-modal');
        loadServices();
        alert('Leistung erfolgreich gespeichert!');
    } catch (error) {
        alert('Fehler beim Speichern');
    }
});

// Messages Management
async function loadMessages() {
    try {
        const messages = await fetchAPI('/messages');
        const container = document.getElementById('messages-list');
        
        if (messages.length === 0) {
            container.innerHTML = '<p>Keine Nachrichten vorhanden.</p>';
            return;
        }
        
        container.innerHTML = messages.map(message => `
            <div class="message-card glass-card ${!message.read ? 'unread' : ''}">
                <div class="message-header">
                    <div class="message-info">
                        <h4>${message.name}</h4>
                        <small>${message.email} • ${new Date(message.created_at).toLocaleString('de-DE')}</small>
                    </div>
                    <div class="message-actions">
                        ${!message.read ? `<button onclick="markAsRead(${message.id})" class="btn btn-secondary">Als gelesen markieren</button>` : ''}
                        <button onclick="deleteMessage(${message.id})" class="btn btn-danger">Löschen</button>
                    </div>
                </div>
                <div class="message-body">${message.message}</div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading messages:', error);
    }
}

window.markAsRead = async function(id) {
    try {
        await fetchAPI(`/messages/${id}/read`, 'PUT');
        loadMessages();
        loadDashboard();
    } catch (error) {
        alert('Fehler beim Markieren');
    }
};

window.deleteMessage = async function(id) {
    if (!confirm('Möchten Sie diese Nachricht wirklich löschen?')) return;
    
    try {
        await fetchAPI(`/messages/${id}`, 'DELETE');
        loadMessages();
        loadDashboard();
        alert('Nachricht gelöscht!');
    } catch (error) {
        alert('Fehler beim Löschen');
    }
};

// Modal helpers
function showModal(modalId) {
    document.getElementById(modalId).classList.add('active');
}

function hideModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
}

document.querySelectorAll('.modal-close, .modal-cancel').forEach(btn => {
    btn.addEventListener('click', function() {
        this.closest('.modal').classList.remove('active');
    });
});

// API Helper
async function fetchAPI(endpoint, method = 'GET', data = null) {
    const options = {
        method,
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        }
    };

    if (data) {
        options.body = JSON.stringify(data);
    }

    const response = await fetch(`${API_URL}${endpoint}`, options);
    
    if (!response.ok) {
        throw new Error(`API error: ${response.status}`);
    }

    return response.json();
}
