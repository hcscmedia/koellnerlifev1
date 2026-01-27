            </div> <!-- .admin-content -->
        </main>
    </div> <!-- .admin-layout -->
    
    <script>
        // Sidebar Toggle für Mobile
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('open');
        }
        
        // Confirm Delete
        function confirmDelete(message) {
            return confirm(message || 'Möchten Sie diesen Eintrag wirklich löschen?');
        }
        
        // Auto-hide Alerts
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.3s';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>
