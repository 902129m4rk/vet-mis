<div class="modal fade" id="status<?php echo $fetch['payment_no'] ?>" aria-hidden="true" tabindex="-1" aria-labelledby="status">
    <div class="modal-dialog modal-dialog-centered">
        <div class=" modal-content bg-light">
            <form method="POST" action="includes/modal/update_transaction_status_query.php">
                <div class="modal-header">
                    <h5 class="modal-title">Update <?php if (($fetch['payment_no']) <= 9) {
                                                        echo 'TRNS-000', $fetch['payment_no'];
                                                    } elseif (($fetch['payment_no']) <= 99) {
                                                        echo 'TRNS-00', $fetch['payment_no'];
                                                    } elseif (($fetch['payment_no']) <= 999) {
                                                        echo 'TRNS-0', $fetch['payment_no'];
                                                    } else {
                                                        echo 'PTNT-', $fetch['payment_no'];
                                                    }  ?> Payment Status</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">

                    <!-- <div class="form-group"> -->
                    <input name="id" type="hidden" value="<?php echo htmlspecialchars($fetch['payment_no'])  ?>" class="form-control">
                    <!-- </div> -->
                    <!-- <div class="form-group mt-2">
                            <label for="payment_stat"> Payment Status </label>
                            <select class="form-control placeholder" name="payment_stat" required="required">
                                <option value="">Select Payment Status </option>
                                <option value="Completed" <?php if ($fetch['payment_status'] == 'Completed') {
                                                                echo "selected";
                                                            } ?>>Completed </option>

                                <option value="Pending" <?php if ($fetch['payment_status'] == 'Pending') {
                                                            echo "selected";
                                                        }  ?>>Pending</option>
                            </select>
                        </div> -->
                    <div class="row  mt-3">
                        <div class="col-12">
                            <i class="fa fa-question-circle-o float-left text-primary" style="font-size:50px"> </i>
                            <p class="h6 text-center text-dark"> Do you want to process this transaction?</p>
                        </div>
                    </div>

                    <div class="row mt-5 mb-3">
                        <div class="col-6">
                            <button type="button " class="btn btn-outline-secondary btn-block" data-dismiss="modal">No</button>
                        </div>
                        <div class="col-6">
                            <a type="button " class="btn btn-primary btn-block" href="S<?php echo htmlspecialchars($fetch['payment_no'])  ?>">Yes</a>
                        </div>
                    </div>
                </div>

                <!-- <div class="modal-footer"> -->
                <!-- <button name="update" class="btn btn-outline-secondary">No</button> -->
                <!-- <button class="btn btn-danger" type="button"> Close</button> -->
                <!-- </div> -->
        </div>
        </form>
    </div>
</div>