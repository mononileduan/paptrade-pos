<!-- Sidebar Holder -->
<nav id="sidebar">
    <div class="sidebar-header">
        <h3>Menu</h3>
    </div>

    <ul class="list-unstyled components">
        <?php
        if($this->session->userdata('user_role') == 'System Administrator'){
echo '  <li>';
echo '      <a href="#maintenanceSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Maintenance</a>';
echo '      <ul class="collapse list-unstyled" id="maintenanceSubmenu">';
echo '          <li>';
echo '              <a href="#suppliersSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Suppliers</a>';
echo '              <ul class="collapse list-unstyled" id="suppliersSubmenu">';
echo '                  <li>';
echo '                      <a href="' . base_url() . index_page() . '/suppliers/add">Add Supplier</a>';
echo '                  </li>';
echo '                  <li>';
echo '                      <a href="' . base_url() . index_page() . '/suppliers">View Suppliers</a>';
echo '                  </li>';
echo '              </ul>';
echo '          </li>';
echo '          <li>';
echo '              <a href="#unitTypeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Unit Types</a>';
echo '              <ul class="collapse list-unstyled" id="unitTypeSubmenu">';
echo '                  <li>';
echo '                      <a href="' . base_url() . index_page() . '/unit_types/add">Add Unit Type</a>';
echo '                  </li>';
echo '                  <li>';
echo '                      <a href="' . base_url() . index_page() . '/unit_types">View Unit Types</a>';
echo '                  </li>';
echo '              </ul>';
echo '          </li>';
echo '          <li>';
echo '              <a href="#categorySubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Categories</a>';
echo '              <ul class="collapse list-unstyled" id="categorySubmenu">';
echo '                  <li>';
echo '                      <a href="' . base_url() . index_page() . '/categories/add">Add Category</a>';
echo '                  </li>';
echo '                  <li>';
echo '                      <a href="' . base_url() . index_page() . '/categories">View Categories</a>';
echo '                  </li>';
echo '              </ul>';
echo '          </li>';
echo '          <li>';
echo '              <a href="#brandSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Brands</a>';
echo '              <ul class="collapse list-unstyled" id="brandSubmenu">';
echo '                  <li>';
echo '                      <a href="' . base_url() . index_page() . '/brands/add">Add Brand</a>';
echo '                  </li>';
echo '                  <li>';
echo '                      <a href="' . base_url() . index_page() . '/brands">View Brands</a>';
echo '                  </li>';
echo '              </ul>';
echo '          </li>';
echo '          <li>';
echo '              <a href="#modelSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Models</a>';
echo '              <ul class="collapse list-unstyled" id="modelSubmenu">';
echo '                  <li>';
echo '                      <a href="' . base_url() . index_page() . '/models/add">Add Model</a>';
echo '                  </li>';
echo '                  <li>';
echo '                      <a href="' . base_url() . index_page() . '/models">View Models</a>';
echo '                  </li>';
echo '              </ul>';
echo '          </li>';
echo '      </ul>';
echo '  </li>';
echo '  <li>';
echo '      <a href="#warehouseSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Warehouse</a>';
echo '      <ul class="collapse list-unstyled" id="warehouseSubmenu">';
echo '          <li>';
echo '              <a href="#poSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Purchase Order</a>';
echo '              <ul class="collapse list-unstyled" id="poSubmenu">';
echo '                  <li>';
echo '                      <a href="' . base_url() . index_page() . '/purchase_orders/add">New Purchase Order</a>';
echo '                  </li>';
echo '                  <li>';
echo '                      <a href="' . base_url() . index_page() . '/purchase_orders">View Purchase Order</a>';
echo '                  </li>';
echo '              </ul>';
echo '          </li>';
echo '          <li>';
echo '              <a href="#inventorySubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Inventory</a>';
echo '              <ul class="collapse list-unstyled" id="inventorySubmenu">';
echo '                  <li>';
echo '                      <a href="' . base_url() . index_page() . '/inventories/add">New Inventory</a>';
echo '                  </li>';
echo '                  <li>';
echo '                      <a href="' . base_url() . index_page() . '/inventories">View Inventory</a>';
echo '                  </li>';
echo '              </ul>';
echo '          </li>';
echo '          <li>';
echo '              <a href="#supplyRequesWarehousetSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Branch Supply Request</a>';
echo '              <ul class="collapse list-unstyled" id="supplyRequesWarehousetSubmenu">';
echo '                  <li>';
echo '                      <a href="' . base_url() . index_page() . '/branch_supply_requests/warehouse_view">View Branch Supply Requests</a>';
echo '                  </li>';
echo '              </ul>';
echo '          </li>';
echo '      </ul>';
echo '  </li>';

        }else if($this->session->userdata('user_role') == 'Branch Administrator'){
        
echo '  <li>';
echo '      <a href="#branchSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Branch</a>';
echo '      <ul class="collapse list-unstyled" id="branchSubmenu">';
echo '          <li>';
echo '              <a href="#supplyRequestSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Supply Request</a>';
echo '              <ul class="collapse list-unstyled" id="supplyRequestSubmenu">';
echo '                  <li>';
echo '                      <a href="' . base_url() . index_page() . '/branch_supply_requests/add">New Supply Request</a>';
echo '                  </li>';
echo '                  <li>';
echo '                      <a href="' . base_url() . index_page() . '/branch_supply_requests">View Supply Requests</a>';
echo '                  </li>';
echo '              </ul>';
echo '          </li>';
echo '          <li>';
echo '              <a href="#branchInventorySubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Inventory</a>';
echo '              <ul class="collapse list-unstyled" id="branchInventorySubmenu">';
echo '                  <li>';
echo '                      <a href="' . base_url() . index_page() . '/inventories_branch/add">New Inventory</a>';
echo '                  </li>';
echo '                  <li>';
echo '                      <a href="' . base_url() . index_page() . '/inventories_branch">View Inventory</a>';
echo '                  </li>';
echo '              </ul>';
echo '          </li>';
echo '      </ul>';
echo '  </li>';
echo '  <li>';
echo '      <a href="#reportsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Reports</a>';
echo '      <ul class="collapse list-unstyled" id="reportsSubmenu">';
echo '          <li>';
echo '              <a href="' . base_url() . index_page() . '/sales">Sales</a>';
echo '          </li>';
echo '      </ul>';
echo '  </li>';
        }
        ?>
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
                            <a href="<?= base_url();?><?= index_page();?>/users/view">View Users</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#branchAdminSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Branch</a>
                    <ul class="collapse list-unstyled" id="branchAdminSubmenu">
                        <li>
                            <a href="<?= base_url();?><?= index_page();?>/branches/add">New Branch</a>
                        </li>
                        <li>
                            <a href="<?= base_url();?><?= index_page();?>/branches">View Branches</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <a href="<?= base_url();?><?= index_page();?>/users/logout">Logout</a>
        </li>
    </ul>
</nav>