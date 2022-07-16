<div class="modal fade" id="update<?php echo $fetch['inventory_id'] ?>" aria-hidden="true" tabindex="-1" aria-labelledby="update">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class=" modal-content bg-light">
			<form method="POST" action="includes/modal/update_product_query.php">
				<div class="modal-header">
					<h5 class="modal-title">Update <?php if (($fetch['inventory_id']) <= 9) {
														// echo 'PTNT-0', $fetch['id'];
														echo 'PRDCT-000', htmlspecialchars($fetch['inventory_id']);
													} elseif (($fetch['inventory_id']) <= 99) {
														echo 'PRDCT-00', htmlspecialchars($fetch['inventory_id']);
													} elseif (($fetch['inventory_id']) <= 999) {
														echo 'PRDCT-0', htmlspecialchars($fetch['inventory_id']);
													} else {
														echo 'PRDCT-', htmlspecialchars($fetch['inventory_id']);
													}  ?> </h5>
					<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
				</div>
				<div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
					<!-- <div class="col-md-5"></div> -->
					<div class="row">
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group mt-2">
								<label for="prod_name">Product Name <span class="text-danger"> * </span> </label>
								<input class="form-control" type="text" placeholder="Enter Product Name" name="prod_name" required="required" value="<?php echo $fetch['product_name'] ?>">
							</div>
						</div>
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<input type="hidden" name="prodid" value="<?php echo $fetch['inventory_id'] ?>">
							<div class="form-group mt-2">
								<label for="prod_category">Product Category <span class="text-danger"> * </span> </label>
								<select class="form-control placeholder" name="prod_category" required="required">
									<option value="">Select Product Category</option>
									<?php
									$prodcatr = mysqli_query($conn, "SELECT DISTINCT name FROM product_category  WHERE status='Active' ORDER BY name asc");
									foreach ($prodcatr  as $rowprodcat) : ?>
										<option value="<?php echo  $rowprodcat['name']; ?>" <?php if ($fetch['product_category'] ==   $rowprodcat['name']) echo 'selected="selected"'; ?>><?php echo  $rowprodcat['name']; ?> </option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group mt-2">
								<label for="pet_species1">Species 1 <span class="text-danger"> * </span></label>
								<select class="form-control placeholder" name="pet_species1" required="required">
									<option value="">Select Species</option>
									<?php
									$species  = mysqli_query($conn, "SELECT DISTINCT name FROM species WHERE status='Active' ORDER BY name asc");
									foreach ($species as $row) : ?>
										<option value="<?php echo $row['name']; ?>" <?php if ($fetch['species1'] == $row['name']) echo 'selected="selected"'; ?>><?php echo $row['name']; ?> </option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group mt-2">
								<label for="pet_species2">Species 2 </label>
								<select class="form-control placeholder" name="pet_species2">
									<option value="">Select Species</option>
									<?php
									$species  = mysqli_query($conn, "SELECT DISTINCT name FROM species WHERE status='Active' ORDER BY name asc");
									foreach ($species as $row) : ?>
										<option value="<?php echo $row['name']; ?>" <?php if ($fetch['species2'] == $row['name']) echo 'selected="selected"'; ?>><?php echo $row['name']; ?> </option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group mt-2">
								<label for="prod_quantity">Quantity on Hand<span class="text-danger"> * </span> </label>
								<input class="form-control" type="number" min="0" placeholder="Enter Quantity on Hand" name="prod_quantity" required="required" value="<?php echo $fetch['quantity_on_hand'] ?>" disabled>
								<input type="hidden" min="0" placeholder="Enter Number of New Stock" name="prod_quantity" required="required" value="<?php echo $fetch['quantity_on_hand'] ?>">
							</div>
						</div>
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group mt-2">
								<label for="test_cost">Price<span class="text-danger"> * </span> </label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">₱</span>
									</div>
									<input class="form-control" type="number" min="0" step="0.01" placeholder="Enter Product Cost " name="prod_price" required="required" value="<?php echo $fetch['price'] ?>">
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12 col-12">
							<div class="form-group mt-2">
								<label for="prod_quantity">Add New Stock</label>
								<input class="form-control" type="number" min="0" placeholder="Enter Number of New Stock" name="add_stock">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="form-group mt-2 mb-2">
								<label for="prod_desc"><span>Product Description </span> <span class="text-danger"> * </span> </label>
								<textarea class="form-control" name="prod_desc" rows="5"> <?php echo $fetch['description'];  ?> </textarea>
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