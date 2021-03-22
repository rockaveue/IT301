<?php
  session_start();
  if(!isset($_SESSION["user"]))
  {
    header("Location:B180910062_login.php");
    exit;
  }

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "IT301";
  $con = mysqli_connect($servername, $username, $password, $dbname);
  if(!$con)
  {
    die("Алдаа:".mysqli_connect_error());
  }
?>
<!DOCTYPE html>
<html>
<head>
<title>Assignment 2</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
  <h4>Сэтгэгдлүүд</h4><br>
  <div class="row">
    <form action="description.php" method="post" style="width: 100%;">
      <div class="col-sm-9">
        <input type="text" name="setgegdel" class="form-control">
      </div>
      <div class="col-sm-3">
        <input type="submit" value="Сэтгэгдэл илгээх" class="form-control">
      </div>
    </form>
  <?php
    // MySQL-ийн форматаар одоогийн цагийг авч байна
    $time = date("Y-m-d H:i:s");
    if($_SERVER['REQUEST_METHOD'] == "POST"){
      // Сэтгэгдэл хэсэгт бичсэн зүйлсээс зарим онцгой тэмдэгтүүдийг html-д ашигладаг тусгай утга болгоно
      $comment = htmlspecialchars(str_replace(array("'", "\""), "", htmlspecialchars($_POST['setgegdel'])));
      $sql2 = "insert into comment(description, insertdate) values('$comment', '$time')";
      if($result2 = $con -> query($sql2)){
        $info = "Insert үйлдэл хийлээ.";
      } else {
        echo "Алдаа:".mysqli_error($con);
      }
      header("location:description.php");
    }
    // exit;

    $sql = "select * from comment";
    $result = mysqli_query($con, $sql);
  ?>
  <table class="table">
  <thead>
      <tr>
      <th scope="col">#</th>
      <th scope="col">Сэтгэгдэл</th>
      <th scope="col">Оруулсан огноо</th>
      </tr>
  </thead>
  <tbody>
  <?php while($utguud = mysqli_fetch_assoc($result)) { ?>
  <tr>
      <td><?= $utguud['id']; ?></td>
      <td><?= $utguud['description']; ?></td>
      <td><?= $utguud['insertdate']; ?></td>
  </tr>
  <?php } ?>
  </tbody>
  </table>

</div>
</body>
</html>