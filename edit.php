<?php
require_once 'config/fungsi-crud.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS Icon Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    extract($_POST);
    extract($_GET);

    if (isset($id_penduduk)) {
        $sql = "SELECT * FROM penduduk WHERE id_penduduk='$id_penduduk'";
        $q = query($sql);
        $penduduk = mysqli_fetch_array($q);
    }

    //jika data ditemukan
    if (is_array($penduduk)) {
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
            update($table = "penduduk", $data_post, $where = "id_penduduk = '$id_penduduk'");
            echo "<script>location='index.php'</script>";
        }
    }
    ?>

    <h1 style="text-align: center;">Form Edit Data</h1>
    <div class="row">
        <div class="col">
            <form action="" method="post" class="form-post" style="margin-left: 30%; margin-right: 30%;">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" name="nama" required value="<?= $penduduk['nama']; ?>">
                </div>
                <div class="mb-3">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="text" class="form-control" name="nik" required value="<?= $penduduk['nik']; ?>">
                </div>
                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select" id="jenis_kelamin" required>
                        <option selected disabled hidden> </option>
                        <option value="Laki-laki" <?= ($penduduk['jenis_kelamin'] == "Laki-laki" ? "selected" : ""); ?>>
                            Laki-laki
                        </option>
                        <option value="Perempuan" <?= ($penduduk['jenis_kelamin'] == "Perempuan" ? "selected" : ""); ?>>
                            Perempuan
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tgl_lahir" required
                        value="<?= $penduduk['tgl_lahir']; ?>">
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" rows="2" id="alamat" name="alamat"
                        required><?= $penduduk['alamat']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="provinsi" class="form-label">Provinsi</label>
                    <select id="provinsi" name="provinsi" class="form-select" required>
                        <option value="">Pilih Provinsi</option>
                        <?php
                        // Mengambil data provinsi
                        get_provinsi();
                        ?>
                    </select>

                    <label for="kabupaten" class="form-label">Kabupaten</label>
                    <select id="kabupaten" name="kabupaten" class="form-select" required>
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
    <script>
    $(document).ready(function() {
        $('#provinsi').change(function() {
            var provinsi_id = $(this).val();

            $.ajax({
                type: 'POST', //method
                url: 'kabupaten.php', //action
                data: 'id_prov=' + provinsi_id, //$_POST('id_prov')
                success: function(response) {
                    $('#kabupaten').html(response);
                }
            });
        })
    });
    </script>

</body>

</html>