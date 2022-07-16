<div class="modal fade" id="status<?php echo $fetch['id'] ?>" aria-hidden="true" tabindex="-1" aria-labelledby="status">
    <div class="modal-dialog modal-dialog-centered">
        <div class=" modal-content bg-light">
            <form method="POST" action="includes/modal/update_apt_status_query.php">
                <div class="modal-header">
                    <h5 class="modal-title">Update <?php if (($fetch['id']) <= 9) {
                                                        echo 'APT-000', htmlspecialchars($fetch['id']);
                                                    } elseif (($fetch['id']) <= 99) {
                                                        echo 'APT-00', htmlspecialchars($fetch['id']);
                                                    } elseif (($fetch['id']) <= 999) {
                                                        echo 'APT-0', htmlspecialchars($fetch['id']);
                                                    } else {
                                                        echo 'APT-', htmlspecialchars($fetch['id']);
                                                    }  ?> Status</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
                    <div class="col">
                        <!-- <div class="form-group"> -->
                        <input name="id_update" type="hidden" value="<?php echo htmlspecialchars($fetch['id'])  ?>" class="form-control">
                        <input name="apt_date_update" type="hidden" value="<?php echo $fetch['date']; ?>" class="form-control">
                        <input name="apt_time_update" type="hidden" value="<?php echo $fetch['time'];  ?>" class="form-control">
                        <?php
                        $assign_vet = $fetch['empid']; ?>
                        <input name="assign_vet_update" type="hidden" value="<?php echo $assign_vet;  ?>" class="form-control">

                        <?php $orgistatus = $fetch['status'];
                        $orgiservice = $fetch['service'];
                        $orgidate = $fetch['date'];
                        $orgitime = $fetch['time'];
                        $orgivet =  $fetch['assigned_vet'];

                        ?>
                        <input name="orig_aptstat" type="hidden" value="<?php echo $orgistatus; ?>">
                        <input name="orig_date" type="hidden" value="<?php echo $orgidate;  ?>" class="form-control">
                        <input name="orig_time" type="hidden" value="<?php echo $orgitime;  ?>" class="form-control">
                        <input name="orig_service" type="hidden" value="<?php echo $orgiservice;  ?>" class="form-control">
                        <input name="orig_vet" type="hidden" value="<?php echo $assign_vet;  ?>" class="form-control">

                        <!-- </div> -->
                        <div class="form-group mt-2">
                            <label for="apt_stat_update"> Status </label>
                            <select class="form-control placeholder" name="apt_stat_update" required="required">
                                <option value="">Select Appointment Status </option>
                                <option value="Scheduled" <?php if ($fetch['status'] == 'Scheduled') {
                                                                echo "selected";
                                                            } ?>>Scheduled </option>

                                <option value="Canceled" <?php if ($fetch['status'] == 'Canceled') {
                                                                echo "selected";
                                                            }  ?>>Canceled</option>
                                <option value="Completed" <?php if ($fetch['status'] == 'Completed') {
                                                                echo "selected";
                                                            } ?>>Completed </option>

                                <option value="No Show" <?php if ($fetch['status'] == 'No Show') {
                                                            echo "selected";
                                                        }  ?>>No Show</option>
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