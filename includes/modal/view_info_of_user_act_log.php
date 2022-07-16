   <div class="modal fade" id="view-apt<?php echo $fetch['id']; ?>" tabindex="-1" aria-labelledby="view-apt" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered modal-md">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title"><?php if (($fetch['id']) <= 9) {
                                                echo 'LOG-00000', $fetch['id'];
                                            } elseif (($fetch['id']) <= 99) {
                                                echo 'LOG-0000', $fetch['id'];
                                            } elseif (($fetch['id']) <= 999) {
                                                echo 'LOG-000', $fetch['id'];
                                            } elseif (($fetch['id']) <= 999) {
                                                echo 'LOG-00', $fetch['id'];
                                            } elseif (($fetch['id']) <= 999) {
                                                echo 'LOG-0', $fetch['id'];
                                            } else {
                                                echo 'LOG-', $fetch['id'];
                                            }  ?></h5>
                   <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
               </div>
               <div class="modal-body ml-5 mr-5 mb-3 mt-3">
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right"> Log ID</div>
                       </div>
                       <div class="col-7">
                           <?php if (($fetch['id']) <= 9) {
                                echo 'LOG-00000', $fetch['id'];
                            } elseif (($fetch['id']) <= 99) {
                                echo 'LOG-0000', $fetch['id'];
                            } elseif (($fetch['id']) <= 999) {
                                echo 'LOG-000', $fetch['id'];
                            } elseif (($fetch['id']) <= 999) {
                                echo 'LOG-00', $fetch['id'];
                            } elseif (($fetch['id']) <= 999) {
                                echo 'LOG-0', $fetch['id'];
                            } else {
                                echo 'LOG-', $fetch['id'];
                            }  ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right"> IP Address</div>
                       </div>
                       <div class="col-7">
                           <?php echo htmlspecialchars($fetch['ip_address']) ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right">Employee Name</div>
                       </div>
                       <div class="col-7">
                           <?php echo htmlspecialchars($fetch['user_fname']), ' ', htmlspecialchars($fetch['user_lname']) ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right ">Activity</div>
                       </div>
                       <div class="col-7">
                           <?php echo htmlspecialchars($fetch['user_activity']) ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right">Details</div>
                       </div>
                       <div class="col-7">
                           <?php echo htmlspecialchars($fetch['details']) ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right"> Date</div>
                       </div>
                       <div class="col-7">
                           <?php $dt = $fetch['date'];
                            $date = new DateTime($dt);
                            echo $date->format('m-d-Y'); ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right">Time</div>
                       </div>
                       <div class="col-7">
                           <?php $tm = $fetch['time'];
                            $time = new DateTime($tm);
                            echo $time->format('h:i:s a'); ?>
                       </div>
                   </div>

               </div>
           </div>

       </div>
   </div>