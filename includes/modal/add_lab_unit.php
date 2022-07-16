<!-- Add Pet Modal -->
<div class="modal fade" id="add_unit<?php echo $addunit['id'] ?>" aria-hidden="true" tabindex="-1" aria-labelledby="add_unit">
    <div class="modal-dialog modal-dialog-centered">
        <div class=" modal-content bg-light">
            <form action="includes/modal/add_lab_unit_query.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Add Lab Unit</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
                    <div class="form-group mt-2">
                        <label for="lab_unit">Unit <span class="text-danger"> * </span> </label>
                        <input class="form-control" type="text" placeholder="Enter Lab Unit" name="lab_unit" required="required">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal"> Close</button>
                    <button name="add" class="btn btn-primary"> Add Unit</button>
                </div>
            </form>
        </div>
    </div>
</div>