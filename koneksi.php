<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <form action="" method="POST" enctype="multipart/form-data">
    <label for="file">foto</label>
    <input type="file" name="file" id="file">
    <button type="submit">simpan</button>
  </form>
  <?php var_dump($_POST); ?>
  <?php var_dump($_FILES); ?>
</body>

</html>