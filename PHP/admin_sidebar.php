<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: admin_login.php");
    exit;
}

$activePage = 'dashboard';
if (isset($_GET['page'])) {
    $activePage = $_GET['page'];
}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-title">Admin Panel</div>
        <button class="toggle-btn" id="toggleBtn">
            <i class="bi bi-chevron-left"></i>
        </button>
    </div>
    <ul class="sidebar-menu">
        <li class="sidebar-item">
            <a href="admin_dashboard.php" title="Dashboard" 
               class="sidebar-link <?php echo $activePage === 'dashboard' ? 'active' : ''; ?>">
                <i class="bi bi-speedometer2 sidebar-icon"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="inventory_dashboard.php" title="Inventory Management" 
               class="sidebar-link <?php echo $activePage === 'inventory' ? 'active' : ''; ?>">
                <i class="bi bi-box-seam sidebar-icon"></i>
                <span class="sidebar-text">Inventory Management</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="customer_management.php" title="Customer Management" 
               class="sidebar-link <?php echo $activePage === 'customers' ? 'active' : ''; ?>">
                <i class="bi bi-people sidebar-icon"></i>
                <span class="sidebar-text">Customer Management</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="admin_orders.php" title="Order Management" 
               class="sidebar-link <?php echo $activePage === 'orders' ? 'active' : ''; ?>">
                <i class="bi bi-cart3 sidebar-icon"></i>
                <span class="sidebar-text">Order Management</span>
            </a>
        </li>
        <li class="sidebar-item logout-btn">
            <a href="myaccount.php" title="Back to Account" class="sidebar-link">
                <i class="bi bi-arrow-left sidebar-icon"></i>
                <span class="sidebar-text">Back to Account</span>
            </a>
        </li>
    </ul>
</div>


<style>
    :root {
        --sidebar-width: 250px;
        --sidebar-collapsed-width: 70px;
        --primary-color: #0078d7;
        --dark-color: #212529;
        --light-color: #f8f9fa;
        --danger-color: #dc3545;
        --success-color: #28a745;
        --warning-color: #ffc107;
        --transition-speed: 0.3s;
    }

    .admin-container {
        display: flex;
    }

    .sidebar {
        width: var(--sidebar-width);
        background-color: var(--dark-color);
        color: white;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        transition: width var(--transition-speed) ease;
        overflow-x: hidden;
        z-index: 1000;
    }

    .sidebar.collapsed {
        width: var(--sidebar-collapsed-width);
    }

    .sidebar-header {
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar-title {
        font-size: 1.2rem;
        font-weight: bold;
        transition: opacity var(--transition-speed);
    }

    .sidebar.collapsed .sidebar-title {
        opacity: 0;
        visibility: hidden;
    }

    .toggle-btn {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 1.2rem;
    }

    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-item {
        padding: 0;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        color: white;
        text-decoration: none;
        white-space: nowrap;
        transition: background-color 0.2s;
        position: relative;
    }

    .sidebar-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .sidebar-link.active {
        background-color: var(--primary-color);
    }

    .sidebar-icon {
        font-size: 1.2rem;
        margin-right: 10px;
        min-width: 25px;
        text-align: center;
    }

    .sidebar-text {
        transition: opacity var(--transition-speed);
    }

    .sidebar.collapsed .sidebar-text {
        opacity: 0;
        visibility: hidden;
    }

    .sidebar.collapsed:hover {
        width: var(--sidebar-width);
    }

    .sidebar.collapsed:hover .sidebar-title,
    .sidebar.collapsed:hover .sidebar-text {
        opacity: 1;
        visibility: visible;
    }

    .main-content {
        margin-left: var(--sidebar-width);
        padding: 20px;
        transition: margin-left var(--transition-speed) ease;
        width: calc(100% - var(--sidebar-width));
    }

    .admin-container.sidebar-collapsed .main-content {
        margin-left: var(--sidebar-collapsed-width);
        width: calc(100% - var(--sidebar-collapsed-width));
    }

    @media (max-width: 768px) {
        .sidebar {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-title {
            opacity: 0;
            visibility: hidden;
        }

        .sidebar-text {
            opacity: 0;
            visibility: hidden;
        }

        .main-content {
            margin-left: var(--sidebar-collapsed-width);
            width: calc(100% - var(--sidebar-collapsed-width));
        }

        .sidebar.expanded {
            width: var(--sidebar-width);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .sidebar.expanded .sidebar-title,
        .sidebar.expanded .sidebar-text {
            opacity: 1;
            visibility: visible;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('toggleBtn');
        const sidebar = document.getElementById('sidebar');
        const adminContainer = document.getElementById('adminContainer');

        const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

        if (sidebarCollapsed) {
            sidebar.classList.add('collapsed');
            adminContainer.classList.add('sidebar-collapsed');
            toggleBtn.innerHTML = '<i class="bi bi-chevron-right"></i>';
        }

        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
            adminContainer.classList.toggle('sidebar-collapsed');

            if (sidebar.classList.contains('collapsed')) {
                toggleBtn.innerHTML = '<i class="bi bi-chevron-right"></i>';
                localStorage.setItem('sidebarCollapsed', 'true');
            } else {
                toggleBtn.innerHTML = '<i class="bi bi-chevron-left"></i>';
                localStorage.setItem('sidebarCollapsed', 'false');
            }
        });

        if (window.innerWidth <= 768) {
            const sidebarLinks = document.querySelectorAll('.sidebar-link');

            sidebarLinks.forEach(link => {
                link.addEventListener('click', function () {
                    if (window.innerWidth <= 768 && !sidebar.classList.contains('collapsed')) {
                        sidebar.classList.add('collapsed');
                        adminContainer.classList.add('sidebar-collapsed');
                        toggleBtn.innerHTML = '<i class="bi bi-chevron-right"></i>';
                        localStorage.setItem('sidebarCollapsed', 'true');
                    }
                });
            });

            toggleBtn.addEventListener('click', function () {
                sidebar.classList.toggle('expanded');
            });
        }

        window.addEventListener('resize', function () {
            if (window.innerWidth <= 768) {
                if (!sidebar.classList.contains('collapsed')) {
                    sidebar.classList.add('collapsed');
                    adminContainer.classList.add('sidebar-collapsed');
                    toggleBtn.innerHTML = '<i class="bi bi-chevron-right"></i>';
                }
            }
        });
    });
</script>
