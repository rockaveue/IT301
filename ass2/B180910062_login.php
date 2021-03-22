<?php
session_start();
// MySQL холболт
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "IT301";
$con = mysqli_connect($servername, $username, $password, $dbname);

if(!$con)
{
  die("Алдаа:".mysqli_connect_error());
}
$error = '';
$error1 = '';
$error2 = '';
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  // email хаягийг авч байна
  $email = $_POST["user_id"];
  $err = 0;
  // Server-side дээрх шалгах үйлдэл
  if(empty($_POST["user_id"])){
    $error1 = "Имэйл хаягаа оруулна уу!";
  } elseif(empty($_POST['user_pass'])){
    $error2 = "Нууц үгээ оруулна уу!";
  } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    // filer_var функцээр имэйл-ийг жинхэнэ эсэхийг шалгана
    $error1 = "Имэйл алдаатай байна.";
  } else {
    //sql injection - с сэргийлж байна. 
    // MySQL-д аюулгүй утга оруулахын тулд зарим нэг тэмдэгтүүдийн урд нь backslash-\ -ийг залгаж өгнө.
    $safe_username = mysqli_real_escape_string($con, $email);


    // bind_param() - ашиглавал шууд query-гээ execute хийгээд өгөгдлийн сан луу явуулалгүй эхлээд prepare хийж дараа нь параметрүүдээ execute хийлгүйгээр bind хийж хадгалан эцэст нь execute хийхэд өөр протоколоор дамжуулж байгаа тул SQL injection гарах боломжгүй болох юм.
    // query-гээ бэлдэж байгаа нь
    $stmt = mysqli_prepare($con, "select email, pass from employee where email=? and pass=md5( ?)");
    // user, pass гэсэн 2 утга авна
    mysqli_stmt_bind_param($stmt, 'ss', $user, $pass);
    $user = $safe_username;
    $pass = $_POST["user_pass"];
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $user, $pass);
    
    // execute хийгээд email, pass ирвэл true-г буцаана
    if(mysqli_stmt_fetch($stmt) == 'true')
    {
      // checkbox-ийг зөвлөвөл cookie үүсгэнэ
      if(isset($_POST['rememberMe'])){
        // myCookie утгад имэйл хаягаа хадгалж байна
        setcookie("myCookie", $safe_username, time()+604800); // 7 хоногийн дараа expire хийнэ
      }
      // нэвтэрсэн болгох утга
      $_SESSION['user'] = 0;
      mysqli_stmt_close($stmt);
      header("Location:description.php");
      exit;
    }
    else {
      // Хэрэв False-ийг буцаавал query-гээс мөр ирээгүй учир хэрэглэгчийн мэдээлэл буруу эсвэл байхгүй хэрэглэгч
      $error = "Нэвтрэх эрхгүй хэрэглэгч";
    }
  }
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
  <div class="row justify-content-center align-items-center">
    <form name = "myForm" action="B180910062_login.php" method="post" onsubmit="return validate()">
      <h1>Нэвтрэх</h1>
      <div class="row">
        <div class="col-sm-12">
          <label>Хэрэглэгчийн имэйл:</label>
          <input type="text" name="user_id" class="form-control" value="<?php if(isset($_COOKIE['myCookie'])) echo $_COOKIE['myCookie']; ?>">
          <label id="userCom"> <?= $error1; ?></label>
        </div>
        <div class="col-sm-12">
          <label>Нууц үг:</label>
          <input type="password" name="user_pass" class="form-control">
          <label id="passCom"> <?= $error2; ?></label>
          <span><?php echo $error; ?></span>
        </div>
        <div class="col-sm-12">
          <input type="checkbox" name="rememberMe" id="">
          <label >Намайг сана</label>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-sm-12">
          <input type="submit" value="Login">
          <input type="reset" value="reset">
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  // RegEx = Regular Expression буюу формат шалгах формат үүсгэнэ.
  // Нэр шалгах RegEx
  // var re = new RegExp(/^[a-zA-Zа-яА-я]+(([',. -][a-zA-Zа-яА-я ])?[a-zA-Zа-яА-я]*)*$/g);
  // Имэйл шалгах RegEx 
  var re = new RegExp(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
  function validate(){
    // Client-side дээрх шалгах үйлдэл
    name = document.forms['myForm']["user_id"].value;
    document.getElementById('userCom').innerHTML = '';
    document.getElementById('passCom').innerHTML = '';
    if(name == ''){ // Имэйл-ийн хэсэг хоосон бол
      document.getElementById('userCom').innerHTML = 'Имэйлээ оруулна уу!';
      return false;
    } else if(document.forms['myForm']["user_pass"].value == ''){ // Нууц үгийн хэсэг хоосон бол
      document.getElementById('passCom').innerHTML = 'Нууц үгээ оруулна уу!';
      return false;
    } else{
      // дээр үүсгэсэн re гэсэн regex-ээр хэрэглэгчийн оруулсан мэйл хаягийг шалгаж байна
      // алдаатай имэйл хаяг бол False утга буцаана
      if (re.test(name)) {
        console.log("Valid");
      } else {
        console.log("Invalid");
        document.getElementById('userCom').innerHTML = 'Имэйл алдаатай байна!';
        return false;
      }
    }
  }
</script>
</body>
</html>
