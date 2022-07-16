<div class="modal fade" id="update<?php echo $fetch['id'] ?>" aria-hidden="true" tabindex="-1" aria-labelledby="update">
	<div class="modal-dialog modal-dialog-centered">
		<div class=" modal-content bg-light">
			<form method="POST" action="includes/modal/update_lab_unit_query.php">
				<div class="modal-header">
					<h5 class="modal-title">Update <?php if (($fetch['id']) <= 9) {
														// echo 'PTNT-0', $fetch['id'];
														echo 'UNT-000', $fetch['id'];
													} elseif (($fetch['id']) <= 99) {
														echo 'UNT-00', $fetch['id'];
													} elseif (($fetch['id']) <= 999) {
														echo 'UNT-0', $fetch['id'];
													} else {
														echo 'UNT-', $fetch['id'];
													}  ?></h5>
					<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
				</div>
				<div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
					<!-- <div class="col-md-5"></div> -->
					<div class="form-group">
						<label for="lab_unit">Unit <span class="text-danger"> * </span> </label>
						<input type="hidden" name="id" value="<?php echo $fetch['id'] ?>" />
						<input class="form-control" type="text" placeholder="Enter Lab Unit" name="lab_unit" required="required" value="<?php echo $fetch['unit_name'] ?>">
					</div>
					<div class="form-group mt-2">
						<label for="status"> Status <span class="text-danger"> * </span> </label>
						<select class="form-control placeholder" name="status" required="required">
							<option value="">Select Unit Status </option>
							<option value="Active" <?php if ($fetch['unit_status'] == 'Active') {
														echo "selected";
													} ?>>Active </option>

							<option value="Inactive" <?php if ($fetch['unit_status'] == 'Inactive') {
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