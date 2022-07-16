   <!--VIEW CLIENT Modal -->
   <div class="modal fade" id="view-info<?php echo $fetch['inventory_id']; ?>" tabindex="-1" aria-labelledby="view-info" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title"><?php if (($fetch['inventory_id']) <= 9) {
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
               <div class="modal-body ml-5 mr-5 mb-3 mt-3">
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right"> Inventory ID</div>
                       </div>
                       <div class="col-7">
                           <?php if (($fetch['inventory_id']) <= 9) {
                                // echo 'PTNT-0', $fetch['id'];
                                echo 'PRDCT-000', htmlspecialchars($fetch['inventory_id']);
                            } elseif (($fetch['inventory_id']) <= 99) {
                                echo 'PRDCT-00', htmlspecialchars($fetch['inventory_id']);
                            } elseif (($fetch['inventory_id']) <= 999) {
                                echo 'PRDCT-0', htmlspecialchars($fetch['inventory_id']);
                            } else {
                                echo 'PRDCT-', htmlspecialchars($fetch['inventory_id']);
                            }  ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right"> Product Category</div>
                       </div>
                       <div class="col-7">
                           <?php echo htmlspecialchars($fetch['product_category']) ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right"> Product Name</div>
                       </div>
                       <div class="col-7">
                           <?php echo htmlspecialchars($fetch['product_name']) ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right"> Species</div>
                       </div>
                       <div class="col-7">
                           <?php if (!empty($fetch['species2'])) {
                                echo htmlspecialchars($fetch['species1']), ' & ', htmlspecialchars($fetch['species2']);
                            } else {
                                echo $fetch['species1'];
                            } ?>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right"> Quantity on Hand</div>
                       </div>
                       <div class="col-7">
                           <div class="<?php if ($fetch['quantity_on_hand']  <= '10') {
                                            echo "text-danger";
                                        } elseif ($fetch['quantity_on_hand'] <= '30') {
                                            echo "text-warning";
                                        } else {
                                            echo "text-primary";
                                        } ?>">
                               <?php echo htmlspecialchars($fetch['quantity_on_hand']) ?>
                           </div>
                       </div>
                   </div>
                   <div class="row mb-2 ">
                       <div class="col-5">
                           <div class="text-secondary mb-2 text-right"> Price</div>
                       </div>
                       <div class="col-7">
                           <?php echo '₱ ', number_format($fetch['price'], 2); ?>
                       </div>
                   </div>
                   <?php if (!empty($fetch['description'])) {
                    ?>
                       <div class="row mb-2 ">
                           <div class="col-5">
                               <div class="text-secondary mb-2 text-right"> Product Description</div>
                           </div>
                           <div class="col-7">
                               <?php echo htmlspecialchars($fetch['description']) ?>
                           </div>
                       </div>
                   <?php }
                    ?>


               </div>
           </div>

       </div>
   </div>