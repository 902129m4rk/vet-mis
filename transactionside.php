<!-- SIDE PART NA SUMMARY -->
<?php
if (!empty($_SESSION['pointofsale'])) :

  $total = 0;

  foreach ($_SESSION['pointofsale'] as $key => $product) :
?>
  <?php
    $total = $total + ($product['quantity'] * $product['price']);
  endforeach;
  ?>
  <div class="row mb-3 my-flex-card">
    <div class="col">
      <div class="row">
        <div class="col">
          <div class="card shadow mb-3">
            <div class="card-header py-3">
              <p class="text-primary m-0 font-weight-normal">Information</p>
            </div>
            <div class="card-body">
              <div class="row mb-2">
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 ">
                  <div class="form-col">
                    <label for="id_label_single">Pet Owner Name <span class="text-danger"> * </span> </label>
                    <select class="form-control js-example-basic-single" id='clienttselect' title="Select Pet Owner" data-actions-box="true" data-live-search="true" onChange="getpatient(this.value);" name="customer" required="required">
                      <option value='' disabled selected hidden>Select Pet Owner</option>
                      <?php
                      $sql = "SELECT * FROM owner ORDER BY fname";
                      $query = mysqli_query($conn, $sql);


                      while ($row = mysqli_fetch_array($query)) {
                        //Remain selected value
                        $selected = '';
                        if (!empty($_POST['customer']) and $_POST['customer'] == $row['id']) {
                          $selected = ' selected="selected"';  // select
                        }

                        echo '<option value="' . $row['id'] . '"' . $selected . '>' . $row['fname'], ' ', $row['lname'] . '</option>';

                      ?>


                      <?php
                      }
                      ?>
                    </select>

                  </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                  <div class="form-col">
                    <label for="select_patient">Pet Name
                      <span class="text-danger"> * </span>
                    </label>
                    <select class="form-control placeholder js-example-basic-single" title="Select Pet" data-live-search="true" name="select_patient" id="patient-list" required="required">
                      <option value='' disabled selected hidden>Select Pet</option>

                    </select>
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 ">
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 ">
                  <div class="form-group mt-2">
                    <span">Total</span>
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <span class="input-group-text">₱</span>
                        </div>
                        <input type="text" class="form-control text-right " value="<?php echo number_format($total, 2); ?>" readonly>
                        <input type="hidden" name="total" value="<?php echo $total; ?>">
                      </div><br>

                      <div class="row">
                        <div class="col">
                          <button type="button" class="btn btn-primary float-right float-lg-right float-md-right float-sm-right" data-toggle="modal" data-target="#posMODAL">Process Payment</button>
                          <button type="button" class="btn btn-outline-primary float-right float-lg-right float-md-right float-sm-right mr-2" data-toggle="modal" data-target="#posMODAL2">Save only</button>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
            <?php include 'includes/modal/transaction_process_payment.php';
            include 'includes/modal/transaction_unprocess_payment.php'
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php endif; ?>