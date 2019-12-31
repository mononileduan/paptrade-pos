<!-- Sidebar Holder -->
<nav id="sidebar">
    <div class="sidebar-header">
        <h3>Menu</h3>
    </div>

    <ul class="list-unstyled components">
        <li class="active">
            <a href="<?= base_url();?><?= index_page();?>/users/dashboard">Home</a>
        </li>
        <li>
            <a href="#maintenanceSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Maintenance</a>
            <ul class="collapse list-unstyled" id="maintenanceSubmenu">
                <li>
                    <a href="#suppliersSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Suppliers</a>
                    <ul class="collapse list-unstyled" id="suppliersSubmenu">
                        <li>
                            <a href="<?= base_url();?><?= index_page();?>/suppliers/add">Add Supplier</a>
                        </li>
                        <li>
                            <a href="<?= base_url();?><?= index_page();?>/suppliers">View Suppliers</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Unit Types</a>
                </li>
                <li>
                    <a href="#">Categories</a>
                </li>
                <li>
                    <a href="#">Brands</a>
                </li>
                <li>
                    <a href="#">Models</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#inventorySubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Inventory</a>
            <ul class="collapse list-unstyled" id="inventorySubmenu">
                <li>
                    <a href="#">Warehouse</a>
                </li>
                <li>
                    <a href="#">Branch</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#reportsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Reports</a>
            <ul class="collapse list-unstyled" id="reportsSubmenu">
                <li>
                    <a href="#">Sales</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#adminSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Administration</a>
            <ul class="collapse list-unstyled" id="adminSubmenu">
                <li>
                    <a href="#usersSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Users</a>
                     <ul class="collapse list-unstyled" id="usersSubmenu">
                        <li>
                            <a href="<?= base_url();?><?= index_page();?>/users/add">Add User</a>
                        </li>
                        <li>
                            <a href="<?= base_url();?><?= index_page();?>/users">View Users</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Roles</a>
                </li>
                <li>
                    <a href="#">Branch</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="<?= base_url();?><?= index_page();?>/users/logout">Logout</a>
        </li>
    </ul>
</nav>