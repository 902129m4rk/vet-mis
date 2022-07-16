<div class="modal fade" id="update_modal<?php echo $fetch['id'] ?>" aria-hidden="true" tabindex="-1" aria-labelledby="update_patient">
	<div class="modal-dialog modal-dialog-centered ">
		<div class=" modal-content bg-light">

			<div class="modal-header">
				<h5 class="modal-title">Update <?php if (($fetch['id']) <= 9) {
													echo 'PT-000', $fetch['id'];
												} elseif (($fetch['id']) <= 99) {
													echo 'PT-00', $fetch['id'];
												} elseif (($fetch['id']) <= 999) {
													echo 'PT-0', $fetch['id'];
												} else {
													echo 'PT-', $fetch['id'];
												}  ?></h5>
				<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
			</div>
			<?php if ($fetch['vitality_status'] == 'Alive') {
			?>
				<form method="POST" action="includes/modal/update_pet_query.php">
					<div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
						<!-- <div class="col-md-5"></div> -->
						<div class="col">
							<div class="form-group">
								<label>Name<span class="text-danger"> * </span></label>
								<input type="hidden" name="id" value="<?php echo $fetch['id'] ?>" />
								<input type="text" name="pet_name" value="<?php echo $fetch['name'] ?>" class="form-control" required="required" />
							</div>
							<div class="form-group mt-2">
								<label for="pet_gender">Gender <span class="text-danger"> * </span></label>
								<select class="form-control placeholder" name="pet_gender" required="required">
									<option value="">Select Gender </option>
									<option value="Male" <?php if ($fetch['gender'] == 'Male') {
																echo "selected";
															} ?>>Male </option>

									<option value="Female" <?php if ($fetch['gender'] == 'Female') {
																echo "selected";
															}  ?>>Female</option>
									<option value="Neutral" <?php if ($fetch['gender'] == 'Neutral') {
																echo "selected";
															} ?>>Neutral</option>
								</select>
							</div>
							<div class="form-group mt-2">
								<label>Birthdate<span class="text-danger"> * </span></label>
								<input type="date" name="pet_bday" value="<?php echo $fetch['bday'] ?>" class="form-control" required="required" />
							</div>
							<div class="form-group mt-2">
								<span> Weight (kg)<span class="text-danger"> * </span></span>
								<input type="number" min="0" step="0.01" name="weight" value="<?php echo $fetch['weight'] ?>" class="form-control" required="required" />

							</div>
							<div class="form-group mt-2">
								<label for="pet_species">Species <span class="text-danger"> * </span></label>
								<select class="form-control placeholder" onChange="getbreed(this.value);" name="pet_species" id="species" required="required">
									<option value="">Select Species</option>
									<?php
									$species  = mysqli_query($conn, "SELECT DISTINCT name FROM species WHERE status='Active' ORDER BY name asc");
									foreach ($species as $row) : ?>
										<option value="<?php echo $row['name']; ?>" <?php if ($fetch['species'] == $row['name']) echo 'selected="selected"'; ?>><?php echo $row['name']; ?> </option>
									<?php endforeach; ?>
								</select>
							</div>
							<?php if (!empty($fetch['breed'])) { ?>
								<div class="form-group mt-2">
									<label>Breed</label>
									<input type="text" name="pet_breed" value="<?php echo $fetch['breed']; ?>" class="form-control">
								</div>
							<?php	} else { ?>
								<div class="form-group mt-2">
									<label>Breed</label>
									<input type="text" name="pet_breed" placeholder="Enter Breed Name" class="form-control">
								</div>
							<?php } ?>

							<div class="form-group mt-2">
								<label for="pet_vitality_status"> Vitality Status <span class="text-danger"> * </span></label>
								<select class="form-control placeholder" name="pet_vitality_status" required="required">
									<option value="">Select Vitality Status </option>
									<option value="Alive" <?php if ($fetch['vitality_status'] == 'Alive') {
																echo "selected";
															} ?>>Alive </option>

									<option value="Dead" <?php if ($fetch['vitality_status'] == 'Dead') {
																echo "selected";
															}  ?>>Dead</option>
								</select>
							</div>



						</div>
					</div>
					<div style="clear:both;"></div>
					<div class="modal-footer">
						<button class="btn btn-outline-secondary" type="button" data-dismiss="modal"> Close</button>
						<button name="update" class="btn btn-primary"> Update</button>
					</div>
				</form>
			<?php } else { ?>
				<div class="modal-body ml-5 mr-5 mb-3 mt-3">
					<div class="row">
						<div class="col-12">
							<i class="fa fa-question-circle-o float-left text-primary" style="font-size:50px"> </i>
							<p class="h6 text-center mt-3 mr-2 text-dark"> You cannot update information for a dead pet</p>
						</div>
					</div>
				</div>
				<div style="clear:both;"></div>
				<div class="modal-footer">
					<button class="btn btn-outline-secondary" type="button" data-dismiss="modal"> Close</button>
				</div>


			<?php  } ?>
		</div>

	</div>
</div>
</div>