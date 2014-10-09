<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title> PHP 存取檔案 by json format</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
.badge_me {
  display: inline-block;
  min-width: 10px;
  padding: 3px 7px;
  margin: 0px 5px 0px 30px;
  /*font-size: 12px;*/
  font-weight: bold;
  line-height: 1;
  color: #ffffff;
  text-align: center;
  white-space: nowrap;
  vertical-align: baseline;
  background-color: #999999;
  border-radius: 10px;
}
.boardme {
  padding: 3px 5px;
  margin: 20px 0px 0px 0px;
}
.hr_me{
  margin-top: 20px;
  margin-bottom: 10px;
  border: 0;
  border-top: 1px solid #5A5A5A;

}
.hr_me_content{
  margin-top: 0px;
  margin-bottom: 0px;
  border: 0;
  border-top: 1px solid #A0A0A0;

}
    </style>
</head>

<body>
<?php 
//防提交表單
session_start();
$a=$_SESSION['sscode']; 
$sscode = mt_rand(0,1000000);
$_SESSION['sscode'] = $sscode;
?>

<div class="container">
    <div class="row clearfix">
        <div class="col-md-12 column">
                <h1> PHP 存取檔案 by json format</h1>
            <div class="row clearfix">
                <div class="col-md-6 column">
                    <form action="#" method="POST">
                        <div class="form-group">
                             <label>username:</label>
                             <input type="text" class="form-control" require name="fname">
                        </div>
                        <div class="form-group">
                             <label>message:</label>
                             <input type="text" class="form-control" name="msg">
                        </div>
                            <input type="hidden" name="originator" value="<?=$sscode?>">
                        <input type="submit" class="btn btn-success btn-lg">
                    </form>
                </div>
            </div>

<?php 
//讀取json，並且 把$_POST寫入 JSON_OBJ
$myFile = "testFile.txt";
$rjson= file_get_contents($myFile,true);
$drjson=json_decode($rjson);
if (isset($_POST["fname"]) ){
     if($_POST['originator'] == $a){
        $user_input_name= $_POST["fname"];
        $user_input_msg= $_POST["msg"];
        $objjson=(array)$drjson;
        $arr1try = array('name'=>$user_input_name,'msg'=>$user_input_msg); //試插插的arr
        $new_key = count($objjson);  //因為加一減一過了，所以不要加加減減了
        $objjson[$new_key]=$arr1try;
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, json_encode($objjson));
        fclose($fh);
        }
}  //if (isset($_POST["fname"])) the end {{}}

 ?>
<?php 
function std_class_object_to_array($stdclassobject)
{
    $_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;
    foreach ($_array as $key => $value) {
        $value = (is_array($value) || is_object($value)) ? std_class_object_to_array($value) : $value;
        $array[$key] = $value;
    }
    return $array;
}
///讀檔和列出
$rjson= file_get_contents($myFile,true);
$drjson=json_decode($rjson);
?>
            <div class="jumbotron boardme">
                <h2> <b>  訪客留言</b>  </h2>
                <hr class="hr_me">
<?php  
if ($drjson) {
$stdin = std_class_object_to_array($drjson); //叫func，把obj轉成陣列，因為很多層
krsort($stdin); //以key做反排序
foreach ($stdin as $key => $value) {
    echo '<span class="badge_me">username:</span>' ;
    echo '<label>'.$value["name"].'</label>';
    echo '<span class="badge_me">message:</span>';
    echo '<label>'.$value["msg"].'</label>';
    echo '<hr class="hr_me_content">';
}
} else { 
    echo "<h3>沒有留言，或著檔案是空的</h3>";
}      //if ($drjson)

 ?>
        </div>
        </div>
    </div>
</div>
</body>
</html>
