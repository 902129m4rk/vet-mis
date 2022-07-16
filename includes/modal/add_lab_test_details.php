<!-- Add Pet Modal -->
<div class="modal fade" id="add_lab_test_details" aria-hidden="true" tabindex="-1" aria-labelledby="add_lab_test_details">
    <div class="modal-dialog modal-dialog-centered">
        <div class=" modal-content bg-light">
            <form action="includes/modal/add_lab_test_details_query.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Add Lab Test Details</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
                    <!-- <input type="hidden" name="id" value="<?php echo $addtestdetails['id'] ?>"> -->

                    <div class="form-group mt-2">
                        <label for="test_group">Test Group <span class="text-danger"> * </span> </label>
                        <select class="form-control placeholder" name="test_group" required="required">
                            <option value="">Select Test Group</option>
                            <?php $query = mysqli_query($conn, "SELECT * FROM test_group WHERE status = 'Active' ORDER BY test_group_name asc");
                            while ($row = mysqli_fetch_array($query)) {
                                // Remain selected value
                                $selected = '';
                                if (!empty($_POST['test_group']) and $_POST['test_group'] == $row['test_group_name']) {
                                    $selected = ' selected="selected"';  // select
                                }
                                echo '<option value="' . $row['test_group_name'] . '"' . $selected . '>' . $row['test_group_name'] . '</option>';
                            ?>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label for="test_name">Test Name <span class="text-danger"> * </span> </label>
                        <input class="form-control" type="text" placeholder="Enter Test Name" name="test_name" required="required">
                    </div>
                    <div class="form-group mt-2">
                        <label for="normal_min">Normal Minimum<span class="text-danger"> * </span> </label>
                        <input class="form-control" type="number" min="0" max="1000" step="0.01" placeholder="Enter Normal Minimum Range" name="normal_min" required="required">
                    </div>
                    <div class="form-group mt-2">
                        <label for="normal_max">Normal Maximum<span class="text-danger"> * </span> </label>
                        <input class="form-control" type="number" min="0" max="1000" step="0.01" placeholder="Enter Normal Maximum Range" name="normal_max" required="required">
                    </div>

                    <div class="form-group mt-2">
                        <label for="test_unit">Unit </label>
                        <select class="form-control placeholder" name="test_unit">
                            <option value="">Select Unit</option>
                            <?php $query = mysqli_query($conn, "SELECT * FROM units WHERE unit_status = 'Active' ORDER BY unit_name asc");
                            while ($row = mysqli_fetch_array($query)) {
                                // Remain selected value
                                $selected = '';
                                if (!empty($_POST['test_unit']) and $_POST['test_unit'] == $row['unit_name']) {
                                    $selected = ' selected="selected"';  // select
                                }
                                echo '<option value="' . $row['unit_name'] . '"' . $selected . '>' . $row['unit_name'] . '</option>';
                            ?>


                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal"> Close</button>
                    <button name="add" class="btn btn-primary"> Add Lab Test Details</button>
                </div>
            </form>
        </div>
    </div>
</div>