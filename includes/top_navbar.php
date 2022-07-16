<!-- <div class="d-none d-sm-block topbar-divider"></div> -->

<li class="nav-item dropdown ml-auto printccs">
    <div class="nav-item dropdown ">
        <a class="nav-link " data-toggle="dropdown" aria-expanded="false" href="#">
            <span class="d-none d-lg-inline mr-2 ">
                <!-- echo $_SESSION["fname"], ' ', $_SESSION["lname"]; -->
                <?php
                $currentuser = $_SESSION["empid"];
                $sql2 = "SELECT * FROM users WHERE empid='$currentuser'";
                $curesult = mysqli_query($conn, $sql2);

                if ($curesult) {
                    if (mysqli_num_rows($curesult) > 0) {
                        while ($row = mysqli_fetch_array($curesult)) {
                            echo $row["user_fname"], ' ', $row["user_lname"];
                        }
                    }
                }
                ?>
            </span>
            <!-- <img class="img-responsive border rounded-circle img-profile " src="img/seonho.png" /> -->
            <ion-icon name="caret-down-outline"></ion-icon>

        </a>

        <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in">

            <a class="dropdown-item" href="account_setting_info.php">
                <ion-icon name="settings-outline"></ion-icon> Account Settings
            </a>
            <div class="dropdown-divider"> </div>
            <form action="includes/logout.php" method="POST">
                <button class="dropdown-item border-0" name="logout" type="submit">
                    <ion-icon name="log-out-outline"></ion-icon> Logout
                </button>
            </form>
        </div>

    </div>
</li>