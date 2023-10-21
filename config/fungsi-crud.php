<?php

function koneksi()
{
    $hostName = "localhost";
    $userName = "root";
    $password = "";
    $dbName = "jmc_test";
    $port = "3306";
    return mysqli_connect($hostName, $userName, $password, $dbName, $port);
}

function query($sql)
{
    return mysqli_query(koneksi(), $sql);
}

function get_all_data($table, $join, $where = "", $order = "", $limit = "")
{
    $data = [];
    $sql = "SELECT * FROM $table $join $where $order $limit";
    $query = query($sql);
    while ($list_data = mysqli_fetch_assoc($query)) {
        $data[] = $list_data;
    }

    return $data;
}

function get_provinsi()
{
    $sql = "SELECT * FROM provinsi ORDER BY provinsi";
    $query = query($sql);
    while ($row = mysqli_fetch_assoc($query)) {
        echo "<option value='" . $row['id_prov'] . "'>" . $row['provinsi'] . "</option>";
    }
}

// function get_alamat()
// {
//     $sql = "SELECT * FROM penduduk 
//             INNER JOIN kabupaten ON penduduk.id_kabupaten=kabupaten.id_kab
//             INNER JOIN provinsi ON penduduk.id_provinsi=provinsi.id_prov";
//     $query = query($sql);
//     return $query;
// }

function insert($table, array $data)
{

    $field = "";
    $isi = "";
    foreach ($data as $key => $value) {
        $field .= ",$key";
        $isi .= ",'$value'";
    }
    $field_ = substr($field, 1);
    $isi_ = substr($isi, 1);
    $sql = "INSERT INTO $table ($field_) VALUES ($isi_)";
    return query($sql);
}

function update($table, array $data, $where)
{

    // UPDATE penduduk SET nama='ayu',nik = '3306084808010001' WHERE $where
    $set = "";
    foreach ($data as $key => $value) {
        $set .= ",$key = '$value'";
    }

    $set_  = substr($set, 1);

    $sql = "UPDATE $table SET $set_ WHERE $where";
    $query = query($sql);
    return $query;
}

function hapus($table, $where)
{
    //DELETE FROM $table=tb_mahasiswa WHERE $where=> id='6'
    $sql = "DELETE FROM $table WHERE $where";
    return query($sql);
}