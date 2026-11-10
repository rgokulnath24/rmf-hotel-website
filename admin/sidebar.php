<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<div
    class="sidebar-overlay"
    id="sidebarOverlay"
    onclick="closeSidebar()"
></div>


<aside
    class="sidebar"
    id="sidebar"
>

    <div class="sidebar-header">

        <a href="dashboard.php">

            <img
                src="../images/logo.png"
                alt="RMF"
            >

        </a>

        <button
            class="sidebar-close"
            onclick="closeSidebar()"
            aria-label="Close sidebar"
        >
            <i class="fa-solid fa-xmark"></i>
        </button>

    </div>


    <div class="sidebar-label">
        MANAGEMENT
    </div>


    <nav class="sidebar-nav">

        <a
            href="dashboard.php"
            class="<?= $currentPage === 'dashboard.php' ? 'active' : '' ?>"
        >
            <i class="fa-solid fa-chart-pie"></i>
            <span>Dashboard</span>
        </a>


        <a
            href="create_item.php"
            class="<?= $currentPage === 'create_item.php' ? 'active' : '' ?>"
        >
            <i class="fa-solid fa-plus"></i>
            <span>Add Menu Item</span>
        </a>


        <a
            href="item_grid.php"
            class="<?= $currentPage === 'item_grid.php' ? 'active' : '' ?>"
        >
            <i class="fa-solid fa-utensils"></i>
            <span>Manage Menu</span>
        </a>

    </nav>


    <div class="sidebar-footer">

        <a href="../" target="_blank">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            View Website
        </a>

        <a href="logout.php">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </a>

    </div>

</aside>


<button
    class="mobile-menu-btn"
    id="hamburger"
    onclick="openSidebar()"
    aria-label="Open menu"
>
    <i class="fa-solid fa-bars"></i>
</button>