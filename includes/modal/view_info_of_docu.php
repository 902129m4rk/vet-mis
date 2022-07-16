   <!--VIEW CLIENT Modal -->
   <div class="modal fade" id="view-info-docu<?php echo $row['medical_records_id']; ?>" tabindex="-1" aria-labelledby="view-info-docu" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered modal-md">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">View Information </h5>
                   <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
               </div>
               <div class="modal-body ml-5 mr-5 mb-3 mt-3">

                   <!-- IF NOT EMPTY YUNG FILE NAME -->
                   <?php if (!empty($row['file_name'])) { ?>
                       <div class="row mb-2 ">
                           <div class="col-4">
                               <div class="text-secondary mb-2 text-right"> File Name</div>
                           </div>
                           <div class="col-8">
                               <?php echo htmlspecialchars($row['file_name']) ?>
                           </div>
                       </div>
                       <?php if (!empty($row['description'])) {  ?>
                           <div class="row mb-2 ">
                               <div class="col-4">
                                   <div class="text-secondary mb-2 text-right"> Description</div>
                               </div>
                               <div class="col-8">
                                   <?php echo htmlspecialchars($row['description']) ?>
                               </div>
                           </div>
                       <?php } else {
                        } ?>
                       <div class="row mb-2 ">
                           <div class="col-4">
                               <div class="text-secondary mb-2 text-right"> Uploaded on</div>
                           </div>
                           <div class="col-8">
                               <?php
                                $source = htmlspecialchars($row['date_created']);
                                $date = new DateTime($source);
                                echo $date->format('F d\, Y'); // 31-07-2012
                                ?>

                           </div>
                       </div>
                       <div class="row mb-2 ">
                           <div class="col-4">
                               <div class="text-secondary mb-2 text-right">Provider</div>
                           </div>
                           <div class="col-8">
                               <?php echo htmlspecialchars($row['user_fname']), ' ', htmlspecialchars($row['user_lname']) ?>
                           </div>
                       </div>
                   <?php } else { ?>
                       <?php if (!empty($row['description'])) {  ?>
                           <div class="row mb-2 ">
                               <div class="col-4">
                                   <div class="text-secondary mb-2 text-right"> Description</div>
                               </div>
                               <div class="col-8">
                                   <?php echo htmlspecialchars($row['description']) ?>
                               </div>
                           </div>
                       <?php } else {
                        } ?>
                       <div class="row mb-2 ">
                           <div class="col-4">
                               <div class="text-secondary mb-2 text-right"> Created on</div>
                           </div>
                           <div class="col-8">
                               <?php
                                $source = htmlspecialchars($row['date_created']);
                                $date = new DateTime($source);
                                echo $date->format('F d\, Y'); // 31-07-2012
                                ?>

                           </div>
                       </div>
                       <div class="row mb-2 ">
                           <div class="col-4">
                               <div class="text-secondary mb-2 text-right">Provider</div>
                           </div>
                           <div class="col-8">
                               <?php echo htmlspecialchars($row['user_fname']), ' ', htmlspecialchars($row['user_lname']) ?>
                           </div>
                       </div>
                   <?php } ?>


               </div>
           </div>

       </div>
   </div>