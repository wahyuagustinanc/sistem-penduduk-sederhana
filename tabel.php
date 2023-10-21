<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JMC-Test</title>
    <!-- CSS Bootstrap -->
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <!-- CSS Icon Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Print -->
    <style>
    @media print {

        .select,
        .btn,
        a#debug-icon-link {
            display: none;
        }
    }
    </style>
</head>

<body>
    <center>
        <h1>JMC-Test</h1>
        <h2>Sistem Pencatatan Data Penduduk</h2>
    </center>

    <div class="row mt-2">
        <form action="" method="get">
            <div class="row mt-2">
                <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                    <a href="tambah.php" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> Tambah Data</a>
                </div>
                <!-- Filtering data -->
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
                <div class="col-lg-1 col-md-3 col-sm-3 col-3">
                    <input type="submit" value="Filter" name="filter" class="btn btn-secondary">
                </div>

                <div class="col-lg-3 col-md-4 col-sm-4 col-4">
                    <div class="input-group flex-nowrap">
                        <input type="text" name="cari" value="<?= isset($cari) ? $cari : "" ?>" class="form-control"
                            placeholder="Masukkan Nama/NIK" id="">
                        <button class=" input-group-text btn btn-outline-success" type="submit"
                            name="proses">Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

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
            extract($_GET);

            // Halaman saat ini
            $halaman = isset($_GET['halaman']) ? $_GET['halaman'] : 1;
            $batas = 10; // Jumlah data per halaman

            // Hitung total jumlah data
            $query = "SELECT COUNT(*) as total FROM penduduk";
            $result = query($query);
            $row = mysqli_fetch_assoc($result);
            $total_records = $row['total'];

            // Hitung jumlah halaman
            $total_halaman = ceil($total_records / $batas);

            // Query untuk mengambil data pada halaman saat ini
            $start_from = ($halaman - 1) * $batas;

            $previous = $halaman - 1;
            $next = $halaman + 1;

            // search
            $where = "";
            $limit = "LIMIT $start_from, $batas";
            $join = "INNER JOIN kabupaten ON penduduk.id_kabupaten=kabupaten.id_kab
                     INNER JOIN provinsi ON penduduk.id_provinsi=provinsi.id_prov";
            if (isset($proses)) {
                $where = "WHERE (nama LIKE '%$cari%' OR nik LIKE '%$cari%')";
                $penduduk = get_all_data($table = "penduduk", $join, $where, $order = "ORDER BY id_penduduk DESC", $limit);
            } elseif (isset($filter)) {
                $id_prov = $_GET['id_provinsi'];
                $id_kab = $_GET['id_kabupaten'];
                $where = "WHERE (id_provinsi = '$id_prov' AND id_kabupaten = '$id_kab')";
                $penduduk = get_all_data($table = "penduduk", $join, $where, $order = "ORDER BY id_penduduk DESC", $limit);
            }



            // elseif (isset($filter)) {
            //     $id_prov = $_GET['id_provinsi'];
            //     $id_kab = $_GET['id_kabupaten'];
            //     $where = "WHERE (id_provinsi = '$id_prov' AND id_kabupaten = '$id_kab')";
            //     $penduduk = get_all_data($table = "penduduk", $join, $where, $order = "ORDER BY id_penduduk DESC", $limit);
            // }
            // elseif (isset($_GET['id_provinsi'])) {
            //     $id_prov = $_GET['id_provinsi'];
            //     $where = "WHERE (id_provinsi = '$id_prov')";
            //     $penduduk = get_all_data($table = "penduduk", $join, $where, $order = "ORDER BY id_penduduk DESC", $limit);
            // } elseif (isset($_GET['id_provinsi']) && isset($_GET['id_kabupaten'])) {
            //     $id_prov = $_GET['id_provinsi'];
            //     $id_kab = $_GET['id_kabupaten'];
            //     $where = "WHERE (id_provinsi = '$id_prov' AND id_kabupaten = '$id_kab')";
            //     $penduduk = get_all_data($table = "penduduk", $join, $where, $order = "ORDER BY id_penduduk DESC", $limit);
            // } 
            else {
                $penduduk = get_all_data($table = "penduduk", $join, $where, $order = "ORDER BY id_penduduk DESC", $limit);
            }
            $no_post = 0;
            foreach ($penduduk as $item) {
                $no_post++;
            ?>
            <tr class="">
                <td scope="row" width="3%"><?= $no_post ?></td>
                <td width="10%">
                    <a href="<?= "edit.php?id_penduduk= " . $item['id_penduduk'] ?>"><button type="button"
                            class="btn btn-warning btn-sm">Edit</button></a>
                    <form action="hapus.php" method="post" style="display: inline;">
                        <input type="hidden" name="id_penduduk" value="<?= $item['id_penduduk']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Apakah anda yakin ingin menghapus data?')">
                            Hapus</button>
                    </form>
                </td>
                <td width="18%"><?= $item['nama'] ?></td>
                <td width="17%"><?= $item['nik'] ?></td>
                <td width="10%"><?= date('d M Y', strtotime($item['tgl_lahir'])) ?></td>
                <td width="17%">
                    <?= strtoupper($item['alamat']) . ", " . $item['kabupaten'] . ", " . $item['provinsi'] ?>
                </td>
                <td width="10%"><?= $item['jenis_kelamin'] ?></td>
                <td width="15%"><?= date('d-m-Y h:m:s', strtotime($item['timestamp'])) ?></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <!-- Button cetak -->
    <a href="" class="btn btn-success btn-sm" onclick="window.print()"><i class="bi bi-download"></i>
        Cetak</a>


    <!-- Tampilkan navigasi paging -->
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" <?php if ($halaman > 1) {
                                            echo "href='?halaman=$previous'";
                                        } ?>>Previous</a>
            </li>
            <?php
            for ($x = 1; $x <= $total_halaman; $x++) {
            ?>
            <li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
            <?php
            }
            ?>
            <li class="page-item">
                <a class="page-link" <?php if ($halaman < $total_halaman) {
                                            echo "href='?halaman=$next'";
                                        } ?>>Next</a>
            </li>
        </ul>
    </nav>

    <!-- JS -->
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <!-- JS Dropdown Kabupaten -->
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/option.js"></script>
</body>

</html>