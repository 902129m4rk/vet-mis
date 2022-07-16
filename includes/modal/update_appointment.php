<div class="modal fade" id="update_modal<?php echo $fetch['id'] ?>" aria-hidden="true" tabindex="-1" aria-labelledby="update_client">
	<div class="modal-dialog modal-dialog-centered">
		<div class=" modal-content bg-light">
			<form method="POST" action="includes/modal/update_appointment_query.php">
				<div class="modal-header">
					<h5 class="modal-title">Update <?php if (($fetch['id']) <= 9) {
														echo 'APT-000', htmlspecialchars($fetch['id']);
													} elseif (($fetch['id']) <= 99) {
														echo 'APT-00', htmlspecialchars($fetch['id']);
													} elseif (($fetch['id']) <= 999) {
														echo 'APT-0', htmlspecialchars($fetch['id']);
													} else {
														echo 'APT-', htmlspecialchars($fetch['id']);
													}  ?>
					</h5>
					<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
				</div>
				<div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
					<input name="id" type="hidden" value="<?php echo htmlspecialchars($fetch['id'])  ?>" class="form-control">


					<?php $orgistatus = $fetch['status'];
					$orgiservice = $fetch['service'];
					$orgidate = $fetch['date'];
					$orgitime = $fetch['time'];
					$orgivet =  $fetch['assigned_vet'];

					?>
					<input name="orig_aptstat" type="hidden" value="<?php echo $orgistatus; ?>">
					<input name="orig_date" type="hidden" value="<?php echo $orgidate;  ?>" class="form-control">
					<input name="orig_time" type="hidden" value="<?php echo $orgitime;  ?>" class="form-control">
					<input name="orig_service" type="hidden" value="<?php echo $orgiservice;  ?>" class="form-control">
					<input name="orig_vet" type="hidden" value="<?php echo $assign_vet;  ?>" class="form-control">


					<div class="form-group mt-2">
						<label>Pet Name <span class="text-danger"> * </span></label>
						<input type="text" name="pname" value="<?php echo htmlspecialchars($fetch['name']) ?>" class="form-control" disabled>
						<input type="hidden" name="pname" value="<?php echo htmlspecialchars($fetch['name']) ?>">
						<input type="hidden" name="petid" value="<?php echo htmlspecialchars($fetch['pet_id']) ?>">
					</div>
					<div class="form-group mt-2">
						<label>Pet Owner Name <span class="text-danger"> * </span></label>
						<input type="text" name="lname" value="<?php echo htmlspecialchars($fetch['fname']), ' ', htmlspecialchars($fetch['lname']) ?>" class="form-control" disabled>
					</div>
					<div class="form-group mt-2">
						<label for="service">Service <span class="text-danger"> * </span> </label>
						<select class="form-control placeholder" name="service" id="service" required="required">
							<option value="">Select Service</option>
							<?php
							$service  = mysqli_query($conn, "SELECT DISTINCT name FROM service WHERE status='Active' ORDER BY name asc");
							foreach ($service as $row) : ?>
								<option value="<?php echo $row['name']; ?>" <?php if ($fetch['service'] == $row['name']) echo 'selected="selected"'; ?>><?php echo htmlspecialchars($row['name']); ?> </option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group mt-2">
						<label for="apt_date"><span> Date</span> <span class="text-danger"> * </span></label>
						<input class="form-control" type="date" name="apt_date" required="required" value="<?php echo htmlspecialchars($fetch['date']) ?>">
					</div>
					<div class="form-group mt-2">
						<label for="apt_time"><span>Time</span> <span class="text-danger"> * </span></label>
						<input class="form-control" type="time" name="apt_time" required="required" value="<?php echo htmlspecialchars($fetch['time']) ?>">
					</div>
					<div class="form-group mt-2">
						<label for="status"> Status <span class="text-danger"> * </span> </label>
						<select class="form-control placeholder" name="status" required="required">
							<option value="">Select Appointment Status </option>
							<option value="Scheduled" <?php if ($fetch['status'] == 'Scheduled') {
															echo "selected";
														} ?>>Scheduled </option>

							<option value="Canceled" <?php if ($fetch['status'] == 'Canceled') {
															echo "selected";
														}  ?>>Canceled</option>
							<option value="Completed" <?php if ($fetch['status'] == 'Completed') {
															echo "selected";
														} ?>>Completed </option>

							<option value="No Show" <?php if ($fetch['status'] == 'No Show') {
														echo "selected";
													}  ?>>No Show</option>
						</select>
					</div>
					<div class="form-group mt-2">
						<label for="assignedvet">Assign Veterinarian <span class="text-danger"> * </span> </label>
						<select class="form-control placeholder" name="assignedvet" required="required">
							<option value="">Select Veterinarian</option>
							<?php
							$apt  = mysqli_query($conn, "SELECT DISTINCT empid, user_fname, user_lname
							FROM users AS u
							INNER JOIN appointment AS apt
							ON u.empid= apt.assigned_vet
							WHERE 
							user_status='Active' 
							AND user_type='Veterinarian'
							ORDER BY user_fname asc");
							foreach ($apt as $row) : ?>
								<option value="<?php echo $row['empid']; ?>" <?php if ($fetch['user_fname'] == $row['user_fname'] and $fetch['user_lname'] == $row['user_lname']) echo 'selected="selected"'; ?>><?php echo $row['user_fname'], ' ', $row['user_lname'];  ?> </option>
							<?php endforeach; ?>
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