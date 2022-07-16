<!-- Add Pet Modal -->
<div class="modal fade" id="add_pet<?php echo $ownerinfo['id'] ?>" aria-hidden="true" tabindex="-1" aria-labelledby="update_patient">
    <div class="modal-dialog modal-dialog-centered">
        <div class=" modal-content bg-light">
            <form action="includes/modal/add_pet_query.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Add
                        <?php echo htmlspecialchars($ownerinfo['fname']),
                        "'s Pet"; ?>
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
                    <div class="form-group">
                        <span> Name </span> <span class="text-danger"> * </span>
                        <input type="hidden" name="id" value="<?php echo $ownerinfo['id'] ?>">
                        <input class="form-control" type="text" placeholder="Enter Pet Name" name="pet_name" value="<?php if (isset($_POST['pet_name'])) {
                                                                                                                        echo $_POST['pet_name'];
                                                                                                                    } ?>" required="required">
                    </div>
                    <div class="form-group mt-2">
                        <label for="pet_gender">Gender <span class="text-danger"> * </span> </label>
                        <select class="form-control placeholder" name="pet_gender">
                            <option value="">Select Gender </option>
                            <option value="Male" <?php if (isset($petgender) && $petgender == "Male") echo "selected" ?>>Male </option>
                            <option value="Female" <?php if (isset($petgender) && $petgender == "Female") echo "selected" ?>>Female</option>
                            <option value="Neutral" <?php if (isset($petgender) && $petgender == "Neutral") echo "selected" ?>>Neutral</option>
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label for="pet_bday"><span> Birthdate</span> <span class="text-danger"> * </span> </label>
                        <input class="form-control" type="date" placeholder="Select Birthdate" name="pet_bday" value="<?php if (isset($_POST['pet_bday'])) {
                                                                                                                            echo $_POST['pet_bday'];
                                                                                                                        } ?>" required="required">
                    </div>
                    <div class="form-group mt-2">
                        <label for="pet_weight">
                            <span> Weight (kg)</span> <span class="text-danger"> * </span>
                        </label>
                        <input class="form-control" type="number" min="0" step="0.01" placeholder="Enter Pet Weight" name="pet_weight" value="<?php if (isset($_POST['pet_weight'])) {
                                                                                                                                                    echo $_POST['pet_weight'];
                                                                                                                                                } ?>" required="required">
                    </div>
                    <div class="form-group mt-2">
                        <label for="pet_species">Species <span class="text-danger"> * </span> </label>
                        <select class="form-control placeholder" name="pet_species" id="species" required="required">
                            <option value="">Select Species</option>
                            <?php $query = mysqli_query($conn, "SELECT * FROM species WHERE status='Active' ORDER BY name asc");
                            while ($row = mysqli_fetch_array($query)) {
                                // Remain selected value
                                $selected = '';
                                if (!empty($_POST['pet_species']) and $_POST['pet_species'] == $row['name']) {
                                    $selected = ' selected="selected"';  // select
                                }
                                echo '<option value="' . $row['name'] . '"' . $selected . '>' . $row['name'] . '</option>';
                            ?>
                                <!-- <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option> -->

                            <?php
                            }
                            ?>
                        </select>

                    </div>
                    <div class="form-group mt-2">
                        <span> Breed </span>
                        <input class="form-control" type="text" placeholder="Enter Pet Breed" name="pet_breed" value="<?php if (isset($_POST['pet_breed'])) {
                                                                                                                            echo $_POST['pet_breed'];
                                                                                                                        } ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal"> Close</button>
                    <button name="add" class="btn btn-primary"> Add Pet</button>
                </div>
            </form>
        </div>
    </div>
</div>