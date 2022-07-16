<div class="modal fade" id="update_modal<?php echo $fetch['id']; ?>" aria-hidden="true" tabindex="-1" aria-labelledby="update_client">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class=" modal-content bg-light">
			<form method="POST" action="includes/modal/update_pet_owner_query.php">
				<div class="modal-header">
					<!-- <h5 class="modal-title">Update Client</h5> -->
					<h5 class="modal-title">Update <?php if (($fetch['id']) <= 9) {
														// echo 'PTNT-0', $fetch['id'];
														echo 'PTOWNR-000', $fetch['id'];
													} elseif (($fetch['id']) <= 99) {
														echo 'PTOWNR-00', $fetch['id'];
													} elseif (($fetch['id']) <= 999) {
														echo 'PTOWNR-0', $fetch['id'];
													} else {
														echo 'PTOWNR-', $fetch['id'];
													}  ?></h5>
					<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
				</div>
				<div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
					<!-- <div class="col-md-5"></div> -->
					<div class="row  mt-2">
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group">
								<label>First Name<span class="text-danger"> * </span></label>
								<input type="hidden" name="id" value="<?php echo $fetch['id'] ?>" />
								<input placeholder="Enter First Name" type="text" name="fname" value="<?php echo $fetch['fname']; ?>" class="form-control" required="required" />
							</div>
						</div>
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group">
								<label>Last Name<span class="text-danger"> * </span></label>
								<input placeholder="Enter Last Name" type="text" name="lname" value="<?php echo $fetch['lname']; ?>" class="form-control" required="required" />
							</div>
						</div>
					</div>
					<div class="row  mt-2">
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group">
								<label for="owner_gender">Gender <span class="text-danger"> * </span></label>
								<select class="form-control placeholder" name="owner_gender" required="required">
									<option value="">Select Gender </option>
									<option value="Male" <?php if ($fetch['gender'] == 'Male') {
																echo "selected";
															} ?>>Male </option>

									<option value="Female" <?php if ($fetch['gender'] == 'Female') {
																echo "selected";
															}  ?>>Female</option>
									<option value="LGBTQIA+" <?php if ($fetch['gender'] == 'LGBTQIA+') {
																	echo "selected";
																} ?>>LGBTQIA+</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group">
								<label>Birthdate<span class="text-danger"> * </span></label>
								<input type="date" name="owner_bday" value="<?php echo $fetch['bday']; ?>" class="form-control" required="required" />
							</div>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group">
								<label for="select_prov">Province<span class="text-danger"> * </span>
								</label>

								<select class="form-control" onChange="getcitymodal<?php echo $fetch['id']; ?>(this.value);" name="select_prov" required="required">

									<?php if (!empty($fetch['province'])) { ?>
										<option value='<?php echo $fetch['province']; ?>'><?php echo $fetch['province_name']; ?></option>
									<?php } else { ?>
										<option value='' disabled selected hidden>Select Province</option>
									<?php } ?>
									<?php
									$sql = "SELECT *FROM province ORDER BY province_name";
									$query = mysqli_query($conn, $sql);


									while ($row = mysqli_fetch_array($query)) {
										//Remain selected value
										$selected = '';
										if (!empty($_POST['select_prov']) and $_POST['select_prov'] == $row['province_name']) {
											$selected = ' selected="selected"';  // select
										}

										echo '<option value="' . $row['id'] . '"' . $selected . '>' . $row['province_name'] . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group">
								<label for="select_city">City / Municipality<span class="text-danger"> * </span> </label>

								<select class="form-control" name="select_city" id="city-list<?php echo $fetch['id']; ?>" required="required">
									<?php if (!empty($fetch['city'])) { ?>
										<option value='<?php echo $fetch['city']; ?>'><?php echo $fetch['citymunicipality_name']; ?></option>
										<?php
										$prov = $fetch['province'];
										$sql = "SELECT *
											FROM city_municipality AS cm
											WHERE province_id='" . $prov . "'
											ORDER BY citymunicipality_name ASC
											;";

										$query = mysqli_query($conn, $sql);
										while ($row = mysqli_fetch_array($query)) {
											$selected = '';
											if (!empty($_POST['select_city']) and $_POST['select_city'] == $row['id']) {
												$selected = ' selected="selected"';  // select
											}
											echo '<option value="' . $row['id'] . '"' . $selected . '>' . $row['citymunicipality_name'] . '</option>';
										}
									} else { ?>
										<option value='' disabled selected hidden>Select City / Municipality</option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group">
								<span> Contact Number<span class="text-danger"> * </span> </span>
								<input placeholder="Enter Contact Number" type="text" name="contactno" value="<?php echo $fetch['contactno'] ?>" class="form-control" required="required" />
							</div>
						</div>
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group">
								<span> E-mail Address<span class="text-danger"> * </span> </span>
								<input placeholder="Enter Email-Address" type="text" name="email" value="<?php echo $fetch['email'] ?>" class="form-control" required="required" />

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