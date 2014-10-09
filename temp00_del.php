

<h1>留言版</h1>
<hr>
<form action="#" method="POST">
    NAME:::<input type="text" name="fname">
    msg:::::::<input type="text" name="msg">
    <input type="hidden" name="originator" value="<?=$sscode?>">
    <input type="submit" value="submit">

</form>
<hr>
<h3>訪客留言</h3>

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
if ($drjson) {
$stdin = std_class_object_to_array($drjson); //叫func，把obj轉成陣列，因為很多層
krsort($stdin); //以key做反排序
foreach ($stdin as $key => $value) {
    echo ";;;";
    echo "名紙：".$value["name"];
    echo "訊息：".$value["msg"];
    echo "<br>";
}
} else { 
    echo "<h3>沒有留言，或著檔案是空的</h3>";
}      //if ($drjson)

 ?>