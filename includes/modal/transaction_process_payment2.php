<div class="modal fade" id="processtransaction<?php echo $fetch['trans_id'] ?>" aria-hidden="true" tabindex="-1" aria-labelledby="update_patient">
    <div class="modal-dialog modal-dialog-centered ">
        <div class=" modal-content bg-light">
            <form action="includes/modal/transaction_process_payment2_query.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Process <?php if (($fetch['trans_id']) <= 9) {
                                                        echo 'TRNS-0000', $fetch['trans_id'];
                                                    } elseif (($fetch['trans_id']) <= 99) {
                                                        echo 'TRNS-000', $fetch['trans_id'];
                                                    } elseif (($fetch['trans_id']) <= 999) {
                                                        echo 'TRNS-00', $fetch['trans_id'];
                                                    } elseif (($fetch['trans_id']) <= 9999) {
                                                        echo 'TRNS-0', $fetch['trans_id'];
                                                    } else {
                                                        echo 'TRNS-00-', $fetch['trans_id'];
                                                    }  ?> </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body">

                    <input type="hidden" name="transid" value="<?php echo $fetch['trans_id']; ?>">
                    <input type="hidden" name="transidmessage" value="<?php if (($fetch['trans_id']) <= 9) {
                                                                            echo 'TRNS-0000', $fetch['trans_id'];
                                                                        } elseif (($fetch['trans_id']) <= 99) {
                                                                            echo 'TRNS-000', $fetch['trans_id'];
                                                                        } elseif (($fetch['trans_id']) <= 999) {
                                                                            echo 'TRNS-00', $fetch['trans_id'];
                                                                        } elseif (($fetch['trans_id']) <= 9999) {
                                                                            echo 'TRNS-0', $fetch['trans_id'];
                                                                        } else {
                                                                            echo 'TRNS-00-', $fetch['trans_id'];
                                                                        } ?>">
                    <div class="form-group row text-left mb-2">
                        <div class="col-sm-12 text-center">
                            <h3 class="py-0">
                                GRAND TOTAL
                            </h3>
                            <h3 class="font-weight-bold py-3 bg-light">
                                <?php echo '₱ ', number_format($fetch['grand_total'], 2); ?>
                            </h3><input type="hidden" name="grandtotal" value=<?php echo $fetch['grand_total']; ?>>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">₱</span>
                            </div>
                            <input class="form-control text-right" id="txtNumber" onkeypress="return isNumberKey(event)" type="number" name="cash" placeholder="Enter Cash" require_once>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-block" name="payment">PROCEED TO PAYMENT</button>
                </div>
        </div>
        </form>
    </div>
</div>