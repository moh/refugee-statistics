<?php
session_start();
if($_SESSION['programs'] != "refugee"){
    header("Location: ../index.php");
    exit;
}

if(!isset($_POST["name"]) and !isset($_POST["resend"])){
    header("Location: index.php");
    exit;
}
// placed them at the top because of the js function
include "php_module/functions_db.php";
$con_info = OpenCon("refugee_data");
$con = $con_info[0];
?>


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

    button{
        width: 70px;
        height : 40px;
        padding: 10px;
        float: right;
        margin-right: 100px;
    }

    .table_found:hover{
        background-color: grey;
    }

</style>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="AR-SA" xml:lang="AR-SA">
<head>
    <meta charset="UTF-8" />
    <title>استمارة جمعية</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
</head>
<script>
    function click_on_row(){
        var id = parseInt(this.childNodes[0].innerHTML);
        var input_h = document.getElementById("input2");
        var forum2 = document.getElementById("form_found");
        input_h.value = id;
        forum2.submit();
    }

    function save_info(){
        var datas = <?php echo json_encode($_POST);?>;
        datas = JSON.stringify(datas);
        $.ajax({
            data: {resend : datas},
            url: 'check_data.php',
            method: 'POST', // or GET
            success: function(msg) {
                var a = <?php echo LastId($con,"basic_info")+1;?>;
                alert("your ID is : "+a);
                location.href = "index.php";
            }
        });

    }


    function main(){
        var res = document.getElementsByClassName("table_found");
        var save_butt = document.getElementById("save_butt");
        for(var x=0;x<res.length;x++){
            res[x].addEventListener("click",click_on_row);
        }
        save_butt.addEventListener("click",save_info);
    }
    window.addEventListener("load",main);

</script>

<body>

<?php




//var_dump($_POST);
// check if it's uniq and gonna be saved
if($_POST["resend"] != ""){
    $data = $_POST["resend"];
    //Decode the JSON string and convert it into a PHP associative array.
    $_POST = json_decode($data, true);
    saveData($con);
    echo "</body></html>";
    exit;
}

// if user want to edit data
if($_POST["id_selected"] != ""){
    $id = (int)$_POST["id_selected"];
    EditData($con,"basic_info",$id,array("name","family_name","father_name","grand_father_name","city","t_number","un_number","nationality","age"),
        [$_POST["name"],$_POST["family_name"],$_POST["father_name"],$_POST["grand_father_name"],$_POST["city"],$_POST["t_number"],$_POST["un_number"],$_POST["nationality"],$_POST["age"]],[]);
    EditData($con,"other_details",$id,array("mother_name","health","family_status","disease","wife1_name","note","blood_type","work","tent","property",
        "living_other","neighborhood","apartement","address_owner","add_owner_phone","house_number"
    ,"need_1","need_2","need_3","need_4","need_5","need_6","need_7","need_8","need_other","living_price","salary"),
        [$_POST["mother_name"] ,$_POST["health"],$_POST["family_status"],$_POST["disease"],$_POST["wife1_name"],$_POST["note"],$_POST["blood_type"],$_POST["work"],
            $_POST["tent"],$_POST["property"],$_POST["living_other"],$_POST["neighborhood"],$_POST["apartement"],$_POST["address_owner"],$_POST["add_owner_phone"],$_POST["house_number"],
            $_POST["need_1"],$_POST["need_2"],$_POST["need_3"],$_POST["need_4"],$_POST["need_5"],$_POST["need_6"],$_POST["need_7"],$_POST["need_8"],$_POST["need_other"]
        ],[$_POST["living_price"], $_POST["salary"] ]);
    DeleteData($con, "details_aides","id_spec",$id);
    DeleteData($con, "details_family","id_spec",$id);


    for($x=0;$x<sizeof($_POST["aides_aides"]);$x++){
        InsertToTable($con,"details_aides",array("aides_aides","aides_info","aides_dates","id_spec"),[$_POST["aides_aides"][$x],$_POST["aides_info"][$x],$_POST["aides_dates"][$x]],[$id]);
    }

    for($x=0;$x<sizeof($_POST["family_names"]);$x++){
        InsertToTable($con,"details_family",array("family_names","family_relation","family_birth","family_work","family_school","family_salary","id_spec"),
            [$_POST["family_names"][$x],$_POST["family_relation"][$x],$_POST["family_birth"][$x],$_POST["family_work"][$x],$_POST["family_school"][$x]],
            [$_POST["family_salary"][$x],$id]);

    }

    echo "<script>location.href = 'index.php';</script>";
    exit;
}

