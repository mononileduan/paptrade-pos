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
                    <a href="#unitTypeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Unit Types</a>
                    <ul class="collapse list-unstyled" id="unitTypeSubmenu">
                        <li>
                            <a href="<?= base_url();?><?= index_page();?>/unit_types/add">Add Unit Type</a>
                        </li>
                        <li>
                            <a href="<?= base_url();?><?= index_page();?>/unit_types">View Unit Types</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#categorySubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Categories</a>
                    <ul class="collapse list-unstyled" id="categorySubmenu">
                        <li>
                            <a href="<?= base_url();?><?= index_page();?>/categories/add">Add Category</a>
                        </li>
                        <li>
                            <a href="<?= base_url();?><?= index_page();?>/categories">View Categories</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#brandSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Brands</a>
                    <ul class="collapse list-unstyled" id="brandSubmenu">
                        <li>
                            <a href="<?= base_url();?><?= index_page();?>/brands/add">Add Brand</a>
                        </li>
                        <li>
                            <a href="<?= base_url();?><?= index_page();?>/brands">View Brands</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#modelSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Models</a>
                    <ul class="collapse list-unstyled" id="modelSubmenu">
                        <li>
                            <a href="<?= base_url();?><?= index_page();?>/models/add">Add Model</a>
                        </li>
                        <li>
                            <a href="<?= base_url();?><?= index_page();?>/models">View Models</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <a href="#warehouseSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Warehouse</a>
            <ul class="collapse list-unstyled" id="warehouseSubmenu">
                <li>
                    <a href="#poSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Purchase Order</a>
                    <ul class="collapse list-unstyled" id="poSubmenu">
                        <li>
                            <a href="<?= base_url();?><?= index_page();?>/purchase_orders/add">New Purchase Order</a>
                        </li>
                        <li>
                            <a href="<?= base_url();?><?= index_page();?>/purchase_orders">View Purchase Order</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#inventorySubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Inventory</a>
                    <ul class="collapse list-unstyled" id="inventorySubmenu">
                        <li>
                            <a href="<?= base_url();?><?= index_page();?>/inventories/add">New Inventory</a>
                        </li>
                        <li>
                            <a href="<?= base_url();?><?= index_page();?>/inventories">View Inventory</a>
                        </li>
                    </ul>
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