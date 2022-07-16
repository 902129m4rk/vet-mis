<div class="modal fade" id="vitalitystatus<?php echo $fetch['id'] ?>" aria-hidden="true" tabindex="-1" aria-labelledby="vitalitystatus">
    <div class="modal-dialog modal-dialog-centered">
        <div class=" modal-content bg-light">
            <form method="POST" action="includes/modal/update_vitality_status_query.php">
                <div class="modal-header">
                    <h5 class="modal-title">Update <?php echo $fetch['name'], "'s"; ?> Vitality Status</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
                    <div class="col">

                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($fetch['id']); ?>">
                        <input type="hidden" name="petname" value="<?php echo $fetch['name']; ?>">

                        <div class="form-group mt-2">
                            <label for="pet_vitality_status"> Vitality Status </label>
                            <select class="form-control placeholder" name="pet_vitality_status" required="required">
                                <option value="">Select Vitality Status </option>
                                <option value="Alive" <?php if ($fetch['vitality_status'] == 'Alive') {
                                                            echo "selected";
                                                        } ?>>Alive </option>

                                <option value="Dead" <?php if ($fetch['vitality_status'] == 'Dead') {
                                                            echo "selected";
                                                        }  ?>>Dead</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div style="clear:both;"></div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal"> Close</button>
                    <button name="update" class="btn btn-primary"> Update</button>
                </div>
        </div>
        </form>
    </div>
</div>