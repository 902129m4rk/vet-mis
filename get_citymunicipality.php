<?php
require_once("includes/config.php");
if (!empty($_POST["prov_id"])) {
    $sql = "SELECT *
    FROM city_municipality 
    WHERE province_id='" . $_POST["prov_id"] . "'
    ORDER BY citymunicipality_name ASC
    ;";

    $query = mysqli_query($conn, $sql);

?>

    <option value='' disabled selected hidden>Select City / Municipality</option>
    <?php

    while ($row = mysqli_fetch_array($query)) {
        $selected = '';
        if (!empty($_POST['select_city']) and $_POST['select_city'] == $row['id']) {
            $selected = ' selected="selected"';  // select
        }
        echo '<option value="' . $row['id'] . '"' . $selected . '>' . $row['citymunicipality_name'] . '</option>';

    ?>
<?php
    }
} else {

    include_once '404.php';
}
?>