<?php

function koneksi()
{
  $conn = mysqli_connect('localhost', 'root', '', 'data_siswa_riqqi');
  return $conn;
}

function query($query)
{
  $conn = koneksi();

  // query isi tabel
  $result = mysqli_query($conn, $query);

  // ubah data ke array
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}


// // tambah data
if (isset($_POST['Tambah'])) {
  $conn = koneksi();
  $nim = htmlspecialchars($_POST['nim']);
  $nama = htmlspecialchars($_POST['nama']);
  $tempat_lahir = htmlspecialchars($_POST['tempat_lahir']);
  $tgl_lahir = htmlspecialchars($_POST['tgl_lahir']);
  $alamat = htmlspecialchars($_POST['alamat']);
  $kelas = htmlspecialchars($_POST['kelas']);
  $progdi = htmlspecialchars($_POST['progdi']);
  $no_hp = htmlspecialchars($_POST['no_hp']);
  $gambar = htmlspecialchars($_FILES['gambar']['name']);

  // cek NIM
  $cekdata = "SELECT nim FROM mahasiswa WHERE nim = '$nim'";
  $ada = mysqli_query($conn, $cekdata) or die();
  if (mysqli_num_rows($ada) > 0) {
    die('NIM yang diinputkan sudah terdaftar');
  } else {
    if (!empty($_FILES['gambar']['tmp_name'])) {
      $nmfolder = 'foto/';
      $jenis_gambar = $_FILES['gambar']['type'];
      if ($jenis_gambar == 'image/jpeg' || $jenis_gambar == 'image/jpg' || $jenis_gambar == 'image/gif' || $jenis_gambar == 'image/png') {

        $foto = $nmfolder . basename($_FILES['gambar']['name']);
        // var_dump($foto);
        // die();
        if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $foto)) {
          die('gambar gagal dikirim bestie...');
        }
      } else {
        die('jenis gambar yang anda kirim salah, harus jpg, jpeg, gif, png');
      }
    }

    $query = "INSERT INTO mahasiswa VALUES ('$nim','$nama','$tempat_lahir','$tgl_lahir','$alamat','$kelas','$progdi','$no_hp','$gambar')";

    mysqli_query($conn, $query);
    echo mysqli_error($conn);
  }
}

// hapus data
function hapus($id)
{
  $conn = koneksi();
  mysqli_query($conn, "DELETE FROM mahasiswa WHERE nim = '$id'") or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}
if (isset($_GET['h'])) {
  $id = $_GET["h"];

  if (hapus($id) > 0) {
    echo "<script>
            alert('data berhasil dihapus');
            document.location.href = 'mahasiswa.php';
          </script>";
  } else {
    echo "data gagal dihapus";
  }
}

