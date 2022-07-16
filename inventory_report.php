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
		<title>Inventory Report </title>

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
			$page = 'report';
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
						<h5 class="navbar-header-text">Inventory Report</h5>
						<?php include 'includes/top_navbar.php'; ?>
					</nav>

					<!--MAIN CONTENT-->
					<div class="container-fluid">
						<div class="card shadow">
							<div class="card-header py-3">
								<div class="row">
									<div class="col-12">
										<p class="text-primary m-0 font-weight-normal">Inventory Report</p>
									</div>

								</div>
							</div>
							<div class="card-body">
								<div class="row mb-3 text-danger">
									<div class="col">
										<h5> <?php
												date_default_timezone_set('Asia/Manila');
												$date = new DateTime();
												echo 'As of ', $date->format('F d\, Y h:i:s a'); // 31-07-2012
												?></h5>
									</div>
								</div>
								<div class="row mt-2">
									<div class="col-7">
										<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
											<div class="input-group">
												<select class="form-control placeholder" name="product_name">
													<option value="">Filter Product Category</option>
													<?php $query = mysqli_query($conn, "SELECT * FROM product_category WHERE status='Active' ORDER BY name asc");
													while ($row = mysqli_fetch_array($query)) {
														// Remain selected value
														$selected = '';
														if (!empty($_POST['product_category']) and $_POST['product_category'] == $row['name']) {
															$selected = ' selected="selected"';  // select
														}
														echo '<option value="' . $row['name'] . '"' . $selected . '>' . $row['name'] . '</option>';
													?>
													<?php
													}
													?>
												</select>
												<div class="input-group-append">
													<button class="btn btn-primary " type="submit" name="submit">Filter</button>
													<button class="btn btn-danger " type="submit" name="reset">
														<i class="fa fa-eraser"></i>
														<span class="mobile-icon-only">Reset</span>
													</button>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<?php
									if (isset($_POST['submit'])) {
										include_once 'includes/config.php';

										$productcategory = filter_input(INPUT_POST, 'product_name');
									?>
										<div class="table-responsive mt-4">
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
												WHERE status='Active'
												AND product_category ='$productcategory'";
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
																	<?php echo $fetch['quantity_on_hand']  ?>
															</td>
															<td><?php echo '₱ ', number_format($fetch['price'], 2); ?></td>
															<td>
																<button class="btn btn-info text-light btn-sm" data-toggle="modal" data-target="#view-info<?php echo $fetch['inventory_id']; ?>" data-toggle-title="tooltip" data-placement="bottom" title="Information">
																	<i class="fa fa-info"></i>
																	<span class="mobile-icon-only"> Information</span>
																</button>
															</td>

														</tr>

													<?php
														include 'includes/modal/view_inventory_product.php';
													}
													?>
												</tbody>
												<tfoot>

												</tfoot>

											</table>
										</div>
									<?php
									} else {
									?>
										<hr class="mt-4">
										<div class="table-responsive mt-3">
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
																<button class="btn btn-info text-light btn-sm" data-toggle="modal" data-target="#view-info<?php echo $fetch['inventory_id']; ?>" data-toggle-title="tooltip" data-placement="bottom" title="Information">
																	<i class="fa fa-info"></i>
																	<span class="mobile-icon-only"> Information</span>
																</button>
															</td>

														</tr>

													<?php
														include 'includes/modal/update_product.php';
														include 'includes/modal/update_stock.php';
														include 'includes/modal/view_inventory_product.php';
													}
													?>
												</tbody>
												<tfoot>

												</tfoot>

											</table>
										</div>
									<?php
									}
									if (isset($_POST['reset'])) {
										unset($_POST['submit']);
									}
									?>
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
				dom: 'Blfrtip',
				buttons: [{
						extend: 'excelHtml5',
						exportOptions: {
							columns: [0, 1, 2, 3, 4, 5] //Your Column value those you want
						},
						messageBottom: '<?php
										$printeddate = new DateTime(); ?>
						<?php echo 'Generate Date: ', $printeddate->format('F d\, Y'); ?> ',
						messageTop: 'As of <?php date_default_timezone_set('Asia/Manila');
											$date = new DateTime();
											?><?php echo $date->format('F d\, Y h:i:s a'); ?> '
					},
					{
						extend: 'pdfHtml5',
						exportOptions: {
							columns: [0, 1, 2, 3, 4, 5] //Your Column value those you want
						},
						messageBottom: '<?php
										$printeddate = new DateTime(); ?>
						<?php echo 'Generate Date: ', $printeddate->format('F d\, Y'); ?> ',
						messageTop: 'As of <?php date_default_timezone_set('Asia/Manila');
											$date = new DateTime();
											?><?php echo $date->format('F d\, Y h:i:s a'); ?> '
					},
					{
						extend: 'print',
						exportOptions: {
							columns: [0, 1, 2, 3, 4, 5] //Your Column value those you want
						},

						customize: function(win) {
							$(win.document.body)
								.css('font-size', '10pt')

							$(win.document.body).find('table')
								.addClass('compact')
								.css('font-size', 'inherit');
						},
						messageBottom: '<?php
										$printeddate = new DateTime(); ?>
						<?php echo '<div class="mt-5 text-danger ">Printed on ', $printeddate->format('F d\, Y'), '</div>'; ?> ',
						messageTop: 'As of <?php date_default_timezone_set('Asia/Manila');
											$date = new DateTime(); ?> <?php echo $date->format('F d\, Y h:i:s a'); ?>',

					},
				]
			});
		</script>
	</body>

	</html>
<?php } else {
	include '404.php';
} ?>