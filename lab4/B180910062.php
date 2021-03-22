<?php
//   sleep(1);
    // холболт
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "IT301";
    $con = mysqli_connect($servername, $username, $password, $dbname);

    if(!$con)
    {
        die("Алдаа:".mysqli_connect_error());
    }
    // get хүсэлтээр name нэртэй хувьсагч ирсэн байвал
    if(isset($_GET["name"]))
    {
        // тухайн хувьсагчаар өгөгдлийн сангаас хайлт хийнэ
        $name = $_GET["name"];
        // like '%name%' гэвэл name гэсэн үг эхэн, дунд, адагт байх боломжтой бүх бичлэгүүдийг авна
        $sql = mysqli_query($con, "select * from employee where name like '%$name%'");
        // row хувьсагчид ирсэн хүснэгтийг хийхийн тулд массив үүсгэв
        $rows = array();
        while($r = mysqli_fetch_assoc($sql)) {
            // ирж байгаа мөр бүрийг rows-д хийж байна
            $rows[] = $r;
        }
        // json хэлбэрт оруулж байна
        $result = json_encode($rows);
        // json хэлбэрт оруулсан бол гаргана
        if($result)
        {
            echo $result;
        }
        else
        {
            echo mysqli_error($con);
        }
        // $mysqli -> close();
    // харин name биш email хувьсагч ирвэл
    } elseif(isset($_GET['email'])){
        // тухайн хувьсагчаар өгөгдлийн сангаас хайлт хийнэ
        $name = $_GET["email"];
        // like '%name%' гэвэл name гэсэн үг эхэн, дунд, адагт байх боломжтой бүх бичлэгүүдийг авна
        $sql = mysqli_query($con, "select * from employee where email like '%$name%'");
        // row хувьсагчид ирсэн хүснэгтийг хийхийн тулд массив үүсгэв
        $rows = array();
        while($r = mysqli_fetch_assoc($sql)) {
            // ирж байгаа мөр бүрийг rows-д хийж байна
            $rows[] = $r;
        }
        // json хэлбэрт оруулж байна
        $result = json_encode($rows);
        // json хэлбэрт оруулсан бол гаргана
        if($result)
        {
            echo $result;
        }
        else
        {
            echo mysqli_error($con);
        }
    // crud буюу edit эсвэл delete дарсан тохиолдолд
    } elseif(isset($_GET['crud'])){
        if($_GET['crud'] == 'delete'){ // delete дарсан бол
            // id хувьсагч давхар ирэх тул тухайн хувьсагчийг авна
            $id = $_GET['id'];
            // тухайн id-тай бичлэгийг өгөгдлийн сангаас устгана
            $sql = "delete from employee where employeeid = $id";
            // query-г ажиллуулав
            $con -> query($sql);
            $info = "Delete үйлдэл хийлээ.";
        } else { // edit дарсан бол
            $irsenId = $_GET['id']; // id
            $shineNer = $_GET['newname']; // солих нэр
            $editType = $_GET['edittype']; // нэр эсвэл имэйлийг солих

            if($editType == 1){
                // ирсэн хувьсагчуудаар тухайн id-ийн бичлэгийн нэрийг солих query
                $sql = "update employee set name = '$shineNer' where employeeid = $irsenId;";
                $info = "Нэр update үйлдэл хийлээ.";
            } else {
                // ирсэн хувьсагчуудаар тухайн id-ийн бичлэгийн email-ийг солих query
                $sql = "update employee set email = '$shineNer' where employeeid = $irsenId;";
                $info = "И-мэйл хаяг update үйлдэл хийлээ.";
            }
            // query-г ажиллуулав
            $con -> query($sql);
        }
        // ямар үйлдэл хийснийг гаргана
        if(isset($info)){
            echo $info;
        }
        
    }
  ?>
