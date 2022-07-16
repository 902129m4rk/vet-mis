<div class="modal fade" id="update<?php echo $fetch['lab_test_details_id'] ?>" aria-hidden="true" tabindex="-1" aria-labelledby="update">
	<div class="modal-dialog modal-dialog-centered">
		<div class=" modal-content bg-light">
			<form method="POST" action="includes/modal/update_lab_test_details_query.php">
				<div class="modal-header">
					<h5 class="modal-title">Update <?php if (($fetch['lab_test_details_id']) <= 9) {
														echo 'TD-000', $fetch['lab_test_details_id'];
													} elseif (($fetch['lab_test_details_id']) <= 99) {
														echo 'TD-00', $fetch['lab_test_details_id'];
													} elseif (($fetch['lab_test_details_id']) <= 999) {
														echo 'TD-0', $fetch['lab_test_details_id'];
													} else {
														echo 'TD-', $fetch['lab_test_details_id'];
													}  ?></h5>
					<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
				</div>
				<div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
					<!-- <div class="col-md-5"></div> -->
					<input type="hidden" name="labid" value="<?php echo $fetch['lab_test_details_id'] ?>" />
					<div class="form-group mt-2">
						<label for="test_group">Test Group <span class="text-danger"> * </span> </label>
						<select class="form-control placeholder" name="test_group" required="required">
							<option value="">Select Test Group</option>
							<?php
							$testgr = mysqli_query($conn, "SELECT DISTINCT test_group_name FROM test_group WHERE status = 'Active' ORDER BY test_group_name asc");
							foreach ($testgr  as $rowtestgr) : ?>
								<option value="<?php echo  $rowtestgr['test_group_name']; ?>" <?php if ($fetch['test_group'] ==  $rowtestgr['test_group_name']) echo 'selected="selected"'; ?>><?php echo  $rowtestgr['test_group_name']; ?> </option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group mt-2">
						<label for="test_name">Test Name <span class="text-danger"> * </span> </label>

						<input class="form-control" type="text" placeholder="Enter Test Name" name="test_name" required="required" value="<?php echo $fetch['test_name'] ?>">
					</div>
					<div class="form-group mt-2">
						<label for="normal_min">Normal Minimum<span class="text-danger"> * </span> </label>
						<input class="form-control" type="number" min="0" max="1000" step="0.01" placeholder="Enter Normal Minimum Range" name="normal_min" required="required" value="<?php echo $fetch['normal_min'] ?>">
					</div>
					<div class="form-group mt-2">
						<label for="normal_max">Normal Maximum<span class="text-danger"> * </span> </label>
						<input class="form-control" type="number" min="0" max="1000" step="0.01" placeholder="Enter Normal Maximum Range" name="normal_max" required="required" value="<?php echo $fetch['normal_max'] ?>">
					</div>
					<div class="form-group mt-2">
						<label for="test_unit">Unit </label>
						<select class="form-control placeholder" name="test_unit">
							<option value="">Select Unit</option>
							<?php
							$unit = mysqli_query($conn, "SELECT DISTINCT unit_name FROM units WHERE unit_status = 'Active' ORDER BY unit_name asc");
							foreach ($unit  as $rowunit) : ?>
								<option value="<?php echo $rowunit['unit_name']; ?>" <?php if ($fetch['unit'] == $rowunit['unit_name']) echo 'selected="selected"'; ?>><?php echo $rowunit['unit_name']; ?> </option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group mt-2">
						<label for="status"> Status <span class="text-danger"> * </span> </label>
						<select class="form-control placeholder" name="status" required="required">
							<option value="">Select Test Group Status </option>
							<option value="Active" <?php if ($fetch['lab_details_status'] == 'Active') {
														echo "selected";
													} ?>>Active </option>

							<option value="Inactive" <?php if ($fetch['lab_details_status'] == 'Inactive') {
															echo "selected";
														}  ?>>Inactive</option>

						</select>
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
</div>