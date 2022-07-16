<div class="modal fade" id="status<?php echo $fetch['empid'] ?>" aria-hidden="true" tabindex="-1" aria-labelledby="status">
    <div class="modal-dialog modal-dialog-centered">
        <div class=" modal-content bg-light">
            <form method="POST" action="includes/modal/update_emp_status_query.php">
                <div class="modal-header">
                    <h5 class="modal-title">Update <?php if (($fetch['empid']) <= 9) {
                                                        echo 'EMP-000', $fetch['empid'];
                                                    } elseif (($fetch['empid']) <= 99) {
                                                        echo 'EMP-00', $fetch['empid'];
                                                    } elseif (($fetch['empid']) <= 999) {
                                                        echo 'EMP-0', $fetch['empid'];
                                                    } else {
                                                        echo 'APT-', $fetch['empid'];
                                                    }  ?> Status</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
                    <div class="col">
                        <!-- <div class="form-group"> -->
                        <input name="id" type="hidden" value="<?php echo htmlspecialchars($fetch['empid'])  ?>" class="form-control">
                        <input name="fname" type="hidden" value="<?php echo htmlspecialchars($fetch['user_fname'])  ?>" class="form-control">
                        <input name="lname" type="hidden" value="<?php echo htmlspecialchars($fetch['user_lname'])  ?>" class="form-control">
                        <input name="username" type="hidden" value="<?php echo htmlspecialchars($fetch['username'])  ?>" class="form-control">
                        <!-- </div> -->
                        <div class="form-group mt-2">
                            <label for="user_stat"> Employee Status </label>
                            <select class="form-control placeholder" name="user_stat" required="required">
                                <option value="">Select Employee Status </option>
                                <option value="Active" <?php if ($fetch['user_status'] == 'Active') {
                                                            echo "selected";
                                                        } ?>>Active </option>

                                <option value="Inactive" <?php if ($fetch['user_status'] == 'Inactive') {
                                                                echo "selected";
                                                            }  ?>>Inactive</option>

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