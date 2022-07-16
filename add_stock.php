<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
	header("location: index.php");
	exit;
}
if (isset($_SESSION["loggedin"]) && ($_SESSION["utadmin"])) {
	require_once 'includes/config.php';
?>
	<!DOCTYPE html>
	<html lang="en">


	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="img/logo.png">
		<title>Add Stock</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>

		<!--FONT AWESOME-->
		<link rel="stylesheet" href="path/to/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

		<!-- OUR CUSTOM CSS-->
		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>
		<div class="wrapper ">

			<?php
			$page = 'product';
			include 'includes/sidebar.php';
			?>
			<div class="d-flex flex-column" id="content-wrapper">

				<!--CONTENT-->
				<div class="content">

					<!--TOP NAVBAR/ HEADER-->
					<nav class="navbar navbar-expand-lg navbar-light bg-light top-header">
						<button type="button" id="sidebarCollapse" class="btn menu-btn">
							<i class="fa fa-align-justify"> </i>
						</button>
						<h5 class="navbar-header-text">Add Stock</h5>
						<?php include 'includes/top_navbar.php'; ?>
					</nav>

					<!--MAIN CONTENT-->
					<div class="container-fluid">
						<div class="card shadow">
							<div class="card-header py-3">
								<div class="row">
									<div class="col-12">
										<p class="text-primary m-0 font-weight-normal">Product List</p>
									</div>

								</div>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="table-responsive mt-1">
										<table id="dataTable" class="table table-bordered table-hover" style="width:100%">
											<thead>

												<tr>
													<th class="align-middle">Product Category</th>
													<th class="align-middle">Inventory ID </th>
													<th class="align-middle">Name</th>
													<th class="align-middle">Species </th>
													<th class="align-middle">Quantity on Hand</th>
													<th class="align-middle">Price</th>
													<th class="align-middle">Action </th>
												</tr>
											</thead>
											<tbody>
												<?php
												require_once 'includes/config.php';
												$sql = "SELECT * FROM inventory AS i
											LEFT JOIN product_category AS pc
											ON pc.name = i.product_category
											 WHERE status='Active'";
												$query = mysqli_query($conn, $sql);

												while ($fetch = mysqli_fetch_array($query)) {
												?>
													<tr>
														<td><?php echo $fetch['product_category'] ?></td>
														<td><?php if (($fetch['inventory_id']) <= 9) {
																echo 'PRDCT-000', $fetch['inventory_id'];
															} elseif (($fetch['inventory_id']) <= 99) {
																echo 'PRDCT-00', $fetch['inventory_id'];
															} elseif (($fetch['inventory_id']) <= 999) {
																echo 'PRDCT-0', $fetch['inventory_id'];
															} else {
																echo 'PRDCT-', $fetch['inventory_id'];
															}  ?></td>

														<td><?php echo $fetch['product_name'] ?></td>
														<td><?php if (!empty($fetch['species2'])) {
																echo $fetch['species1'], ' & ', $fetch['species2'];
															} else {
																echo $fetch['species1'];
															} ?></td>
														<td>
															<div class="<?php if ($fetch['quantity_on_hand']  <= '10') {
																			echo "text-danger";
																		} elseif ($fetch['quantity_on_hand'] <= '30') {
																			echo "text-warning";
																		} else {
																			echo "text-primary";
																		} ?>">
																<?php echo $fetch['quantity_on_hand']  ?> </div>
														</td>
														<td><?php echo '₱ ', number_format($fetch['price'], 2); ?></td>
														<td>
															<button class="btn btn-primary text-light btn-sm action-btn" data-toggle="modal" data-target="#addstock<?php echo $fetch['inventory_id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Add Stock">
																<i class="fa fa-plus"> </i>
																<!-- <span class="mobile-icon-only">Add</span> -->
															</button>
															<button class="btn btn-orange text-light btn-sm action-btn" data-toggle="modal" data-target="#update<?php echo $fetch['inventory_id'] ?>" data-toggle-title="tooltip" data-placement="bottom" title="Update">
																<i class="fa fa-pencil"></i>
																<!-- <span class="mobile-icon-only">Update</span> -->
															</button>
															<button class="btn text-light btn-sm action-btn" data-toggle="modal" data-target="#view-info<?php echo $fetch['inventory_id']; ?>" data-toggle-title="tooltip" data-placement="bottom" title="View Information" style="background-color:#3895D3;">
																<i class="fa fa-eye"></i>
																<!-- <span class="mobile-icon-only"> Information</span> -->
															</button>
														</td>

													</tr>

												<?php
													include 'includes/modal/update_product.php';
													include 'includes/modal/update_stock.php';
													include 'includes/modal/add_stock.php';
													include 'includes/modal/view_inventory_product.php';
												}
												?>
											</tbody>
											<tfoot>

											</tfoot>

										</table>
									</div>

								</div>

							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		</div>

		<?php include 'includes/footer.php'; ?>


		<!--Icon-->
		<script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js "></script>
		<!--OUR JS-->
		<script src="js/script.js "></script>
		<!-- DATA TABLE -->
		<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"> </script>
		<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"> </script>
		<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
		<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"> -->
		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
		<script>
			// $('#dataTable').append('<caption style="caption-side: bottom">As of <?php date_default_timezone_set('Asia/Manila');
																					// 																	$date = new DateTime();
																					// 																	echo 'As of ', $date->format('F d\, Y h:i:s a'); 
																					?> </caption>')
			$('#dataTable').dataTable({
				// processing: true,
				// serverSide: true,
				// ajax: "patient_list.inc.php",
				lengthMenu: [10, 5, 10, 25, 50, 100],
				language: {
					search: "_INPUT_",
					searchPlaceholder: "Search Product"
				},
				//Disable Action sorting (yung arrow up and down)
				columnDefs: [{
					'targets': [6],
					'orderable': false,
				}],
				"order": [
					[1, "desc"]
				]
			});
		</script>
	</body>

	</html>
<?php } else {
	include '404.php';
} ?>