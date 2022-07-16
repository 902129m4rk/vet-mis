<div class="modal fade" id="update_species<?php echo $fetch['id'] ?>" aria-hidden="true" tabindex="-1" aria-labelledby="update_species">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class=" modal-content bg-light">
			<form method="POST" action="includes/modal/update_species_query.php">
				<div class="modal-header">
					<h5 class="modal-title">Update <?php if (($fetch['id']) <= 9) {
														// echo 'PTNT-0', $fetch['id'];
														echo 'SPCS-000', $fetch['id'];
													} elseif (($fetch['id']) <= 99) {
														echo 'SPCS-00', $fetch['id'];
													} elseif (($fetch['id']) <= 999) {
														echo 'SPCS-0', $fetch['id'];
													} else {
														echo 'SPCS-', $fetch['id'];
													}  ?></h5>
					<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
				</div>
				<div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
					<!-- <div class="col-md-5"></div> -->
					<div class="row">
						<div class="col">
							<div class="form-group">
								<span> Name </span> <span class="text-danger"> * </span>
								<input type="hidden" name="species_id" value="<?php echo $fetch['id'] ?>">
								<input class="form-control" type="text" name="species_name" placeholder="Enter Species Name" required="required" value="<?php echo $fetch['name'] ?>">
							</div>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col">
							<div class="form-group mt-2">
								<label for="species_stat"> Status<span class="text-danger"> * </span> </label>
								<select class="form-control placeholder" name="species_stat" required="required">
									<option value="">Select Species Status </option>
									<option value="Active" <?php if ($fetch['status'] == 'Active') {
																echo "selected";
															} ?>>Active </option>

									<option value="Inactive" <?php if ($fetch['status'] == 'Inactive') {
																	echo "selected";
																}  ?>>Inactive</option>

								</select>
							</div>

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
</div>