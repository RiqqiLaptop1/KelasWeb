<?php

function query($query)
{
  $conn = mysqli_connect('localhost', 'root', '', 'data_siswa');

  // query isi tabel
  $result = mysqli_query($conn, $query);

  // ubah data ke array
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

// query
$mahasiswa = query("SELECT * FROM mahasiswa");

// input data
if ($_POST != null) {
  var_dump($_FILES);
  $nim = htmlspecialchars($_POST['nim']);
  $nama = htmlspecialchars($_POST['nama']);
  $tempat_lahir = htmlspecialchars($_POST['tempat_lahir']);
  $tgl_lahir = htmlspecialchars($_POST['tgl_lahir']);
  $alamat = htmlspecialchars($_POST['alamat']);
  $kelas = htmlspecialchars($_POST['kelas']);
  $progdi = htmlspecialchars($_POST['progdi']);
  $no_hp = htmlspecialchars($_POST['no_hp']);
  $gambar = htmlspecialchars($_FILES['gambar']['name']);
  query("INSERT INTO mahasiswa VALUES '$nim','$nama','$tempat_lahir','$tgl_lahir','$alamat','$kelas','$progdi','$no_hp','$gambar'");
}
?>

<!DOCTYPE html>
<html lang="en">

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
    <form action="" method="POST" enctype="foto/">
      <fieldset>
        <legend>Input Data Mahasiswa</legend>
        <table>
          <tr>
            <td>
              <label for="nim">Nim</label>
            </td>
            <td>:</td>
            <td>
              <input type="text" name="nim" id="nim" required>
            </td>
          </tr>
          <tr>
            <td>
              <label for="nama">Nama</label>
            </td>
            <td>:</td>
            <td>
              <input type="text" name="nama" id="nama" required>
            </td>
          </tr>
          <tr>
            <td>
              <label for="tempat_lahir">TTL</label>
            </td>
            <td>:</td>
            <td>
              <input type="text" name="tempat_lahir" id="tempat_lahir" required>
              <input type="date" name="tgl_lahir" id="tgl_lahir" required>
            </td>
          </tr>
          <tr>
            <td>
              <label for="kelas">Alamat</label>
              <label for="kelas">Alamat</label>
            </td>
            <td>:</td>
            <td>
              <input type="text" name="alamat" id="alamat" required>
            </td>
          </tr>
          <tr>
            <td>
              <label for="kelas">Kelas</label>
            </td>
            <td>:</td>
            <td>
              <input type="text" name="kelas" id="kelas" required>
            </td>
          </tr>
          <tr>
            <td>
              <label for="progdi">Progdi</label>
            </td>
            <td>:</td>
            <td>
              <input type="text" name="progdi" id="progdi" required>
            </td>
          </tr>
          <tr>
            <td>
              <label for="no_hp">No HP</label>
            </td>
            <td>:</td>
            <td>
              <input type="text" name="no_hp" id="no_hp" required>
            </td>
          </tr>
          <tr>
            <td>
              <label for="gambar">Upload Gambar</label>
            </td>
            <td>:</td>
            <td>
              <input type="file" name="gambar" id="gambar" required>
            </td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td>
              <button type="reset">Batal</button>
              <button type="submit">Simpan</button>
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
            <td><?= $m['foto']; ?></td>
          </tr>
        <?php endforeach ?>

      </tbody>
    </table>
  </div>

</body>


</html>