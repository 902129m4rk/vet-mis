<div class="modal fade" id="posMODAL" tabindex="-1" role="dialog" aria-labelledby="POS" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">SUMMARY</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
            </div>
            <div class="modal-body">
                <div class="form-group row text-left mb-2">
                    <div class="col-sm-12 text-center">
                        <h3 class="py-0">
                            GRAND TOTAL
                        </h3>
                        <h3 class="font-weight-bold py-3 bg-light">
                            ₱ <?php echo number_format($total, 2); ?>
                        </h3>
                    </div>

                </div>

                <div class="col-sm-12 mb-2">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text">₱</span>
                        </div>
                        <input class="form-control text-right" min="0" id="txtNumber" onkeypress="return isNumberKey(event)" type="number" name="cash" placeholder="Enter Cash" require_once>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-block" name="payment">PROCEED TO PAYMENT</button>
            </div>
        </div>
    </div>
</div>