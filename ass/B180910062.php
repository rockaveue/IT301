<!DOCTYPE html>
<html>
<head>
<title>Assignment-1</title>
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
        session_start();
        $array = array();
        class Conversion{
            public $input;
            public $output;
            public $description;
            function __construct(){
            }
            function set(float $input, float $output, string $description){
                $this -> input = $input;
                $this -> output = $output;
                $this -> description = $description;
            }
        }
        // if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['submit'])){
            $huvirgah = $_POST['huvirgah'];
            $huvirsan = $_POST['huvirsan'];
            if(isset($_POST['turul'])){
                if(is_numeric($huvirgah)){
                    if($_POST['turul'] == 'Инч-СМ'){
                        $huvirsan = $huvirgah * 2.54;
                    } else if($_POST['turul'] == 'Бээр-КМ'){
                        $huvirsan = $huvirgah * 1.60934;
                    } else if($_POST['turul'] == 'Паунд-ГРАМ'){
                        $huvirsan = $huvirgah * 453.592;
                    } else if($_POST['turul'] == 'Морины хүч-Ватт'){
                        $huvirsan = $huvirgah * 735.499;
                    } else if($_POST['turul'] == 'Баррел-литр'){
                        $huvirsan = $huvirgah * 158.98;
                    }
                    $huvirsan = number_format($huvirsan, 2, '.', '');
                    // шинэ объект үүсгэв
                    $conversionObject = new Conversion();
                    $conversionObject -> set($huvirgah, $huvirsan, $_POST['turul']);		
                    if(isset($_SESSION['history'])){
                        // session байвал үүнийг массивт утгад аван
                        // шинэ объектыг нэмэв
                        $array = $_SESSION['history'];
                        if(count($array) > 4){
                            array_shift($array);
                        }
                    }
					array_push($array, $conversionObject);
					
                    // Шинэ массиваа session-д хадгалав.
					$_SESSION['history'] = $array;
                }
            }
        }
        // session_destroy();
    ?>
    <div class="container">
    <form name = "converter" action="B180910062.php" method="post">
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
            <option name = "inch" value="Инч-СМ" <?php if(isset($_POST['turul'])){ echo $_POST['turul'] == 'Инч-СМ' ? ' selected="selected"' : '';}?>>Инч-СМ</option>
            <option name = "km" value="Бээр-КМ" <?php if(isset($_POST['turul'])){ echo $_POST['turul'] == 'Бээр-КМ' ? ' selected="selected"' : '';}?>>Бээр-КМ</option>
            <option name = "pound" value="Паунд-ГРАМ" <?php if(isset($_POST['turul'])){ echo $_POST['turul'] == 'Паунд-ГРАМ' ? ' selected="selected"' : '';}?>>Паунд-ГРАМ</option>
            <option name = "watt" value="Морины хүч-Ватт" <?php if(isset($_POST['turul'])){ echo $_POST['turul'] == 'Морины хүч-Ватт' ? ' selected="selected"' : '';}?>>Морины хүч-Ватт</option>
            <option name = "barrel" value="Баррел-литр" <?php if(isset($_POST['turul'])){ echo $_POST['turul'] == 'Баррел-литр' ? ' selected="selected"' : '';}?>>Баррел-литр</option>
        </select>
        </div>
        <div class="col-sm-6">
        <label class="text-secondary">Нэгжийн утга:</label>
        <input type="text" name="huvirsan" id = 'huvirsan' maxlength="10" class="form-control" value="<?php echo (isset($huvirsan)) ? $huvirsan : '';?>">
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-sm-12">
        <input name = "submit" type="submit" value="Хувиргах" class="btn btn-primary">
        <input type="submit" value="Цуцлах" class="btn btn-light" onclick="reset()">
        </div>
    </div>
    </form>
    <table class="table">
    <thead>
    <tr> <th colspan="4" style="text-align: center;"> Таны хөрвүүлсэн сүүлийн 5 утга(Түүх)</th></tr>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Нэгж</th>
        <th scope="col">Оролт</th>
        <th scope="col">Гаралт</th>
        </tr>
    </thead>
    <tbody>
    <?php 
		$myarray = $array;
        if(isset($_SESSION['history'])){
            $myarray = $_SESSION['history'];
        }
        // $myObj = new Conversion();
        $i = 1;
        $input=0;
        print_r($myarray);
        foreach(array_reverse($myarray) as $utguud) : 
            $myObj = (object)$utguud;
            // $myObj = $utguud;
            // $utguud -> cast($utguud, $Conversion);
            // $utguud = (object)$utguud;
    ?>
    <tr>
        <td><?= $i; ?></td>
        <td><?= $utguud -> description ; ?></td>
        <td><?= $utguud -> input; ?></td>
        <td><?= $utguud -> output; ?></td>
    </tr>
    <?php 
        $i++;
        endforeach; ?>
    </tbody>
    </table>
    </div>
    <script>
        function reset(){
            document.getElementById('huvirgah').value = '';
            document.getElementById('huvirsan').value = '';
        }
    </script>
</body>
</html>