   <div class="modal fade" id="processunpaidtransaction<?php echo $fetch['trans_id'] ?>" tabindex="-1" aria-labelledby="processunpaidtransaction" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title"> <?php if (($fetch['trans_id']) <= 9) {
                                                echo 'TRNS-0000', $fetch['trans_id'];
                                            } elseif (($fetch['trans_id']) <= 99) {
                                                echo 'TRNS-000', $fetch['trans_id'];
                                            } elseif (($fetch['trans_id']) <= 999) {
                                                echo 'TRNS-00', $fetch['trans_id'];
                                            } elseif (($fetch['trans_id']) <= 9999) {
                                                echo 'TRNS-0', $fetch['trans_id'];
                                            } else {
                                                echo 'TRNS-00-', $fetch['trans_id'];
                                            }  ?></h5>
                   <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
               </div>
               <div class="modal-body ml-5 mr-5 mb-3 mt-3">
                   <div class="row mb-2 ">
                       <div class="col-6">
                           <div class="text-secondary mb-2"> Client Name</div>
                       </div>
                       <div class="col-6">
                           <?php echo htmlspecialchars($fetch['fname']), ' ', htmlspecialchars($fetch['lname']); ?>
                       </div>
                   </div>
                   <?php if (!empty($fetch['name'])) {
                    ?>

                       <div class="row mb-2 ">
                           <div class="col-6">
                               <div class="text-secondary mb-2"> Patient Name</div>
                           </div>
                           <div class="col-6">
                               <?php echo htmlspecialchars($fetch['name']) ?>
                           </div>
                       </div>
                   <?php
                    } ?>
                   <div class="row mb-2 ">
                       <div class="col-6">
                           <div class="text-secondary mb-2"> Total</div>
                       </div>
                       <div class="col-6">
                           <?php echo htmlspecialchars($fetch['grand_total']); ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-6">
                           <div class="text-secondary mb-2"> Transaction Date</div>
                       </div>
                       <div class="col-6">
                           <?php echo htmlspecialchars($fetch['transaction_date']); ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-6">
                           <div class="text-secondary mb-2"> Products</div>
                       </div>
                       <div class="col-6">
                           <?php echo htmlspecialchars($fetch['products']); ?>
                       </div>
                       <div class="col-6">
                           <?php echo htmlspecialchars($fetch['quantity']); ?>
                       </div>
                   </div>


               </div>
           </div>

       </div>
   </div>