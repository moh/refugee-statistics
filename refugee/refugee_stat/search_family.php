<style>
    #customers {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 90%;
        direction:rtl;
        float: right;
    }

    #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
        direction:rtl;
    }

    #customers tr:nth-child(even){background-color: #f2f2f2;}

    #customers tr:hover {background-color: #ddd;}

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }
    input[type='submit']{
        width: 70px;
        height : 40px;
        padding: 10px;
        float: right;
        margin-right: 100px;
        margin-top: 50px;

    }

    #logo_image{
        width: 200px;
        height: 200px;
        float: right;
        margin-bottom: 20px;
    }
    
    h1{
        width: 100%;
        text-align: right;
        display: inline-block;
        margin-bottom: 50px;
        color: grey;
    }


</style>

<script>
    function submit_data() {
        var txts = document.querySelectorAll("input[type=text]");
        for(var x=0;x<txts.length;x++){
            txts[x].value = txts[x].value.trim();
        }
        return true;
    }

    function click_on_row(){
        var id = parseInt(this.childNodes[0].innerHTML);
        var input_h = document.getElementById("input2");
        var forum2 = document.getElementById("form_found");
        input_h.value = id;
        forum2.submit();
    }

    function main(){
        var res = document.getElementsByClassName("table_found");
        for(var x=0;x<res.length;x++){
            res[x].addEventListener("click",click_on_row);
        }
    }
    window.addEventListener("load",main);
</script>

<?php
session_start();
include "php_module/functions_db.php";

if($_SESSION['programs'] != "refugee"){
    header("Location: ../index.php");
    exit;
}
echo "<img src='../../images/logo.jpg'; id='logo_image'/>";

if(empty($_POST)){
    echo "<form name='Tables2_forum' action='' id='form_search' method='post' onsubmit='return submit_data();' >";
    echo "<table id='customers'><tr><th>id</th><th>الاسم</th><th>الشهرة</th><th>اسم الاب</th><th>اسم الجد</th><th>المدينة</th><th>الهاتف</th><th>رقم الامم المتحدة</th><th>الجنسية </th><th>الميلاد</th></tr>
    <tr><td><input type='number' name=
    'id'/></td><td><input type='text' name='name'/></td><td><input type='text' name='family_name'/></td><td><input type='text' name='father_name'/></td><td><input type='text' name='grand_father_name'/></td>
            <td><input type='text' name='city'/></td><td><input type='text' name='t_number'/></td><td><input type='text' name='un_number'/></td><td><input type='text' name='nationality'/></td><td><input type='date' name='age'/></td></tr></table>";

    echo "<input type='submit' value='search'/></form>";
}

else{
    $con = OpenCon("refugee_data")[0];

    $not_empty = [];
    foreach ($_POST as $k=>$v){
        if($v != ""){
            $not_empty[$k] = $v;
        }
    }
    $res = SearchAnd($con,"basic_info",$not_empty);

    if(empty($res)){
        echo "<h1>NO RESULT FOUND</h1>";
        exit;
    }
    
	$n = sizeof($res);
    echo "<h1>لقد تم العثور على $n عائلة </h1>";
    
    echo "<form name='Tables2_forum' action='display_data.php' id='form_found' method='post' >";
    echo "<table id='customers'><tr><th>id</th><th>الاسم</th><th>الشهرة</th><th>اسم الاب</th><th>اسم الجد</th><th>المدينة</th><th>الهاتف</th><th>رقم الامم المتحدة</th><th>الجنسية </th><th>الميلاد</th><th>تاريخ التسجيل</th></tr>";
    foreach($res as $row){
        echo "<tr class='table_found'>";
        foreach($row as $k=>$v){
            echo "<td>".$v."</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    echo "<input type='number' id='input2' name='id_selected' style='display:none'/></form>";
}

?>