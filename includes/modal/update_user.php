<div class="modal fade" id="update_modal<?php echo $fetch['empid'] ?>" aria-hidden="true" tabindex="-1" aria-labelledby="update_modal">

	<div class="modal-dialog  modal-dialog-centered modal-lg">
		<div class=" modal-content bg-light">
			<form method="POST" action="includes/modal/update_user_query.php">
				<div class="modal-header">
					<h5 class="modal-title">Update <?php if (($fetch['empid']) <= 9) {
														// echo 'PTNT-0', $fetch['id'];
														echo 'EMP-000', $fetch['empid'];
													} elseif (($fetch['empid']) <= 99) {
														echo 'EMP-00', $fetch['empid'];
													} elseif (($fetch['empid']) <= 999) {
														echo 'EMP-0', $fetch['empid'];
													} else {
														echo 'EMP-', $fetch['empid'];
													}  ?>
					</h5>
					<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
				</div>
				<div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
					<div class="row">
						<div class="col-lg-4 col-xl-4 col-md-12 col-sm-12 col-12">
							<div class="form-group mt-2">
								<label>First Name <span class="text-danger"> * </span></label>
								<input name="userid" type="hidden" value="<?php echo htmlspecialchars($fetch['empid'])  ?>" class="form-control">
								<input type="text" placeholder="Enter First Name" name="fname" value="<?php echo htmlspecialchars($fetch['user_fname']) ?>" class="form-control" required="required">
							</div>
						</div>
						<div class="col-lg-4 col-xl-4 col-md-12 col-sm-12 col-12">
							<div class="form-group mt-2">
								<label>Middle Name <span class="text-danger"> * </span></label>
								<input type="text" placeholder="Enter Middle Name" name="mname" value="<?php echo htmlspecialchars($fetch['user_mname']) ?>" class="form-control" required="required">
							</div>
						</div>
						<div class="col-lg-4 col-xl-4 col-md-12 col-sm-12 col-12">
							<div class="form-group mt-2">
								<label>Last Name <span class="text-danger"> * </span></label>
								<input type="text" placeholder="Enter Last Name" name="lname" value="<?php echo htmlspecialchars($fetch['user_lname']) ?>" class="form-control" required="required">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group mt-2">
								<label for="gender">Gender <span class="text-danger"> * </span> </label>
								<select class="form-control placeholder" name="gender" required="required">
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
							<div class="form-group mt-2">
								<label>Birthdate<span class="text-danger"> * </span> </label>
								<input type="date" name="bday" value="<?php echo $fetch['bday'] ?>" class="form-control" required="required" />
							</div>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group">
								<label for="select_prov">Province<span class="text-danger"> * </span>
								</label>

								<select class="form-control" onChange="getcitymodal<?php echo $fetch['empid']; ?>(this.value);" name="select_prov" required="required">

									<?php
									$provid = $fetch['province'];
									$sqlprov = "SELECT *FROM province WHERE id= '$provid'
                                                                             ORDER BY province_name";
									$queryprov = mysqli_query($conn, $sqlprov);
									$fetchprov = mysqli_fetch_assoc($queryprov);
									$province = $fetchprov['province_name'];

									if (!empty($fetch['province'])) { ?>
										<option value='<?php echo $fetch['province']; ?>'><?php echo $province; ?></option>
									<?php } else { ?>
										<option value='' disabled selected hidden>Select Province</option>
									<?php } ?>
									<?php
									$sql = "SELECT *FROM province ORDER BY province_name";
									$query = mysqli_query($conn, $sql);


									while ($row2 = mysqli_fetch_array($query)) {
										//Remain selected value
										$selected = '';
										if (!empty($_POST['select_prov']) and $_POST['select_prov'] == $row2['province_name']) {
											$selected = ' selected="selected"';  // select
										}

										echo '<option value="' . $row2['id'] . '"' . $selected . '>' . $row2['province_name'] . '</option>';
									}


									?>
								</select>
							</div>
						</div>
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group">
								<label for="select_city">City / Municipality<span class="text-danger"> * </span> </label>

								<select class="form-control" name="select_city" id="city-list<?php echo $fetch['empid']; ?>" required="required">
									<?php
									$cityid = $fetch['city'];
									$sqlcity = "SELECT *FROM city_municipality 
													WHERE id= '$cityid'
													ORDER BY citymunicipality_name;";
									$querycity = mysqli_query($conn, $sqlcity);
									$fetchprov = mysqli_fetch_assoc($querycity);
									$city = $fetchprov['citymunicipality_name'];

									if (!empty($fetch['city'])) { ?>
										<option value='<?php echo $fetch['city']; ?>'><?php echo $city; ?></option>
										<?php
										$prov = $fetch['province'];
										$sql = "SELECT *
													FROM city_municipality AS cm
													WHERE province_id='" . $prov . "'
													ORDER BY citymunicipality_name ASC
													;";

										$query = mysqli_query($conn, $sql);
										while ($row2 = mysqli_fetch_array($query)) {
											$selected = '';
											if (!empty($_POST['select_city']) and $_POST['select_city'] == $row2['id']) {
												$selected = ' selected="selected"';  // select
											}
											echo '<option value="' . $row2['id'] . '"' . $selected . '>' . $row2['citymunicipality_name'] . '</option>';
										}
									} else { ?>
										<option value='' disabled selected hidden>Select City / Municipality</option>
									<?php } ?>

								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group mt-2">
								<span> Mobile Number <span class="text-danger"> * </span> </span>
								<input type="text" placeholder="Enter Mobile Number" name="contactno" value="<?php echo $fetch['contact_no'] ?>" class="form-control" required="required" />
							</div>
						</div>
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group mt-2">
								<span> E-mail Address <span class="text-danger"> * </span> </span>
								<input type="text" placeholder="Enter E-mail Address" name="email" value="<?php echo $fetch['email'] ?>" class="form-control" required="required" />

							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group mt-2">
								<?php $usertype = $fetch['user_type'] ?>
								<label for="user_type">User Type <span class="text-danger"> * </span> </label>
								<select class="form-control placeholder" name="user_type" required="required">
									<option value="">Select User Type</option>
									<option value="Admin" <?php if (isset($usertype) && $usertype == "Admin") echo "selected" ?>>Admin </option>
									<option value="Staff" <?php if (isset($usertype) && $usertype == "Staff") echo "selected" ?>>Staff</option>
									<option value="Veterinarian" <?php if (isset($usertype) && $usertype == "Veterinarian") echo "selected" ?>>Veterinarian</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group mt-2">
								<label for="user_stat"> User Status </label>
								<select class="form-control placeholder" name="user_stat" required="required">
									<option value="">Select User Status </option>
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