<?php
session_start();
require_once 'config/fungsi-crud.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data</title>
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css"> -->
    <!-- CSS Icon Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <?php
    extract($_POST);

    if (isset($simpan)) {
        $data_post = [
            'nama' => $nama,
            'nik' => $nik,
            'jenis_kelamin' => $jenis_kelamin,
            'tgl_lahir' => $tgl_lahir,
            'alamat' => $alamat,
            'id_provinsi' => $id_provinsi,
            'id_kabupaten' => $id_kabupaten
        ];
        insert($table = "penduduk", $data_post);
        echo "<script>location='index.php'</script>";
    }
    ?>

    <h1 style="text-align: center;">Form Tambah Data</h1>
    <div class="row">
        <div class="col">
            <form action="" method="post" class="form-post" style="margin-left: 30%; margin-right: 30%;">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="text" class="form-control" name="nik" required>
                </div>
                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select" id="jenis_kelamin" required>
                        <option selected disabled hidden> </option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tgl_lahir" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" rows="2" id="alamat" name="alamat" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="id_provinsi" class="form-label">Provinsi</label>
                    <select id="id_provinsi" name="id_provinsi" class="form-select" required>
                        <option value="">Pilih Provinsi</option>
                        <?php
                        // Mengambil data provinsi
                        get_provinsi();
                        ?>
                    </select>

                    <label for="id_kabupaten" class="form-label">Kabupaten</label>
                    <select id="id_kabupaten" name="id_kabupaten" class="form-select" required>
                        <option value="">Pilih Kabupaten</option>
                    </select>
                </div>
                <div class="mb-3 text-right">
                    <a class="btn btn-danger btn-sm" href="index.php" role="button"><i class="bi bi-arrow-left"></i>
                        Kembali</a>
                    <button type="reset" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-counterclockwise"></i>
                        Reset</button>
                    <button type="submit" class="btn btn-success btn-sm" name="simpan"><i class="bi bi-check2"></i>
                        Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS Dropdown Kabupaten -->
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/option.js"></script>

</body>

</html>