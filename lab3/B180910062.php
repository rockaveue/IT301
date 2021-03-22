<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "IT301";

    $con = mysqli_connect($servername, $username, $password, $dbname);
    if(!$con)
    {
        die("Алдаа:".mysqli_connect_error());
    }
    $nameError = '';
    $method = $_SERVER['REQUEST_METHOD'];

    if($method == "POST"){
        if(empty($_POST["name"])){
            $nameError = "Нэрээ оруулна уу!";
        } elseif(empty($_POST['email'])){
            $nameError = "Имэйл хаягаа оруулна уу!";
        }
    }
    if(isset($_GET['crud'])){
        $crud = $_GET['crud'];
        if($crud == 'delete'){
            # Устгах үйлдэл
            $id = $_GET['id'];
            $sql = "delete from employee where employeeid = $id";
            $con -> query($sql);
            $info = "Delete үйлдэл хийлээ.";
        } elseif($crud == 'edit'){
            $irsenId = $_GET['id'];
            $irsenNer = $_GET['name'];
            $irsenEmail = $_GET['email'];
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laboratory - 3</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Бүртгэлийн хуудас</h1>
    <form name = "myForm" action="B180910062.php" method="post" onsubmit="return validate()">
    <input type="hidden" name="crud" 
    value="<?php if(isset($_GET["crud"])){echo ($_GET['crud'] == 'edit') ? $_GET['id']: '';}?>">
    <div class="row">
        <div class="col-sm-6">
            <label>Ажилтны нэр:</label>
            <input type="text" name="name" class="form-control"
            value="<?php if(isset($_GET['name'])) echo $_GET['name'];?>">
            <span><?php echo $nameError; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label>Ажилтны и-мэйл:</label>
            <input type="text" name="email" class="form-control"
            value="<?php if(isset($_GET['email'])) echo $_GET['email'];?>">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label>Нууц үг:</label>
            <input type="password" name="password" class="form-control">
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-sm-6">
            <input type="submit" name="btnsave" value="Хадгалах" class="btn  btn-primary">
        </div>
    </div>
    </form>
    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $password = md5($_POST["password"]);
            $mysqltime = date ('Y-m-d');
            if($_POST['crud'] != ''){
                $irsenId = $_POST['crud'];
                $sql = "update employee set name = '$name', email = '$email', lastaccess = '$mysqltime' where employeeid = $irsenId";
                $info = "Update үйлдэл хийлээ.";
            } else {
                $sql = "insert into employee(name, email, pass, lastaccess) values('$name','$email', '$password', '$mysqltime')";
            }
            if($result = $con -> query($sql)){
                if(!isset($info)){
                    $info = "Insert үйлдэл хийлээ.";
                }
            } else {
                echo "Алдаа:".mysqli_error($con);
            }
        }
        $sql = "select * from employee";
        # result-д бүх ажилчдаа авав
        $result = mysqli_query($con, $sql);
        // $result = $con -> query($sql);
        if(isset($info)){
            echo $info;
        }
        echo "<br>";
        

    ?>

    <table class="table">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Ажилтны нэр</th>
        <th scope="col">Ажилтны имэйл хаяг</th>
        <th scope="col">Ажилтны нууц үг</th>
        <th scope="col">Сүүлд нэвтэрсэн өдөр</th>
        <th scope="col">Хийх үйлдэл</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($result as $utguud) : ?>
    <tr>
        <td><?= $utguud['employeeid']; ?></td>
        <td><?= $utguud['name']; ?></td>
        <td><?= $utguud['email']; ?></td>
        <td><?= $utguud['pass']; ?></td>
        <td><?= $utguud['lastaccess']; ?></td>
        <td><a class='mr-2' href="B180910062.php?crud=edit&id=<?=$utguud['employeeid'];?>&name=<?=$utguud['name'];?>&email=<?=$utguud['email'];?>">Засах</a>
            <a class='mr-2' href="B180910062.php?crud=delete&id=<?=$utguud['employeeid'];?>" >Устгах</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
    <script>
    function validate(){
        if(document.forms['myForm']["name"].value == '')
        {
            alert('Нэрээ оруулна уу!');
            return false;
        } else if(document.forms['myForm']["email"].value == ''){
            alert('Имэйл хаягаа оруулна уу!');
            return false;
        }
    }
    </script>
</div>
</body>
</html>
