<?php
require_once 'config/fungsi-crud.php';

if (isset($_POST)) {
    extract($_POST);
    hapus($table = "penduduk", $where = "id_penduduk = '$id_penduduk'");
    echo "<script>location='index.php'</script>";
}