<?php
require_once("includes/config.php");
if (!empty($_POST["patient_id"])) {
    // $query = mysqli_query($conn, "SELECT * FROM patient WHERE species = '" . $_POST["patient_id"] . "'");

    $sql = "SELECT p.id, p.name
    FROM pet AS p
    INNER JOIN pet_owner AS po
    ON p.id=po.pet_id
    INNER JOIN owner AS o
    ON po.owner_id=o.id
    WHERE vitality_status= 'Alive' AND o.id='" . $_POST["patient_id"] . "'";

    $query = mysqli_query($conn, $sql);


?>
    <option value='' disabled selected hidden>Select Pet</option>
    <?php

    while ($row = mysqli_fetch_array($query)) {
        $selected = '';
        if (!empty($_POST['select_owner']) and $_POST['select_owner'] == $row['id']) {
            $selected = ' selected="selected"';  // select
        }
        echo '<option value="' . $row['id'] . '"' . $selected . '>' . $row['name'] . '</option>';

    ?>
        <!-- <option value="<?php echo $row["name"]; ?>"><?php echo $row["name"]; ?></option> -->
<?php
    }
} else {

    include_once '404.php';
}
?>