// // ubah data
function ubah($data)
{
  $conn = koneksi();

  $id = $data['u'];

  $nim = $_POST['nim'];
  $nama = $_POST['nama'];
  $tempat_lahir = $_POST['tempat_lahir'];
  $tgl_lahir = $_POST['tgl_lahir'];
  $alamat = $_POST['alamat'];
  $kelas = $_POST['kelas'];
  $progdi = $_POST['progdi'];
  $no_hp = $_POST['no_hp'];


  $query = "UPDATE mahasiswa SET
            nama = '$nama',
            tempat_lahir = '$tempat_lahir',
            tgl_lahir = '$tgl_lahir',
            alamat = '$alamat',
            kelas = '$kelas',
            progdi = '$progdi',
            no_hp = '$no_hp'
            WHERE nim = '$id'";

  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

$aksi = "Tambah";
$nim = null;
$nama = null;
$tempat_lahir = null;
$tgl_lahir = null;
$alamat = null;
$kelas = null;
$progdi = null;
$no_hp = null;
$gambar = "file";
$a = null;

if (isset($_GET['u'])) {

  $id = $_GET['u'];
  $aksi = "Ubah";
  $u = query("SELECT * FROM mahasiswa
              WHERE nim = '$id' ;");
  $nim = $u['0']['nim'];
  $nama = $u['0']['nama'];
  $tempat_lahir = $u['0']['tempat_lahir'];
  $tgl_lahir = $u['0']['tgl_lahir'];
  $alamat = $u['0']['alamat'];
  $kelas = $u['0']['kelas'];
  $progdi = $u['0']['progdi'];
  $no_hp = $u['0']['no_hp'];
  $gambar = "hidden";

  var_dump($_POST);
  // die();
  $a = "autofocus";

  if (isset($_POST['Ubah'])) {
    if (ubah($_POST) > 0) {
      echo "<script>
          alert('data berhasil diubah');
          document.location.href = 'mahasiswa.php';
        </script>";
    } else {
      echo "data gagal diubah";
    }
  }
}


// query
$mahasiswa = query("SELECT * FROM mahasiswa");
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mahasiswa</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <h1>Mahasiswa</h1>
  <br>
  <!-- input -->
  <div class="input">
    <form action="" method="POST" enctype="multipart/form-data">
      <fieldset>
        <legend>Input Data Mahasiswa</legend>
        <table>
          <tr>
            <td>
              <label for="nim">Nim</label>
            </td>
            <td>:</td>
            <td>
              <input type="text" name="nim" id="nim" required <?= $a; ?> value="<?= $nim; ?>">
            </td>
          </tr>
          <tr>
            <td>
              <label for="nama">Nama</label>
            </td>
            <td>:</td>
            <td>
              <input type="text" name="nama" id="nama" required value="<?= $nama; ?>">
            </td>
          </tr>
          <tr>
            <td>
              <label for="tempat_lahir">TTL</label>
            </td>
            <td>:</td>
            <td>
              <input type="text" name="tempat_lahir" id="tempat_lahir" required value="<?= $tempat_lahir; ?>">
              <input type="date" name="tgl_lahir" id="tgl_lahir" required value="<?= $tgl_lahir; ?>">
            </td>
          </tr>
          <tr>
            <td>
              <label for="kelas">Alamat</label>
            </td>
            <td>:</td>
            <td>
              <input type="text" name="alamat" id="alamat" required value="<?= $alamat; ?>">
            </td>
          </tr>
          <tr>
            <td>
              <label for="kelas">Kelas</label>
            </td>
            <td>:</td>
            <td>
              <input type="text" name="kelas" id="kelas" required value="<?= $kelas; ?>">
            </td>
          </tr>
          <tr>
            <td>
              <label for="progdi">Progdi</label>
            </td>
            <td>:</td>
            <td>
              <input type="text" name="progdi" id="progdi" required value="<?= $progdi; ?>">
            </td>
          </tr>
          <tr>
            <td>
              <label for="no_hp">No HP</label>
            </td>
            <td>:</td>
            <td>
              <input type="text" name="no_hp" id="no_hp" required value="<?= $no_hp; ?>">
            </td>
          </tr>
          <tr>
            <td>
              <label for="gambar">Upload Gambar</label>
            </td>
            <td>:</td>
            <td>
              <input type="<?= $gambar; ?>" name="gambar" id="gambar" required>
            </td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td>
              <button type="reset">Batal</button>
              <button type="submit" name="<?= $aksi ?>"><?= $aksi ?> Data</button>
            </td>
          </tr>
        </table>
      </fieldset>
    </form>
  </div>
  <br>

  <!-- tabel -->
  <div class="tabel">
    <table border="1" cellspacing=0 cellpadding=3>
      <thead>
        <th>NO</th>
        <th>NIM</th>
        <th>NAMA</th>
        <th>TTL</th>
        <th>ALAMAT</th>
        <th>KELAS</th>
        <th>PROGDI</th>
        <th>NO HP</th>
        <th>FOTO</th>
        <th>AKSI</th>
      </thead>
      <tbody>

        <?php if ($mahasiswa == null) : ?>
          <tr class="kosong">
            <td colspan="8"><em> data mahasiswa tidak ditemukan</em></td>
          </tr>
        <?php endif ?>

        <?php
        $no = 1;
        foreach ($mahasiswa as $m) : ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= $m['nim']; ?></td>
            <td><?= $m['nama']; ?></td>
            <td><?= $m['tempat_lahir']; ?>, <?= $m['tgl_lahir']; ?></td>
            <td><?= $m['alamat']; ?></td>
            <td><?= $m['kelas']; ?></td>
            <td><?= $m['progdi']; ?></td>
            <td><?= $m['no_hp']; ?></td>
            <td>
              <img src="foto/<?= $m['foto']; ?>" alt="foto diri" width='100'>
            </td>
            <td>
              <a href="?u=<?= $m['nim']; ?>">Ubah</a> |
              <a href="?h=<?= $m['nim']; ?>">Hapus</a>
            </td>
          </tr>
        <?php endforeach ?>

      </tbody>
    </table>
  </div>

</body>


</html>