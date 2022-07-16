<!-- Add Pet Modal -->
<div class="modal fade" id="add_medicalrecord<?php echo $fetch['id'] ?>" aria-hidden="true" tabindex="-1" aria-labelledby="add_medicalrecord">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class=" modal-content bg-light">
            <form action="includes/modal/add_pet_medical_records_query.php" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Add
                        <?php echo htmlspecialchars($fetch['name']),
                        "'s Medical Record"; ?>
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">

                    <input type="hidden" name="id" value="<?php echo $fetch['pet_id']; ?>">
                    <input type="hidden" name="patientname" value="<?php echo $fetch['name']; ?>">
                    <div class="form-group mt-2 mb-2">
                        <label for="file_description"><span> Findings </span> <span class="text-danger"> * </span> </label>
                        <textarea class="form-control" name="findings" rows="5" required></textarea>
                    </div>
                    <div class="form-group mt-2 mb-2">
                        <label for="file_description"><span> Prescription</label>
                        <textarea class="form-control" name="prescription" rows="5"></textarea>
                    </div>
                    <div class="form-group mt-2 mb-2">
                        <label for="file_description"><span> Description </label>
                        <textarea class="form-control" name="description" rows="5"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal"> Close</button>
                    <button name="addmodal" class="btn btn-primary"> Add Medical Records</button>
                </div>
            </form>
        </div>
    </div>
</div>