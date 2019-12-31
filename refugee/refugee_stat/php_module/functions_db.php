<?php

function OpenCon($d_name)
{
	$pass = "";
	$con = new mysqli("localhost", "root", $pass,$d_name);
	if($con->connect_errno){
    	$con = new mysqli("localhost","root",$pass);
    	$con->query("CREATE DATABASE ".$d_name);
    	$con->select_db($d_name);
    	return array($con,true);
    }
	return array($con,false);
}

function CreatTable($con,$table_name,$s_values,$int_values,$date_values){
	$table_data = "CREATE TABLE ".$table_name." (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,";
	foreach ($s_values as $x){
    	$table_data = $table_data." ".$x." "."VARCHAR(30) NOT NULL,";
    }
	foreach($int_values as $x){
    	$table_data = $table_data." ".$x." "."INT(6) UNSIGNED DEFAULT 0,";
    }
	foreach($date_values as $x){
    	$table_data = $table_data." ".$x." "."DATE ,";
    }
	$table_data = $table_data.("reg_date TIMESTAMP)");
    $con->query($table_data);
	return $table_data;
}


function InsertToTable($con, $table_name, $s_data, $s_values,$int_values){
	$data_1 = "INSERT INTO ".$table_name." (";
	$data_2 = " VALUES (";
	foreach ($s_data as $x){
    	$data_1 = $data_1.$x.",";
    }
	foreach($s_values as $x){
    	$data_2 = $data_2."'".$x."',";
    }
	foreach($int_values as $x){
    	$data_2 = $data_2.$x.",";
    }
	$data_1 = rtrim($data_1,",");
	$data_1 .= ")";
	$data_2 = rtrim($data_2,",");
	$data_2 .= ")";	

	$data_1 = $data_1.$data_2.";";
    $res = $con->query($data_1);
    if($res === TRUE){
        return TRUE;
    }
    else{
        echo json_encode($con->error);
    }
}


function SearchAnd($con,$table,$data){
	$req = "SELECT * FROM ".$table." WHERE ";
	foreach($data as $k=>$v){
    	$req .= $k." = '".$v."' AND ";
    }
	$req = rtrim($req," AND ");
	$res = $con->query($req);
	
	if($res->num_rows > 0){
    	while($row=$res->fetch_assoc()){
        	$n_array[] = $row;
        }
    	return $n_array;
    }
	else{
    	return 0;
    }
}

function SearchIds($con,$table,$id_n,$id_v){
	$req = "SELECT * FROM ".$table." WHERE ".$id_n." = ".$id_v;
	$res = $con->query($req);

	if($res->num_rows > 0){
    	while($row=$res->fetch_assoc()){
        	$n_array[] = $row;
        }
    	return $n_array;
    }
	else{
    	return 0;
    }
}

function EditData($con, $table, $id,$s_data,$s_values,$int_values){
	$sql_query = "UPDATE ".$table." SET ";
	for($x=0;$x<sizeOf($s_values);$x++){
    	$sql_query .= $s_data[$x]."='".$s_values[$x]."', ";
    }
	$l = sizeOf($s_values);
	for($x=0;$x<sizeOf($int_values);$x++){
    	$sql_query .= $s_data[$x+$l]."=".$int_values[$x].",";
    }
	
	$sql_query = rtrim($sql_query, ", ");
	$sql_query .= " WHERE id=".$id;

    $res = $con->query($sql_query);
    if($res === TRUE){
        return TRUE;
    }
    else{
        echo json_encode($con->error);
    }
	
}

function DeleteData($con, $table, $column, $value){
	$sql_query = "DELETE FROM ".$table." WHERE ".$column."=".$value;
    $res = $con->query($sql_query);
    if($res === TRUE){
        return TRUE;
    }
    else{
        echo json_encode($con->error);
    }

}


function LastId($con,$table){
	$res = $con->query("SELECT max(id) FROM ".$table.";");
	$res = $res->fetch_assoc();
	return $res["max(id)"];
}

function CloseCon($con){
	$con->close();
}

function GetDataToday($con,$table){
    $req = "SELECT * FROM $table WHERE reg_date > CURDATE();";
    $res = $con->query($req);

    if($res->num_rows > 0){
        while($row=$res->fetch_assoc()){
            $n_array[] = $row;
        }
        return $n_array;
    }
    else{
        return 0;
    }

}

function GetLastRows($con, $table,$N)
{
    $req = "SELECT * FROM $table ORDER BY id DESC LIMIT $N";
    $res = $con->query($req);
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $n_array[] = $row;
        }
        return $n_array;
    } else {
        return 0;
    }
}
?>