   <div class="modal fade" id="view-user<?php echo $fetch['empid']; ?>" tabindex="-1" aria-labelledby="view-user" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered modal-md">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title"> <?php if (($fetch['empid']) <= 9) {
                                                echo 'EMP-000', $fetch['empid'];
                                            } elseif (($fetch['empid']) <= 99) {
                                                echo 'EMP-00', $fetch['empid'];
                                            } elseif (($fetch['empid']) <= 999) {
                                                echo 'EMP-0', $fetch['empid'];
                                            } else {
                                                echo 'APT-', $fetch['empid'];
                                            }  ?> </h5>
                   <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
               </div>
               <div class="modal-body ml-5 mr-5 mb-3 mt-3">
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right"> Employee ID</div>
                       </div>
                       <div class="col-7">
                           <?php if (($fetch['empid']) <= 9) {
                                // echo 'PTNT-0', $fetch['id'];
                                echo 'EMP-000', $fetch['empid'];
                            } elseif (($fetch['empid']) <= 99) {
                                echo 'EMP-00', $fetch['empid'];
                            } elseif (($fetch['empid']) <= 999) {
                                echo 'EMP-0', $fetch['empid'];
                            } else {
                                echo 'APT-', $fetch['empid'];
                            }  ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right"> Name</div>
                       </div>
                       <div class="col-7">
                           <?php echo htmlspecialchars($fetch['user_fname']), ' ',  htmlspecialchars($fetch['user_mname']), ' ', htmlspecialchars($fetch['user_lname']) ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right"> Gender</div>
                       </div>
                       <div class="col-7">
                           <?php echo htmlspecialchars($fetch['gender']) ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right">Date of Birth</div>
                       </div>
                       <div class="col-7">
                           <?php
                            $source = $fetch['bday'];
                            $date = new DateTime($source);
                            echo $date->format('F d\, Y');

                            ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right">Age</div>
                       </div>
                       <div class="col-7">
                           <?php
                            $dateofbirth = $fetch['bday'];
                            $today = date("Y-m-d");
                            $diff = date_diff(date_create($dateofbirth), date_create($today));
                            echo  $diff->format('%y');

                            $age = $diff->format('%y');
                            if ($age > 1) {
                                echo ' years old';
                            } else {
                                echo ' year old';
                            }
                            ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right"> Address</div>
                       </div>
                       <div class="col-7">
                           <?php echo $fetch['citymunicipality_name'], ', ', $fetch['province_name'] ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right"> Mobile Number</div>
                       </div>
                       <div class="col-7">
                           <?php echo htmlspecialchars($fetch['contact_no']) ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right"> User Type</div>
                       </div>
                       <div class="col-7">
                           <?php echo htmlspecialchars($fetch['user_type']) ?>
                       </div>
                   </div>
                   <!-- <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right"> Created Date</div>
                       </div>
                       <div class="col-7">
                           <?php
                            $source = htmlspecialchars($fetch['created_date']);
                            $date = new DateTime($source);
                            echo $date->format('m-d-Y h:i:s a'); // 31-07-2012
                            ?>
                       </div>
                   </div> -->
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right"> Employee Status</div>
                       </div>
                       <div class="col-7 <?php if ($fetch['user_status'] == 'Active') {
                                                echo "text-primary";
                                            } elseif ($fetch['user_status'] == 'Inactive') {
                                                echo "text-danger";
                                            } ?>">
                           <?php echo htmlspecialchars($fetch['user_status']) ?>
                       </div>
                   </div>

               </div>
           </div>

       </div>
   </div>