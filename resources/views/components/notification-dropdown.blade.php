<div class="dropdown nxl-h-item">
    <a href="javascript:void(0);" class="nxl-head-link" id="notificationDropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
        <div class="position-relative">
            <i class="feather-bell"></i>
            <span id="notificationBadge" class="badge bg-danger nxl-h-badge" style="display: none;">0</span>
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-notifications-menu" aria-labelledby="notificationDropdown">
        <div class="d-flex justify-content-between align-items-center notifications-head">
            <h6 class="fw-bold text-dark mb-0">Notifikasi</h6>
            <div class="d-flex gap-2">
                <a href="javascript:void(0);" onclick="markAllAsRead()" class="fs-11 text-success text-end ms-auto" data-bs-toggle="tooltip" title="Tandai Semua Dibaca">
                    <i class="feather-check"></i>
                    <span>Tandai Semua</span>
                </a>
                <a href="javascript:void(0);" onclick="clearReadNotifications()" class="fs-11 text-danger text-end ms-auto" data-bs-toggle="tooltip" title="Hapus yang Dibaca">
                    <i class="feather-trash-2"></i>
                    <span>Hapus</span>
                </a>
            </div>
        </div>
        <div id="notificationList" class="notifications-item-wrapper" style="max-height: 400px; overflow-y: auto;">
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        <div class="text-center notifications-footer">
            <a href="javascript:void(0);" onclick="loadAllNotifications()" class="fs-13 fw-semibold text-dark">Lihat Semua Notifikasi</a>
        </div>
    </div>
</div>

<script>
    let notificationInterval;

    // Load notifications on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadNotifications();
        updateUnreadCount();
        
        // Auto-refresh notifications every 30 seconds
        notificationInterval = setInterval(function() {
            updateUnreadCount();
        }, 30000);
    });

    // Load notifications
    function loadNotifications() {
        fetch('/notifications')
            .then(response => response.json())
            .then(data => {
                renderNotifications(data.notifications.data);
            })
            .catch(error => console.error('Error loading notifications:', error));
    }

    // Update unread count badge
    function updateUnreadCount() {
        fetch('/notifications/unread-count')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('notificationBadge');
                if (data.count > 0) {
                    badge.textContent = data.count > 99 ? '99+' : data.count;
                    badge.style.display = 'block';
                } else {
                    badge.style.display = 'none';
                }
            })
            .catch(error => console.error('Error updating unread count:', error));
    }

    // Render notifications
    function renderNotifications(notifications) {
        const container = document.getElementById('notificationList');
        
        if (notifications.length === 0) {
            container.innerHTML = `
                <div class="text-center py-4 text-muted">
                    <i class="feather-inbox fs-24 d-block mb-2"></i>
                    <p>Tidak ada notifikasi</p>
                </div>
            `;
            return;
        }

        container.innerHTML = notifications.map(notification => `
            <div class="notifications-item ${notification.is_read ? '' : 'unread'}" 
                 onclick="handleNotificationClick('${notification.id}', '${notification.link || ''}')">
                <div class="d-flex gap-3">
                    <div class="notification-icon">
                        ${getNotificationIcon(notification.type)}
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <h6 class="mb-1" style="font-size: 14px; font-weight: ${notification.is_read ? 'normal' : '600'};">${notification.title}</h6>
                            ${!notification.is_read ? '<span class="badge bg-primary rounded-pill" style="font-size: 10px;">Baru</span>' : ''}
                        </div>
                        <p class="mb-1 text-muted" style="font-size: 13px;">${notification.message}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted" style="font-size: 11px;">${formatTime(notification.created_at)}</small>
                            <div class="d-flex align-items-center float-end gap-2">
                                <a href="javascript:void(0);" onclick="event.stopPropagation(); deleteNotification('${notification.id}')" 
                                   class="d-block wd-8 ht-8 rounded-circle bg-gray-300" data-bs-toggle="tooltip" title="Hapus">
                                    <i class="feather-x fs-12"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }

    // Get notification icon based on type
    function getNotificationIcon(type) {
        const icons = {
            'quiz': '<i class="feather-help-circle text-primary"></i>',
            'material': '<i class="feather-book-open text-success"></i>',
            'user': '<i class="feather-user text-info"></i>',
            'system': '<i class="feather-settings text-warning"></i>',
            'achievement': '<i class="feather-award text-warning"></i>',
            'default': '<i class="feather-bell text-secondary"></i>'
        };
        return icons[type] || icons['default'];
    }

    // Format time
    function formatTime(timestamp) {
        const date = new Date(timestamp);
        const now = new Date();
        const diff = now - date;
        
        const minutes = Math.floor(diff / 60000);
        const hours = Math.floor(diff / 3600000);
        const days = Math.floor(diff / 86400000);
        
        if (minutes < 1) return 'Baru saja';
        if (minutes < 60) return `${minutes} menit yang lalu`;
        if (hours < 24) return `${hours} jam yang lalu`;
        if (days < 7) return `${days} hari yang lalu`;
        return date.toLocaleDateString('id-ID');
    }

    // Handle notification click
    function handleNotificationClick(id, link) {
        // Mark as read
        fetch(`/notifications/${id}/mark-read`, { method: 'POST' })
            .then(response => response.json())
            .then(data => {
                updateUnreadCount();
                loadNotifications();
                
                // Navigate to link if provided
                if (link) {
                    window.location.href = link;
                }
            })
            .catch(error => console.error('Error marking notification as read:', error));
    }

    // Mark all as read
    function markAllAsRead() {
        fetch('/notifications/mark-all-read', { method: 'POST' })
            .then(response => response.json())
            .then(data => {
                updateUnreadCount();
                loadNotifications();
            })
            .catch(error => console.error('Error marking all as read:', error));
    }

    // Delete notification
    function deleteNotification(id) {
        if (!confirm('Hapus notifikasi ini?')) return;
        
        fetch(`/notifications/${id}`, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                updateUnreadCount();
                loadNotifications();
            })
            .catch(error => console.error('Error deleting notification:', error));
    }

    // Clear read notifications
    function clearReadNotifications() {
        if (!confirm('Hapus semua notifikasi yang sudah dibaca?')) return;
        
        fetch('/notifications/clear-read', { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                updateUnreadCount();
                loadNotifications();
            })
            .catch(error => console.error('Error clearing read notifications:', error));
    }

    // Load all notifications (for full page view)
    function loadAllNotifications() {
        window.location.href = '/notifications';
    }
</script>

<style>
    .notifications-item:hover {
        background-color: #f8f9fa !important;
    }
    
    .notifications-item.unread {
        border-left: 3px solid #0d6efd;
        background-color: #f8f9fa;
    }
    
    .notification-icon {
        font-size: 20px;
        padding-top: 2px;
    }
</style>
