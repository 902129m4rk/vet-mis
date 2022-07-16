<div class="modal fade" id="completetransstatus<?php echo $fetch['payment_no']; ?>" aria-hidden="true" tabindex="-1" aria-labelledby="completetransstatus">
    <div class="modal-dialog modal-dialog-centered">
        <div class=" modal-content bg-light">
            <div class="modal-header">
                <h5 class="modal-title"><?php if (($fetch['payment_no']) <= 9) {
                                            echo 'TRNS-000', $fetch['payment_no'];
                                        } elseif (($fetch['payment_no']) <= 99) {
                                            echo 'TRNS-00', $fetch['payment_no'];
                                        } elseif (($fetch['payment_no']) <= 999) {
                                            echo 'TRNS-0', $fetch['payment_no'];
                                        } else {
                                            echo 'PTNT-', $fetch['payment_no'];
                                        }  ?></h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
            </div>
            <div class="modal-body ml-5 mr-5 mb-3 mt-3">
                <div class="row">
                    <div class="col-12">
                        <i class="fa fa-question-circle-o float-left text-primary" style="font-size:50px"> </i>
                        <p class="h6 text-center mt-3 text-dark"> This transaction is already completed</p>
                    </div>
                </div>
            </div>
            <div style="clear:both;"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal"> Close</button>
            </div>
        </div>
    </div>
</div>