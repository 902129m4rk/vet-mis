<?php
$tab_query = "SELECT * FROM product_category WHERE status='Active' ORDER BY name ASC";
$tab_result = mysqli_query($conn, $tab_query);
$tab_menu = "";
$tab_content = "";
$count = 0;
$searchbox = ' <input class="form-control form-right" type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for product">';
while ($row1 = mysqli_fetch_array($tab_result)) {
    if ($count == 0) {
        $tab_menu .= '<button type="button" class=" mt-2 active btn btn-outline-primary mr-2 " href="#' . $row1['id'] . '" data-target="#' . $row1['id'] . '" data-toggle="tab">' . $row1['name'] . '</button>';
        $tab_content .= '<div class="tab-pane fade show active"   aria-labelledby="' . $row1["id"] . '" id="' . $row1["id"] . '" >';
    } else {
        $tab_menu .= '<button type="button" class=" mt-2  btn btn-outline-primary  mr-2 " href="#' . $row1['id'] . '" data-target="#' . $row1['id'] . '" data-toggle="tab">' . $row1['name'] . '</button>';
        $tab_content .= '<div class="tab-pane fade "   aria-labelledby="' . $row1["id"] . '   " id="' . $row1["id"] . '" >  ';
    }


    $productcat = $row1['name'];
    $product_query = "SELECT * FROM inventory
     WHERE product_category='" . $productcat . "' AND quantity_on_hand >=1 
     ";
    $invoicetype = "Product";
    $product_result = mysqli_query($conn, $product_query);

    if ($product_result) {
        if (mysqli_num_rows($product_result) >= 1) {
            $tab_content .= ' <div class="table-responsive table mt-3 table-hover page-length" id="dataTable" role="grid" aria-describedby="dataTable_info">
            <table id="example" class="table table-responsive table-bordered nowrap sortable" style="width:100%">
            <thead>
                <tr>
                <th class="align-middle" width="35%">Product Name </th>
                <th class="align-middle" width="15%">Species</th>
                <th class="align-middle" width="15%">Quantity on Hand</th>
                <th class="align-middle" width="15%">Price </th>
                <th class="align-middle" width="10%" >Quantity</th>
                <th class="align-middle" width="10%">Add</th>
                </tr>
            </thead>
            
            <tbody id="myTable">';
            while ($sub_row = mysqli_fetch_assoc($product_result)) {

                // QTY ON HAND CLASS
                if ($sub_row["quantity_on_hand"]  <= '10') {
                    $qtyclass = "text-danger";
                } elseif ($sub_row["quantity_on_hand"] <= '30') {
                    $qtyclass = "text-warning";
                } else {
                    $qtyclass = "text-primary";
                }
                //SPECIES "&" CONDITION
                if (!empty($sub_row["species2"])) {
                    $echospecies =  $sub_row["species1"];
                    $echospecies .= ' & ';
                    $echospecies .= $sub_row["species2"];
                } else {
                    $echospecies = $sub_row["species1"];
                }
                $productprice = number_format($sub_row['price'], 2);

                $tab_content  .= '<form method="post" action="add_transaction.php?action=add&id=' . $sub_row['product_name'] . '">
                <input type="hidden" name="name" value="' . $sub_row["product_name"] . '" />
                <input type="hidden" name="invoice_type" value="' . $invoicetype . '" />
                <input type="hidden" name="price" value="' . $sub_row["price"] . '" />
                <tr>
                    <td>
                        <div class="text-dark ">' . $sub_row['product_name'] . '</div>
                    </td>
                    <td> ' . $echospecies . ' 
                    </td>
                    <td style="min-width:6em">
                    <div class="' . $qtyclass . '">
                    ' . $sub_row["quantity_on_hand"] . '
                    </div>
                    </td>
                    <td>
                        <div class="text-dark ">₱ ' . $productprice . ' </div>
                    </td>
                    <td>
                        <input type="number" min="1" name="quantity" class="form-control" value="1" style="min-width:6em"/>
                    </td>
                    <td>

                        <input type="submit" name="addpos" style="margin-top:5px;" class="btn btn-primary" value="Add" />
                    </td>
                </tr>
            </form>';
            }
            $tab_content .= '</tbody></table></div> <div style="clear:both">  </div> </div> ';
            $count++;
        } else {
            $tab_content .= '<h5 class="mt-5 text-center mb-5">Sorry, there are no products in this category </h5>  <div style="clear:both">  </div> </div>';
        }
    }
}

