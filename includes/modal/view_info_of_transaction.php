   <div class="modal fade" id="view<?php echo $fetch['payment_no']; ?>" tabindex="-1" aria-labelledby="view" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered modal-md">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title"><?php if (($fetch['payment_no']) <= 9) {
                                                echo 'TRNS-000', $fetch['payment_no'];
                                            } elseif (($fetch['payment_no']) <= 99) {
                                                echo 'TRNS-00', $fetch['payment_no'];
                                            } elseif (($fetch['payment_no']) <= 999) {
                                                echo 'TRNS-0', $fetch['payment_no'];
                                            } else {
                                                echo 'PTNT-', $fetch['payment_no'];
                                            }  ?> </h5>
                   <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
               </div>
               <div class="modal-body ml-5 mr-5 mb-3 mt-3">
                   <div class="row mb-2 ">
                       <div class="col-6">
                           <div class="text-secondary mb-2"> Transaction ID</div>
                       </div>
                       <div class="col-6">
                           <?php if (($fetch['payment_no']) <= 9) {
                                echo 'TRNS-000', htmlspecialchars($fetch['payment_no']);
                            } elseif (($fetch['payment_no']) <= 99) {
                                echo 'TRNS-00', htmlspecialchars($fetch['payment_no']);
                            } elseif (($fetch['payment_no']) <= 999) {
                                echo 'TRNS-0', htmlspecialchars($fetch['payment_no']);
                            } else {
                                echo 'PTNT-', htmlspecialchars($fetch['payment_no']);
                            }  ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-6">
                           <div class="text-secondary mb-2"> Patient Name</div>
                       </div>
                       <div class="col-6">
                           <?php echo htmlspecialchars($fetch['name']) ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-6">
                           <div class="text-secondary mb-2"> Client Name</div>
                       </div>
                       <div class="col-6">
                           <?php echo htmlspecialchars($fetch['fname']), ' ', htmlspecialchars($fetch['lname']) ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-6">
                           <div class="text-secondary mb-2"> Invoice Type</div>
                       </div>
                       <div class="col-6">
                           <?php echo htmlspecialchars($fetch['invoice_type']) ?>
                       </div>
                   </div>
                   <?php
                    if (!empty($fetch['test_group'])) { ?>
                       <div class="row mb-2 ">
                           <div class="col-6">
                               <div class="text-secondary mb-2"> Test Group</div>
                           </div>
                           <div class="col-6"> <?php
                                                echo htmlspecialchars($fetch['test_group_name'])  ?>
                           </div>
                       </div>
                   <?php
                    }
                    ?>
                   <div class="row mb-2 ">
                       <div class="col-6">
                           <div class="text-secondary mb-2"> Total Amount</div>
                       </div>
                       <div class="col-6">
                           <?php echo '₱ ', htmlspecialchars($fetch['total_amount']) ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-6">
                           <div class="text-secondary mb-2">Transaction Date</div>
                       </div>
                       <div class="col-6">
                           <?php
                            $source =  $fetch['transaction_date'];
                            $date = new DateTime($source);
                            echo $date->format('m-d-Y'); // 31-07-2012
                            ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-6">
                           <div class="text-secondary mb-2"> Payment Status</div>
                       </div>
                       <div class="col-6 
                           <?php if ($fetch['payment_status'] == 'Completed') {
                                echo "text-success";
                            } elseif ($fetch['payment_status'] == 'Pending') {
                                echo "text-danger";
                            }  ?> ">
                           <?php echo htmlspecialchars($fetch['payment_status']) ?>
                       </div>
                   </div>

                   <?php
                    if (!empty($fetch['payment_date'])) { ?>
                       <div class="row mb-2 ">
                           <div class="col-6">
                               <div class="text-secondary mb-2"> Payment Date</div>
                           </div>
                           <div class="col-6"> <?php
                                                echo htmlspecialchars($fetch['payment_date'])  ?>
                           </div>
                       </div>
                   <?php
                    }
                    ?>
               </div>
           </div>

       </div>
   </div>