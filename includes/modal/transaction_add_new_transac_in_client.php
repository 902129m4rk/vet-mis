<!-- Add Pet Modal -->
<div class="modal fade" id="add_transaction" aria-hidden="true" tabindex="-1" aria-labelledby="add_transaction">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class=" modal-content bg-light">
            <form action="includes/modal/" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Add Transaction
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
                    <div class="form-group">
                        <label for="service_name"> <span>Name </span> <span class="text-danger"> * </span> </label>
                        <input class="form-control" type="text" placeholder="Enter Service Name" name="service_name" required="required">
                    </div>
                    <div class="form-group mt-2">
                        <label for="test_cost">Price<span class="text-danger"> * </span> </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">₱</span>
                            </div>
                            <input class="form-control" type="number" min="0" step="0.01" placeholder="Enter Service Price " name="service_price" required="required">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal"> Close</button>
                    <button name="add" class="btn btn-primary"> Add Service</button>
                </div>
            </form>
        </div>
    </div>
</div>