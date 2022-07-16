   <div class="modal fade" id="view-apt<?php echo $fetch['id']; ?>" tabindex="-1" aria-labelledby="view-apt" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered modal-md">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title"><?php if (($fetch['id']) <= 9) {
                                                echo 'APT-000', htmlspecialchars($fetch['id']);
                                            } elseif (($fetch['id']) <= 99) {
                                                echo 'APT-00', htmlspecialchars($fetch['id']);
                                            } elseif (($fetch['id']) <= 999) {
                                                echo 'APT-0', htmlspecialchars($fetch['id']);
                                            } else {
                                                echo 'APT-', htmlspecialchars($fetch['id']);
                                            }  ?> </h5>
                   <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
               </div>
               <div class="modal-body ml-5 mr-5 mb-3 mt-3">
                   <div class="row mb-2 ">
                       <div class="col-6">
                           <div class="text-secondary mb-2 text-right"> Appointment ID</div>
                       </div>
                       <div class="col-6">
                           <!-- <?php echo htmlspecialchars($fetch['id']) ?> -->
                           <?php if (($fetch['id']) <= 9) {
                                echo 'APT-000', htmlspecialchars($fetch['id']);
                            } elseif (($fetch['id']) <= 99) {
                                echo 'APT-00', htmlspecialchars($fetch['id']);
                            } elseif (($fetch['id']) <= 999) {
                                echo 'APT-0', htmlspecialchars($fetch['id']);
                            } else {
                                echo 'APT-', htmlspecialchars($fetch['id']);
                            }  ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-6">
                           <div class="text-secondary mb-2 text-right"> Pet Name </div>
                       </div>
                       <div class="col-6">
                           <?php echo htmlspecialchars($fetch['name']) ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-6">
                           <div class="text-secondary mb-2 text-right">Pet Owner Name </div>
                       </div>
                       <div class="col-6">
                           <?php echo htmlspecialchars($fetch['fname']), ' ', htmlspecialchars($fetch['lname']) ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-6">
                           <div class="text-secondary mb-2 text-right"> Service </div>
                       </div>
                       <div class="col-6">
                           <?php echo htmlspecialchars($fetch['service']) ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-6">
                           <div class="text-secondary mb-2 text-right"> Date </div>
                       </div>
                       <div class="col-6">
                           <?php
                            $source = $fetch['date'];
                            $date = new DateTime($source);
                            // echo $date->format('m-d-Y'); // 31-07-2012
                            echo $date->format('F d\, Y');
                            ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-6">
                           <div class="text-secondary mb-2 text-right">Time </div>
                       </div>
                       <div class="col-6">
                           <?php
                            $source =  htmlspecialchars($fetch['time']);
                            $date = new DateTime($source);
                            echo $date->format('h:i a'); // 31-07-2012
                            ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-6">
                           <div class="text-secondary mb-2 text-right"> Appointment Status </div>
                       </div>
                       <div class="col-6 <?php if ($fetch['status'] == 'Scheduled') {
                                                echo "text-primary";
                                            } elseif ($fetch['status'] == 'Canceled') {
                                                echo "text-danger";
                                            } elseif ($fetch['status'] == 'Completed') {
                                                echo "text-success";
                                            } elseif ($fetch['status'] == 'No Show') {
                                                echo "text-dark";
                                            } ?>">
                           <?php echo htmlspecialchars($fetch['status']) ?>
                       </div>
                   </div>
                   <?php if (isset($_SESSION["loggedin"]) && ($_SESSION["utvet"])) {
                    ?>
                   <?php } else { ?>
                       <div class="row mb-2 ">
                           <div class="col-6">
                               <div class="text-secondary mb-2 text-right"> Assigned Veterinarian </div>
                           </div>
                           <div class="col-6">
                               <?php echo $fetch['user_fname'], ' ', $fetch['user_lname']; ?>
                           </div>
                       </div>
                   <?php } ?>
               </div>
           </div>

       </div>
   </div>