<?php
  sleep(3);
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "IT301";
  $con = mysqli_connect($servername, $username, $password, $dbname);

  if(!$con)
  {
    die("Алдаа:".mysqli_connect_error());
  }

  if(isset($_GET["name"]))
  {
    $name = $_GET["name"];
    $email = $_GET["email"];
    $pass = $_GET["pass"];
    $sql = "insert into Employee(name, email, pass) values('$name','$email', md5('$pass'))";

    if(mysqli_query($con, $sql))
    {
      echo "Амжилттай хадгаллаа";
    }
    else
    {
      echo mysqli_error($con);
    }
  }
  ?>
