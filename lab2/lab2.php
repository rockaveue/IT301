<!DOCTYPE html>
<html>
<head>
<title>Lab-01</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    body{
        background-color: lightblue;
        font-family: Arial, Helvetica, sans-serif;
        padding: 1em;
    }
    .text-large{
        font-size: 130%;
    }
    .btn{
        outline: none !important;
        box-shadow: none !important;
        font-size: 80%;
    }
    .container{
        background-color:#fff;
        border-radius: 1em;
        padding: 1em;
    }
    .btn-primary, .btn-primary:hover{
        background-color: #6892FD !important;
        border-color: #6892FD !important;
        /* outline-color: #6892FD !important; */
    }
    .btn-light{
        background-color: #E3E5EF;
    }
</style>
</head>
<body>
    <?php 
        // if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['submit'])){
            $huvirgah = $_POST['huvirgah'];
            $huvirsan = $_POST['huvirsan'];
            if(isset($_POST['turul'])){
                if(is_numeric($huvirgah)){
                    if($_POST['turul'] == 'inch'){
                        $huvirsan = $huvirgah * 2.54;
                    } else if($_POST['turul'] == 'km'){
                        $huvirsan = $huvirgah * 1.60934;
                    } else if($_POST['turul'] == 'pound'){
                        $huvirsan = $huvirgah * 453.592;
                    } else if($_POST['turul'] == 'watt'){
                        $huvirsan = $huvirgah * 735.499;
                    } else if($_POST['turul'] == 'barrel'){
                        $huvirsan = $huvirgah * 158.98;
                    }
                    $huvirsan = number_format($huvirsan, 2);
                }
            }
        }
        
    ?>
    <div class="container">
    <form name = "converter" action="lab2.php" method="post">
        <div class="row mt-2">
            <div class="ml-5 text-large">
                Утга хөрвүүлэх
            </div>
            <div class="ml-auto mr-3">
                <button class="btn btn-primary">Бүх лаборатори ажил</button>
            </div>
        </div>
    <div class="row mt-4">
        <div class="col-sm-6">
        <label>Хувиргах утга:</label>
        <input type="number" name="huvirgah" id = 'huvirgah' class="form-control" value = "<?php echo (isset($huvirgah)) ? $huvirgah : '';?>">
        </div>
        <div class="col-sm-6">
        <label>Хувиргах төрөл:</label>
        
        <select name="turul" id="" class="form-control">
            <option value = "" disabled selected>-сонго-</option>
            <option name = "inch" value="inch" <?php if(isset($_POST['turul'])){ echo $_POST['turul'] == 'inch' ? ' selected="selected"' : '';}?>>Инч-СМ</option>
            <option name = "km" value="km" <?php if(isset($_POST['turul'])){ echo $_POST['turul'] == 'km' ? ' selected="selected"' : '';}?>>Бээр-КМ</option>
            <option name = "pound" value="pound" <?php if(isset($_POST['turul'])){ echo $_POST['turul'] == 'pound' ? ' selected="selected"' : '';}?>>Паунд-ГРАМ</option>
            <option name = "watt" value="watt" <?php if(isset($_POST['turul'])){ echo $_POST['turul'] == 'watt' ? ' selected="selected"' : '';}?>>Морины хүч-Ватт</option>
            <option name = "barrel" value="barrel" <?php if(isset($_POST['turul'])){ echo $_POST['turul'] == 'barrel' ? ' selected="selected"' : '';}?>>Баррел-литр</option>
        </select>
        </div>
        <div class="col-sm-6">
        <label class="text-secondary">Нэгжийн утга:</label>
        <input type="text" name="huvirsan" id = 'huvirsan' class="form-control"  maxlength="10" value="<?php echo (isset($huvirsan)) ? $huvirsan : '';?>">
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-sm-12">
        <input name = "submit" type="submit" value="Хувиргах" class="btn btn-primary">
        <input type="submit" value="Цуцлах" class="btn btn-light" onclick="reset()">
        </div>
    </div>
    </form>
    </div>
    <script>
        function reset(){
            document.getElementById('huvirgah').value = '';
            document.getElementById('huvirsan').value = '';
        }
    </script>
</body>
</html>