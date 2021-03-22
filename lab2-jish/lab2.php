<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">\
    <link rel = "stylesheet" href = "https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Laboratory - 2</title>
</head>
<body>
<div class="container">
    <form action="lab2.php" method="post">
        <div class="row">
            <div class="col-sm-6">
                <label>First Name: </label>
                <input type="text" name="fname" class="form-control">
            </div>
            <div class="col-sm-6">
                <label>Password: </label>
                <input type="password" name="userpass" class="form-control">
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-sm-6">
                <input type="submit" value="Save">
                <input type="reset" value="reset">
            </div>
        </div>
    </form>
<?php
    if(isset($_POST["fname"])){
        echo $_POST["fname"];
    }
?>

</div>
</body>
</html>