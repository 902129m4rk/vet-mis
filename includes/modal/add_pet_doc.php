<!-- Add Pet Modal -->
<div class="modal fade" id="add_document<?php echo $fetch['id'] ?>" aria-hidden="true" tabindex="-1" aria-labelledby="update_patient">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class=" modal-content bg-light">
            <form action="includes/modal/add_pet_doc_query.php" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Add
                        <?php echo htmlspecialchars($fetch['name']),
                        "'s Document"; ?>
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
                    <div class="form-group">
                        <label for="file_description"><span>Choose File </span> <span class="text-danger"> * </span> </label>
                        <div class="input-group">
                            <input type="hidden" name="id" value="<?php echo $fetch['pet_id'] ?>">
                            <input type='file' name='file' class="form-control" required>

                        </div>
                        <div class="form-group mt-2 mb-2">
                            <label for="file_description"><span> Description </span> </label>
                            <textarea class="form-control" name="file_description" rows="5"></textarea>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal"> Close</button>
                    <button name="add" class="btn btn-primary"> Add Document</button>
                </div>
            </form>
        </div>
    </div>
</div>