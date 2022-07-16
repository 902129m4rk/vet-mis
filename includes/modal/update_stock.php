<div class="modal fade" id="stock<?php echo $fetch['inventory_id']; ?>" aria-hidden="true" tabindex="-1" aria-labelledby="stock">
    <div class="modal-dialog modal-dialog-centered">
        <div class=" modal-content bg-light">
            <form method="POST" action="includes/modal/update_stock_query.php">
                <div class="modal-header">
                    <h5 class="modal-title">Update <?php if (($fetch['inventory_id']) <= 9) {
                                                        // echo 'PTNT-0', $fetch['id'];
                                                        echo 'PRDCT-000', htmlspecialchars($fetch['inventory_id']);
                                                    } elseif (($fetch['inventory_id']) <= 99) {
                                                        echo 'PRDCT-00', htmlspecialchars($fetch['inventory_id']);
                                                    } elseif (($fetch['inventory_id']) <= 999) {
                                                        echo 'PRDCT-0', htmlspecialchars($fetch['inventory_id']);
                                                    } else {
                                                        echo 'PRDCT-', htmlspecialchars($fetch['inventory_id']);
                                                    }  ?> Stock</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
                    <div class="form-group">
                        <!-- <label>Name</label> -->
                        <input type="hidden" name="stockid" value="<?php echo htmlspecialchars($fetch['inventory_id']); ?>">
                        <input type="hidden" name="prodname" value="<?php echo $fetch['product_name']; ?>">
                    </div>
                    <div class="form-group mt-2">
                        <label for="prod_quantity">Quantity on Hand<span class="text-danger"> * </span> </label>
                        <input class="form-control" type="number" min="0" placeholder="Enter Quantity on Hand" name="prod_quantity" required="required" value="<?php echo $fetch['quantity_on_hand'] ?>">
                    </div>
                </div>
                <div style="clear:both;"></div>
                <div class="modal-footer">
                    <button name="update" class="btn btn-primary"> Update</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal"> Close</button>
                </div>
        </div>
        </form>
    </div>
</div>