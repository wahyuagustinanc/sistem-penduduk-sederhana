<?php
require_once 'config/fungsi-crud.php';
require_once 'views/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <!-- CSS Bootstrap -->
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <!-- CSS Icon Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <form action="" method="post">
        <div class="row mt-4">
            <div id="filter_prov" class="col-lg-2 col-md-4 col-sm-4 col-4">
                <select id="id_provinsi" name="id_provinsi" class="form-select">
                    <option value="">Pilih Provinsi</option>
                    <?php get_provinsi() ?>
                </select>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                <select id="id_kabupaten" name="id_kabupaten" class="form-select">
                    <option value=""></option>
                </select>
            </div>
            <div class="col-sm-3">
                <button class="btn btn-success btn" type="submit" name="laporan-transaksi">Lihat Laporan</button>
            </div>
        </div>
    </form>

    <?php
    if (isset($_POST['laporan-transaksi'])) { ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Aksi</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Jenis Kelamin</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>

            <?php
                if (isset($filter)) {
                    $id_prov = $_GET['id_provinsi'];
                    $id_kab = $_GET['id_kabupaten'];
                    $where = "WHERE (id_provinsi = '$id_prov' AND id_kabupaten = '$id_kab')";
                    $penduduk = get_all_data($table = "penduduk", $join, $where, $order = "ORDER BY id_penduduk DESC", $limit);

                    foreach ($penduduk as $item) { ?>
            <?php } ?>
            <tr>
                <td scope="row" width="3%"><?= $no_post ?></td>
                <td width="18%"><?= $item['nama'] ?></td>
                <td width="17%"><?= $item['nik'] ?></td>
                <td width="10%"><?= date('d M Y', strtotime($item['tgl_lahir'])) ?></td>
                <td width="17%">
                    <?= strtoupper($item['alamat']) . ", " . $item['kabupaten'] . ", " . $item['provinsi'] ?>
                </td>
                <td width="10%"><?= $item['jenis_kelamin'] ?></td>
                <td width="15%"><?= date('d-m-Y h:m:s', strtotime($item['timestamp'])) ?></td>
            </tr>

        </tbody>
        <tfoot>
            <?php
                    $query = "SELECT COUNT(*) as total FROM penduduk";
                    $result = query($query);
                    $row = mysqli_fetch_assoc($result);
                    $total_records = $row['total'];
                } ?>
            <tr>
                <td colspan="3"><span class="lead">Total Penduduk : <b>
                            <?= $total; ?></b> orang.</span>
                    <a target="_BLANK" href="excel/datatransaksikamar.php" class="btn btn-primary">Export Excel</a>
                </td>
            </tr>
        </tfoot>
    </table>
    <?php }
    ?>

    <!-- JS -->
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <!-- JS Dropdown Kabupaten -->
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/option.js"></script>
</body>

</html>