<div class="modal fade" id="update_company_info" aria-hidden="true" tabindex="-1" aria-labelledby="update_company_info">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class=" modal-content bg-light">
			<form method="POST" action="includes/modal/update_company_info_query.php">
				<div class="modal-header">
					<h5 class="modal-title">Update Company Profile</h5>
					<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
				</div>
				<div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label for="clinic_name">
									<span> Clinic Name</span>
									<span class="text-danger"> * </span>
								</label>
								<input class="form-control" type="text" placeholder="Enter Veterinary Clinic Name" name="clinic_name" value="<?php echo $fetch['clinic_name'] ?>" required="required">

							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group mt-2">
								<label for="business_number">
									<span> Business Number</span>
									<span class="text-danger"> * </span>
								</label>
								<input class="form-control" type="hidden" placeholder="Enter Business Number" name="id" value="<?php echo $fetch['id'] ?>">
								<input class="form-control" type="number" min="0" placeholder="Enter Business Number" name="business_number" value="<?php echo $fetch['business_number'] ?>" required="required">
							</div>
						</div>
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group mt-2">
								<label for="clinic_name">
									<span> Clinic Phone Number</span>
									<span class="text-danger"> * </span>
								</label>
								<input class="form-control" type="text" placeholder="Enter Clinic Phone Number" name="clinic_phoneno" value="<?php echo $fetch['clinic_contactno'] ?>" required="required">

							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group mt-2">
								<label for="clinic_owner_fname">
									<span> Owner First Name</span>
									<span class="text-danger"> * </span>
								</label>
								<input class="form-control" type="text" placeholder="Enter Owner Name" name="clinic_owner_fname" value="<?php echo $fetch['owner_fname'] ?>" required="required">

							</div>
						</div>
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group mt-2">
								<label for="clinic_owner_lname">
									<span> Owner Last Name</span>
									<span class="text-danger"> * </span>
								</label>
								<input class="form-control" type="text" placeholder="Enter Owner Name" name="clinic_owner_lname" value="<?php echo $fetch['owner_lname'] ?>" required="required">

							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group mt-2">
								<label for="select_prov">Province<span class="text-danger"> * </span>
								</label>
								<select class="form-control" onChange="getcity(this.value);" name="select_prov" required>
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
							<div class="form-group mt-2">
								<label for="select_city">City / Municipality<span class="text-danger"> * </span> </label>
								<select class="form-control" name="select_city" id="city-list" required>

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

				</div>
				<div style="clear:both;"></div>
				<div class="modal-footer">
					<button class="btn btn-outline-secondary" type="button" data-dismiss="modal"> Close</button>
					<button name="update" class="btn btn-primary"> Update</button>
				</div>
			</form>
		</div>

	</div>
</div>