?>

<div class="tab-pane fade mt-3 fade show active" id="product" role="tabpanel" aria-labelledby="product">

    <div class="row mt-2 mb-4">
        <div class="col-8">
            <form method="POST">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search Product">
                    <div class="input-group-append">
                        <input class="btn btn-primary" type="submit" name="submitsearch" value="Search" data-toggle-title="tooltip" data-placement="bottom" title="Search">
                        </input>
                        <button class="btn btn-danger" type="submit" name="clearsearch" data-toggle-title="tooltip" data-placement="bottom" title="Clear Searches">
                            <i class="fa fa-eraser"></i>
                            <span class="mobile-icon-only"> Clear Searches</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php if (empty($_POST['submitsearch'])) { ?>
        <ul class="nav nav-tabs mb-3 mt-4 ">
            <li class="nav-item mb-3">
                <?php echo $tab_menu; ?>
            </li>
        </ul>
        <div class="tab-content">
            <?php echo $tab_content; ?>
        </div>
    <?php } ?>
    <?php
    if (isset($_POST['submitsearch'])) {
        $search = $_POST['search'];

        $sql = "SELECT * FROM inventory WHERE product_name AND quantity_on_hand >=1 LIKE '%$search%' OR product_name LIKE '%$search%' OR species1 LIKE '%$search%'  OR species2 LIKE '%$search%'";
        $result = mysqli_query($conn, $sql);
        $queryResult = mysqli_num_rows($result);
        $invoicetype = "Product";
        if ($queryResult > 0) { ?>
            <div class="table-responsive">
                <table class="table table-responsive table-bordered table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="align-middle" width="35%">Product Name </th>
                            <th class="align-middle" width="15%">Species</th>
                            <th class="align-middle" width="15%">Quantity on Hand</th>
                            <th class="align-middle" width="15%">Price </th>
                            <th class="align-middle" width="10%">Quantity</th>
                            <th class="align-middle" width="10%">Add</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($fetch = mysqli_fetch_assoc($result)) { ?>
                            <form method="post" action="add_transaction.php?action=add&id=<?php echo $fetch['product_name']; ?>">
                                <tr>
                                    <input type="hidden" name="name" value="<?php echo $fetch['product_name']; ?>">
                                    <input type="hidden" name="invoice_type" value="<?php echo $invoicetype; ?>">
                                    <input type="hidden" name="price" value="<?php echo $fetch['price']; ?>">
                                    <td><?php echo $fetch['product_name']; ?></td>
                                    <td><?php echo $fetch['species1'], ' ', $fetch['species2']; ?></td>
                                    <td><?php echo $fetch['quantity_on_hand']; ?></td>
                                    <td><?php echo '₱ ',  number_format($fetch['price'], 2); ?></td>
                                    <td> <input type="number" min="1" name="quantity" class="form-control" value="1" style="min-width:6em" /></td>
                                    <td> <input type="submit" name="addpos" style="margin-top:5px;" class="btn btn-primary" value="Add" /></td>
                                </tr>
                            </form>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
    <?php
        } else {
            echo "<h5 class='mt-5 text-center mb-5'> No results Found, Please try again. </h5>";
        }
    }
    if (isset($_POST['clearsearch'])) {
        unset($_POST['submitsearch']);
    }
    ?>

</div>



<!-- SERVICE -->
<div class="tab-pane fade mt-3" id="service" role="tabpanel" aria-labelledby="service">
    <div class="row">
        <div class="col-6">
            <input class="form-control form-right" type="text" id="myInput7" onkeyup="myFunction7()" placeholder="Search for service">
        </div>
    </div>
    <div class="row">
        <div class="table-responsive table mt-3 table-hover page-length">
            <table class="table table-responsive table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th class="align-middle">Service Name </th>
                        <th class="align-middle">Price </th>
                        <th class="align-middle">Quantity</th>
                        <th class="align-middle"></th>
                    </tr>
                </thead>
                <tbody id="myTable7">
                    <?php
                    $query = "SELECT * FROM service WHERE status='Active' ORDER BY name asc";
                    $result = mysqli_query($conn, $query);
                    $invoicetype = "Service";
                    if ($result) :
                        if (mysqli_num_rows($result) > 0) :
                            while ($product = mysqli_fetch_assoc($result)) :
                    ?>
                                <form method="post" action="add_transaction.php?action=add&id=<?php echo $product['name']; ?>">
                                    <input type="hidden" name="name" value="<?php echo $product['name']; ?>" />
                                    <input type="hidden" name="invoice_type" value="<?php echo $invoicetype; ?>" />
                                    <input type="hidden" name="price" value="<?php echo $product['price']; ?>" />
                                    <tr>
                                        <td>
                                            <div class="text-dark "><?php echo $product['name']; ?></div>
                                        </td>

                                        <td>
                                            <div class="text-dark ">₱ <?php echo number_format($product['price'], 2);  ?></div>
                                        </td>
                                        <td>
                                            <input type="number" min="1" name="quantity" class="form-control" value="1" style="min-width:6em" />
                                        </td>
                                        <td>

                                            <input type="submit" name="addpos" style="margin-top:5px;" class="btn btn-primary" value="Add" />
                                        </td>
                                    </tr>
                                </form>

                    <?php endwhile;
                        endif;
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- LAB -->
<div class="tab-pane fade mt-3" id="lab" role="tabpanel" aria-labelledby="lab">
    <div class="row">
        <div class="col-6">
            <input class="form-control form-right" type="text" id="myInput8" onkeyup="myFunction8()" placeholder="Search for lab test">
        </div>
    </div>
    <div class="row">
        <div class="table-responsive table mt-3 table-hover page-length">
            <table class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th class="align-middle">Lab Test</th>
                        <th class="align-middle">Price </th>
                        <th class="align-middle">Quantity</th>
                        <th class="align-middle">Add</th>
                    </tr>
                </thead>
                <tbody id="myTable8">
                    <?php
                    $query = "SELECT * FROM test_group WHERE status='Active' ORDER BY test_group_name ASC";
                    $result = mysqli_query($conn, $query);
                    $invoicetype = "Laboratory";
                    if ($result) :
                        if (mysqli_num_rows($result) > 0) :
                            while ($product = mysqli_fetch_assoc($result)) :
                    ?>
                                <form method="post" action="add_transaction.php?action=add&id=<?php echo $product['test_group_name']; ?>">
                                    <input type="hidden" name="name" value="<?php echo $product['test_group_name']; ?>" />
                                    <input type="hidden" name="invoice_type" value="<?php echo $invoicetype; ?>" />
                                    <input type="hidden" name="price" value="<?php echo $product['price']; ?>" />
                                    <tr>
                                        <td>
                                            <div class="text-dark "><?php echo $product['test_group_name']; ?></div>
                                        </td>

                                        <td>
                                            <div class="text-dark ">₱ <?php echo number_format($product['price'], 2);  ?></div>
                                        </td>
                                        <td>
                                            <input type="number" min="1" name="quantity" class="form-control" value="1" style="min-width:5em">
                                        </td>
                                        <td>

                                            <input type="submit" name="addpos" style="margin-top:5px;" class="btn btn-primary" value="Add" />
                                        </td>
                                    </tr>
                                </form>

                    <?php endwhile;
                        endif;
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>