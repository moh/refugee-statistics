<?php
	session_start();

if($_SESSION['programs'] != "refugee"){
    header("Location: ../index.php");
    exit;
}

if(!isset($_POST["id_selected"])){
    header("Location: index.php");
	exit;
}

	include "php_module/functions_db.php";
	include "php_module/functions_dom.php";
	include "php_module/html_content.php";

	$con = OpenCon("refugee_data")[0];
	$id = $_POST["id_selected"];
	//echo $id;
	$basic_info = SearchIds($con,"basic_info","id",$id)[0];
	$other_details = SearchIds($con,"other_details","id",$id)[0];

	$details_family = SearchIds($con,"details_family","id_spec",$id);
	$details_aides = SearchIds($con,"details_aides","id_spec",$id);
	
	//var_dump($details_family);

	$total_data = array_merge($basic_info, $other_details);
	//var_dump($total_data);	

	$doc = new DOMDocument();
	$doc->loadHTML($html_content);
	$inputs = $doc->getElementsByTagName("input");
	$tables = $doc->getElementsByTagName("table");
	
	foreach($inputs as $node){
    	$type = $node->getAttribute("type");
    	$name = $node->getAttribute("name");
    	
    	if($type == "text" or $type=="number" or $type=="date"){
        	
        	$node->setAttribute("value",$total_data[$name]);
        }
    	elseif($type == "checkbox"){
        	if($total_data[$name] == "on"){
            	$node->setAttribute("checked","true");
            }
        }
    }


	$family_table = $tables[1]; // number of family table

if($details_family != 0){
	for($x=0;$x<sizeOf($details_family);$x++){
    	$member = $details_family[$x];
    
    	$tr = creat_element($doc,"tr",[],[]);
    	
    	$td1 = creat_element($doc,"td",[],[]);    	
    	$input1 = creat_element($doc,"input",["type","name","class","value"],["text","family_names[]","err_check read_only",$member["family_names"]]);
    	$td1->appendChild($input1);
    
    	
    	$options = ["الأب","الأم","الأخ","الأخت","الإبن","الابنة","زوجة"];
    	$select = creat_element($doc,"select",["name"],["family_relation[]"]);
    	for($y=0;$y<sizeOf($options);$y++){
        	$o = creat_element($doc,"option",["value"],[$y+1]);
        	$o->appendChild($doc->createTextNode($options[$y]));
        	$select->appendChild($o);
        }
    	
    	$td2 = creat_element($doc,"td",[],[]);
    	$td2->appendChild($select);
    	
    	$td3 = creat_element($doc,"td",[],[]);
    	$input3 = creat_element($doc,"input",["type","name","class","value"],["date","family_birth[]","read_only",$member["family_birth"]]);
    	$td3->appendChild($input3);
    
    	$td4 = creat_element($doc,"td",[],[]);
    	$input4 = creat_element($doc,"input",["type","name","value"],["text","family_work[]",$member["family_work"]]);
    	$td4->appendChild($input4);
    	
    	$td5 = creat_element($doc,"td",[],[]);
    	$input5 = creat_element($doc,"input",["type","name","value"],["text","family_school[]",$member["family_school"]]);
    	$td5->appendChild($input5);
    	
    	$td6 = creat_element($doc,"td",[],[]);
    	$input6 = creat_element($doc,"input",["type","name","value"],["number","family_salary[]",$member["family_salary"]]);
    	$td6->appendChild($input6);
    	
    	$list_td = [$td1,$td2,$td3,$td4,$td5,$td6];
    	foreach($list_td as $td_e){$tr->appendChild($td_e);}
    	$family_table->appendChild($tr);
    }
}
	$aides_table = $tables[4];
	if ($details_aides != 0){
		for($x=0;$x<sizeOf($details_aides);$x++){
    		$aide = $details_aides[$x];
    		$tr = creat_element($doc,"tr",[],[]);
    	
    		$td1 = creat_element($doc,"td",[],[]); 
    		$options = [" مواد غذائية"," بطانيات"," فرش"," مازوت للتدفئة"," مدفأة "," ملابس"," أحذية"," مستلزمات رُضع","حصص اضاحي ","نقدي"];
    		$select = creat_element($doc,"select",["name"],["aides_aides[]"]);
    		for($y =0;$y<sizeOf($options);$y++){
        		$o = creat_element($doc,"option",["value"],[$y+1]);
        		$o->appendChild($doc->createTextNode($options[$y]));
        		$select->appendChild($o);
        	}
    		$td1->appendChild($select);
    
    		$td2 = creat_element($doc,"td",[],[]);
    		$textarea2 = creat_element($doc,"textarea",["name","class","value"],["aides_info[]","read_only",$aide["aides_info"]]);
    		$td2->appendChild($textarea2);
    	
    		$td3 = creat_element($doc,"td",[],[]);
    		$input3 = creat_element($doc,"input",["type","name","class","value"],["date","aides_dates[]","read_only",$aide["aides_dates"]]);
    		$td3->appendChild($input3);
    
   	 		$tr->appendChild($td1);$tr->appendChild($td2);$tr->appendChild($td3);
    		$aides_table->appendChild($tr);
    }
    }

	
	$s_doc = $doc->saveHTML();
	echo $s_doc;
	
?>

<script type="text/javascript">
				var el = document.getElementById("input2");
				el.value=<?php echo $id;?>;

    			var table_family = document.getElementById("family_stat");
                var selects = table_family.getElementsByTagName("select");
				var details = <?php echo json_encode($details_family); ?>;
                for(var x=0;x<selects.length;x++){
                	selects[x].value = details[x]["family_relation"];
                
                }
				var aides_table = document.getElementById("aides");
				var selects2 = aides_table.getElementsByTagName("select");
				var textarea2 = aides_table.getElementsByTagName("textarea");
				var details2 = <?php echo json_encode($details_aides);?>;
                for(var x=0;x<selects2.length;x++){
                	selects2[x].value = details2[x]["aides_aides"];
                }
				for(var x=0;x<textarea2.length;x++){
                	textarea2[x].value = details2[x]["aides_info"];
                }

				var datas = <?php echo json_encode($total_data);?>;
				var select_general = document.getElementsByTagName("select");
				var textarea_general = document.getElementsByTagName("textarea");
				for(var x=0;x<select_general.length;x++){
                	element = select_general[x];
                	name = element.name;
                	if (name in datas){element.value = datas[name];}
                }
				for(var x=0;x<textarea_general.length;x++){
                	element = textarea_general[x];
                	name = element.name;
                	if (name in datas){element.value = datas[name];}
                }

				read_only_eles = document.getElementsByClassName("read_only");
				for(var x=0;x<read_only_eles.length;x++){
                	read_only_eles[x].readOnly = true;
                	read_only_eles[x].style.backgroundColor = "white";
                }
				
</script>