<div class="modal fade" id="update_username<?php echo $fetch['empid'] ?>" aria-hidden="true" tabindex="-1" aria-labelledby="update_username">
	<?php if ($fetch['user_status'] == 'Active') {
	?>
		<div class="modal-dialog  modal-dialog-centered ">
			<div class=" modal-content bg-light">
				<form method="POST" action="includes/modal/update_username_query.php">
					<div class="modal-header">
						<h5 class="modal-title">Change <?php if (($fetch['empid']) <= 9) {
															// echo 'PTNT-0', $fetch['id'];
															echo 'EMP-000', $fetch['empid'];
														} elseif (($fetch['empid']) <= 99) {
															echo 'EMP-00', $fetch['empid'];
														} elseif (($fetch['empid']) <= 999) {
															echo 'EMP-0', $fetch['empid'];
														} else {
															echo 'EMP-', $fetch['empid'];
														}  ?> Username
						</h5>
						<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
					</div>
					<div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
						<!-- EMPLOYEE/USER ID -->
						<input class="form-control" type="hidden" name="employeeid" value="<?php echo $fetch['empid']; ?>" required="required">
						<input class="form-control" type="hidden" name="fname" value="<?php echo $fetch['user_fname']; ?>" required="required">
						<input class="form-control" type="hidden" name="lname" value="<?php echo $fetch['user_lname']; ?>" required="required">
						<div class="row  mt-2">
							<div class="col-12">
								<div class="form-group">
									<label for="username">
										<span> Username</span>
										<span class="text-danger"> * </span>
									</label>

									<input class="form-control" type="text" placeholder="Enter New Username" name="username" required="required">

								</div>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-12">

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
	<?php } else { ?>
		<div class="modal-dialog  modal-dialog-centered">
			<div class=" modal-content bg-light">
				<div class="modal-header">
					<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
				</div>
				<div class="modal-body ml-5 mr-5 mb-3 mt-3">
					<div class="row">
						<div class="col-12">
							<i class="fa fa-exclamation-circle float-left text-info" style="font-size:50px"> </i>

							<p class="h6 text-center mt-3 text-dark"> You cannot change the username for the inactive user</p>
						</div>
					</div>
				</div>
				<div style="clear:both;"></div>
				<div class="modal-footer">
					<button class="btn btn-outline-secondary" type="button" data-dismiss="modal"> Close</button>

				</div>
			</div>
		</div>
	<?php }  ?>
</div>