<?php
require_once 'config/fungsi-crud.php';

// Menampung id provinsi
$id_prov = $_POST['id_prov'];
$sql = query("SELECT * FROM kabupaten WHERE id_prov = $id_prov ORDER BY kabupaten");

echo '<option value=" ">Pilih Kabupaten</option>';
while ($row = mysqli_fetch_array($sql)) {
    echo '<option value="' . $row['id_kab'] . '">' . $row['kabupaten'] . '</option>';
}