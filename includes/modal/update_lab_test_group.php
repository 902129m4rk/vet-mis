<div class="modal fade" id="update<?php echo $fetch['test_group_id'] ?>" aria-hidden="true" tabindex="-1" aria-labelledby="update">
	<div class="modal-dialog modal-dialog-centered">
		<div class=" modal-content bg-light">
			<form method="POST" action="includes/modal/update_lab_test_group_query.php">
				<div class="modal-header">
					<h5 class="modal-title">Update <?php if (($fetch['test_group_id']) <= 9) {
														echo 'TG-000', $fetch['test_group_id'];
													} elseif (($fetch['test_group_id']) <= 99) {
														echo 'TG-00', $fetch['test_group_id'];
													} elseif (($fetch['test_group_id']) <= 999) {
														echo 'TG-0', $fetch['test_group_id'];
													} else {
														echo 'TG-', $fetch['test_group_id'];
													}  ?></h5>
					<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
				</div>
				<div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
					<!-- <div class="col-md-5"></div> -->
					<div class="form-group">
						<label for="test_name">Name <span class="text-danger"> * </span> </label>
						<input type="hidden" name="id" value="<?php echo $fetch['test_group_id'] ?>" />
						<input class="form-control" type="text" placeholder="Enter Test Group Name" name="test_group_name" required="required" value="<?php echo $fetch['test_group_name'] ?>">
					</div>
					<div class="form-group mt-2">
						<label for="test_cost">Price<span class="text-danger"> * </span> </label>
						<div class="input-group mb-2">
							<div class="input-group-prepend">
								<span class="input-group-text">₱</span>
							</div>
							<input class="form-control" type="number" min="0" step="0.01" placeholder="Enter Test Group Price " name="tg_cost" required="required" value="<?php echo $fetch['price'] ?>">
						</div>
					</div>
					<div class="form-group mt-2">
						<label for="status"> Status <span class="text-danger"> * </span> </label>
						<select class="form-control placeholder" name="status" required="required">
							<option value="">Select Test Group Status </option>
							<option value="Active" <?php if ($fetch['status'] == 'Active') {
														echo "selected";
													} ?>>Active </option>

							<option value="Inactive" <?php if ($fetch['status'] == 'Inactive') {
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