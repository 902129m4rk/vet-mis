<?php require_once 'config.php';
$sqlcompinfo = "SELECT clinic_name FROM company_info";
$resultcompinfo = mysqli_query($conn, $sqlcompinfo);
$fetchcompinfo =  mysqli_fetch_assoc($resultcompinfo);
?>
<!--SIDEBAR /VERTICAL NAV BAR-->

<!-- ADMIN SIDEBAR -->
<?php if (isset($_SESSION["loggedin"]) && ($_SESSION["utadmin"])) { ?>
    <nav id="sidebar" class="printccs">
        <div class="adminsidebar">
            <div class="container-fluid d-flex flex-column p-0">
                <a href="dashboard.php">
                    <div class="sidebar-header">
                        <h3> <?php echo strtoupper($fetchcompinfo['clinic_name']); ?> </h3>
                        </h3>
                    </div>
                </a>
                <div class="sidebar_nav" id="collapsibleNavbar">
                    <ul class="list-unstyled components">
                        <li class="<?php if ($page == 'dashboard') {
                                        echo 'active';
                                    } ?>">
                            <a href="dashboard.php">
                                <ion-icon name="home-outline" class="nav_icon"></ion-icon>

                                Dashboard

                            </a>
                        </li>
                        <li class="<?php if ($page == 'pet') {
                                        echo 'active';
                                    } ?>">
                            <a href="#petSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <ion-icon name="paw-outline" class="nav_icon"></ion-icon> Pet
                            </a>
                            <ul class="collapse list-unstyled" id="petSubmenu">
                                <li>
                                    <a href="add_pet.php">Add Pet</a>

                                </li>
                                <li>
                                    <a href="add_pet_medical_records.php">Add Medical Record</a>
                                </li>
                                <li>
                                    <a href="pet_list.php">Pet List</a>
                                </li>
                                <li>
                                    <a href="pet_owner_list.php">Pet Owner List</a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php if ($page == 'appointment') {
                                        echo 'active';
                                    } ?>">
                            <a href="#appointmentSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <ion-icon name="calendar-outline" class="nav_icon"></ion-icon> Appointment
                            </a>
                            <ul class="collapse list-unstyled" id="appointmentSubmenu">
                                <li>
                                    <a href="add_appointment.php">Add Appointment</a>
                                </li>
                                <li>
                                    <a href="appointment_list.php">Appointment List</a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php if ($page == 'transaction') {
                                        echo 'active';
                                    } ?>">
                            <a href="#transactionSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <ion-icon name="card-outline" class="nav_icon"></ion-icon> Transaction
                            </a>
                            <ul class="collapse list-unstyled" id="transactionSubmenu">
                                <li>
                                    <a href="add_transaction.php">Add Transaction</a>
                                </li>
                                <li>
                                    <a href="transaction_list.php">Transaction List</a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php if ($page == 'lab') {
                                        echo 'active';
                                    } ?>">
                            <a href="add_lab_test_list.php">
                                <ion-icon name="flask-outline" class="nav_icon"></ion-icon> Laboratory
                            </a>
                        </li>
                        <li class="<?php if ($page == 'product') {
                                        echo 'active';
                                    } ?>">
                            <a href="#productSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <ion-icon name="cube-outline" class="nav_icon"></ion-icon> Product
                            </a>
                            <ul class="collapse list-unstyled" id="productSubmenu">
                                <li>
                                    <a href="add_product.php">Add Product</a>
                                </li>
                                <li>
                                    <a href="add_stock.php">Add Stock</a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php if ($page == 'report') {
                                        echo 'active';
                                    } ?>">
                            <a href="#reportSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <ion-icon name="stats-chart-outline" class="nav_icon"></ion-icon> Report
                            </a>
                            <ul class="collapse list-unstyled" id="reportSubmenu">
                                <li>
                                    <a href="audit_trail.php">Audit Trail</a>
                                </li>
                                <li>
                                    <a href="collection_report.php">Collection Report</a>
                                </li>
                                <li>
                                    <a href="inventory_report.php">Inventory Report</a>
                                </li>
                                <li>
                                    <a href="laboratory_report.php">Laboratory Report</a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php if ($page == 'usermanager') {
                                        echo 'active';
                                    } ?>">
                            <a href="#usermanagerSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <ion-icon name="people-outline" class="nav_icon"></ion-icon> User Manager
                            </a>
                            <ul class="collapse list-unstyled" id="usermanagerSubmenu">
                                <li>
                                    <a href="add_user.php">Add User</a>
                                </li>
                                <li>
                                    <a href="user_list.php">User List</a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php if ($page == 'setting') {
                                        echo 'active';
                                    } ?>">
                            <a href="#settingSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <ion-icon name="cog-outline" class="nav_icon"></ion-icon> Setting
                            </a>
                            <ul class="collapse list-unstyled" id="settingSubmenu">
                                <li>
                                    <a href="company_profile.php">Company Profile</a>
                                </li>
                                <li>
                                    <a href="lab_setting.php">Laboratory Setting</a>
                                </li>
                                <li>
                                    <a href="product_category.php">Product Category</a>
                                </li>
                                <li>
                                    <a href="services.php">Services</a>
                                </li>
                                <li>
                                    <a href="species.php">Species</a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php if ($page == 'help') {
                                        echo 'active';
                                    } ?>">
                            <a href="help.php">
                                <ion-icon name="help-outline" class="nav_icon"></ion-icon>Help
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- VET SIDEBAR -->
<?php
} elseif (isset($_SESSION["loggedin"]) && ($_SESSION["utvet"])) {
?>
    <nav id="sidebar" class="printccs">
        <div class="vetsidebar">
            <div class="container-fluid d-flex flex-column p-0">
                <a href="dashboard.php">
                    <div class="sidebar-header2">
                        <h3> <?php echo strtoupper($fetchcompinfo['clinic_name']); ?> </h3>
                        </h3>
                    </div>
                </a>
                <div class="sidebar_nav" id="collapsibleNavbar">
                    <ul class="list-unstyled components">
                        <li class="<?php if ($page == 'dashboard') {
                                        echo 'active';
                                    } ?>">
                            <a href="dashboard.php">
                                <ion-icon name="home-outline" class="nav_icon"></ion-icon> Dashboard
                            </a>
                        </li>
                        <li class="<?php if ($page == 'pet') {
                                        echo 'active';
                                    } ?>">
                            <a href="#petSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <ion-icon name="paw-outline" class="nav_icon"></ion-icon> Pet
                            </a>
                            <ul class="collapse list-unstyled" id="petSubmenu">
                                <li>
                                    <a href="add_pet.php">Add Pet</a>
                                </li>
                                <li>
                                    <a href="add_pet_medical_records.php">Add Medical Record</a>
                                </li>
                                <li>
                                    <a href="pet_list.php">Pet List</a>
                                </li>
                                <li>
                                    <a href="pet_owner_list.php">Pet Owner List</a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php if ($page == 'appointment') {
                                        echo 'active';
                                    } ?>">
                            <a href="#appointmentSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <ion-icon name="calendar-outline" class="nav_icon"></ion-icon> Appointment
                            </a>
                            <ul class="collapse list-unstyled" id="appointmentSubmenu">
                                <li>
                                    <a href="add_appointment.php">Add Appointment</a>
                                </li>
                                <li>
                                    <a href="appointment_list.php">Appointment List</a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php if ($page == 'lab') {
                                        echo 'active';
                                    } ?>">
                            <a href="#laboratorySubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <ion-icon name="flask-outline" class="nav_icon"></ion-icon> Laboratory
                            </a>
                            <ul class="collapse list-unstyled" id="laboratorySubmenu">
                                <li>
                                    <a href="add_lab_test_list.php">Add Lab Test Result</a>
                                </li>
                                <li>
                                    <a href="laboratory_list.php">Laboratory List</a>
                                </li>
                            </ul>
                        </li>

                        <li class="<?php if ($page == 'help') {
                                        echo 'active';
                                    } ?>">
                            <a href="help.php">
                                <ion-icon name="help-outline" class="nav_icon"></ion-icon>Help
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- STAFF SIDEBAR -->
<?php
} elseif (isset($_SESSION["loggedin"]) && ($_SESSION["utstaff"])) { ?>
    <nav id="sidebar" class="printccs">
        <div class="staffsidebar" class="printccs">
            <div class="container-fluid d-flex flex-column p-0">
                <a href="dashboard.php">
                    <div class="sidebar-header3">
                        <h3> <?php echo strtoupper($fetchcompinfo['clinic_name']); ?> </h3>
                        </h3>
                    </div>
                </a>
                <div class="sidebar_nav" id="collapsibleNavbar">
                    <ul class="list-unstyled components">
                        <li class="<?php if ($page == 'dashboard') {
                                        echo 'active';
                                    } ?>">
                            <a href="dashboard.php">
                                <ion-icon name="home-outline" class="nav_icon"></ion-icon> Dashboard
                            </a>
                        </li>
                        <li class="<?php if ($page == 'pet') {
                                        echo 'active';
                                    } ?>">
                            <a href="#petSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <ion-icon name="paw-outline" class="nav_icon"></ion-icon> Pet
                            </a>
                            <ul class="collapse list-unstyled" id="petSubmenu">
                                <li>
                                    <a href="add_pet.php">Add Pet</a>
                                </li>
                                <li>
                                    <a href="add_pet_doc.php">Add Document</a>
                                </li>
                                <li>
                                    <a href="pet_list.php">Pet List</a>
                                </li>
                                <li>
                                    <a href="pet_owner_list.php">Pet Owner List</a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php if ($page == 'appointment') {
                                        echo 'active';
                                    } ?>">
                            <a href="#appointmentSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <ion-icon name="calendar-outline" class="nav_icon"></ion-icon> Appointment
                            </a>
                            <ul class="collapse list-unstyled" id="appointmentSubmenu">
                                <li>
                                    <a href="add_appointment.php">Add Appointment</a>
                                </li>
                                <li>
                                    <a href="appointment_list.php">Appointment List</a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php if ($page == 'transaction') {
                                        echo 'active';
                                    } ?>">
                            <a href="#transactionSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <ion-icon name="card-outline" class="nav_icon"></ion-icon> Transaction
                            </a>
                            <ul class="collapse list-unstyled" id="transactionSubmenu">
                                <li>
                                    <a href="add_transaction.php">Add Transaction</a>
                                </li>
                                <li>
                                    <a href="transaction_list.php">Transaction List</a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php if ($page == 'lab') {
                                        echo 'active';
                                    } ?>">
                            <a href="laboratory_list.php">
                                <ion-icon name="flask-outline" class="nav_icon"></ion-icon> Laboratory
                            </a>
                        </li>
                        <li class="<?php if ($page == 'help') {
                                        echo 'active';
                                    } ?>">
                            <a href="help.php">
                                <ion-icon name="help-outline" class="nav_icon"></ion-icon>Help
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

<?php } else {
    header("Location: index.php");
} ?>