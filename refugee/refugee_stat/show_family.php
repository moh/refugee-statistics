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

$con = OpenCon("refugee_data")[0];
$today_fam = GetDataToday($con,"basic_info");


if($today_fam == 0){
    $res = GetLastRows($con, "basic_info", 30);

    echo "<h1> عرض اخر 30 استمارة</h1>";
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



else{
    $n = sizeof($today_fam);
    echo "<h1>لقد تم العثور على $n عائلة مسجلة اليوم  </h1>";
    echo "<form name='Tables2_forum' action='display_data.php' id='form_found' method='post' >";
    echo "<table id='customers'><tr><th>id</th><th>الاسم</th><th>الشهرة</th><th>اسم الاب</th><th>اسم الجد</th><th>المدينة</th><th>الهاتف</th><th>رقم الامم المتحدة</th><th>الجنسية </th><th>الميلاد</th><th>تاريخ التسجيل</th></tr>";
    foreach($today_fam as $row){
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