$res = SearchAnd($con,"basic_info",["name" => $_POST['name'],"family_name" => $_POST["family_name"]]);

if($res == 0){
    saveData($con);
    //header('Location: index.php');
    exit;
}
else{
    echo "<form name='Tables2_forum' action='display_data.php' id='form_found' method='post' >";
    $data = "<table id='customers'><tr><th>id</th><th>الاسم</th><th>الشهرة</th><th>اسم الاب</th><th>اسم الجد</th><th>المدينة</th><th>الهاتف</th><th>رقم الامم المتحدة</th><th>الجنسية </th><th>الميلاد</th><th>تاريخ التسجيل</th></tr>";
    echo $data;
    foreach($res as $row){
        echo "<tr class='table_found'>";
        foreach($row as $k=>$v){
            echo "<td>".$v."</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    echo "<input type='number' id='input2' name='id_selected' style='display:none'/></form>";
    echo '<button id="save_butt">save</button>';
}



function saveData($con){
    $lst_id = LastId($con,"basic_info");
    $err_found = False;

    if(InsertToTable($con,"basic_info",array("name","family_name","father_name","grand_father_name","city","t_number","un_number","nationality","age","id"),
        [$_POST["name"],$_POST["family_name"],$_POST["father_name"],$_POST["grand_father_name"],$_POST["city"],$_POST["t_number"],$_POST["un_number"],$_POST["nationality"],$_POST["age"]],[$lst_id + 1]) != TRUE){
        $err_found = TRUE;
    }

    if(InsertToTable($con,"other_details",array("mother_name","health","family_status","disease","wife1_name","note","blood_type","work","tent","property",
        "living_other","neighborhood","apartement","address_owner","add_owner_phone","house_number"
    ,"need_1","need_2","need_3","need_4","need_5","need_6","need_7","need_8","need_other","living_price","salary","id"),
        [$_POST["mother_name"] ,$_POST["health"],$_POST["family_status"],$_POST["disease"],$_POST["wife1_name"],$_POST["note"],$_POST["blood_type"],$_POST["work"],
            $_POST["tent"],$_POST["property"],$_POST["living_other"],$_POST["neighborhood"],$_POST["apartement"],$_POST["address_owner"],$_POST["add_owner_phone"],$_POST["house_number"],
            $_POST["need_1"],$_POST["need_2"],$_POST["need_3"],$_POST["need_4"],$_POST["need_5"],$_POST["need_6"],$_POST["need_7"],$_POST["need_8"],$_POST["need_other"]
        ],[$_POST["living_price"],$_POST["salary"],$lst_id + 1]) != TRUE){
        $err_found = TRUE;
    }

    for($x=0;$x<sizeof($_POST["aides_aides"]);$x++){
        if(InsertToTable($con,"details_aides",array("aides_aides","aides_info","aides_dates","id_spec"),[$_POST["aides_aides"][$x],$_POST["aides_info"][$x],$_POST["aides_dates"][$x]],[$lst_id + 1]) != TRUE){
            $err_found = TRUE;
        }
    }

    for($x=0;$x<sizeof($_POST["family_names"]);$x++){
        if(InsertToTable($con,"details_family",array("family_names","family_relation","family_birth","family_work","family_school","family_salary","id_spec"),
            [$_POST["family_names"][$x],$_POST["family_relation"][$x],$_POST["family_birth"][$x],$_POST["family_work"][$x],$_POST["family_school"][$x]],
            [$_POST["family_salary"][$x],$lst_id + 1]) != TRUE){
            $err_found = TRUE;
        }

    }
    if($err_found){echo " <p>ERROR FOUND </p>";exit;}
    else{echo "<script>var id_s = $lst_id+1;alert('you ID is ' + id_s);location.href = 'index.php';</script>";}
}

?>

</body>
</html>