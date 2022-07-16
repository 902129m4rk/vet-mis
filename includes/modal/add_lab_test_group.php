<!-- Add Pet Modal -->
<div class="modal fade" id="add_lab_test_group" aria-hidden="true" tabindex="-1" aria-labelledby="dd_lab_test_group">
    <div class="modal-dialog modal-dialog-centered">
        <div class=" modal-content bg-light">
            <form action="includes/modal/add_lab_test_group_query.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Add Test Group</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
                    <div class="form-group">
                        <label for="test_group_name">Name <span class="text-danger"> * </span> </label>
                        <input class="form-control" type="text" placeholder="Enter Test Group Name" name="test_group_name" required="required">
                    </div>
                    <div class="form-group mt-2">
                        <label for="test_cost">Price<span class="text-danger"> * </span> </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">₱</span>
                            </div>
                            <input class="form-control" type="number" min="0" step="0.01" placeholder="Enter Test Group Price " name="tg_cost" required="required">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal"> Close</button>
                    <button name="add" class="btn btn-primary"> Add Test Group</button>
                </div>
            </form>
        </div>
    </div>
</div>