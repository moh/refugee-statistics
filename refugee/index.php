<style>

	body {font-family: Arial, Helvetica, sans-serif;}
	form {
    	
    	margin : auto;
    	margin-top: 100px;
    	border: 3px solid #f1f1f1;
    	padding : 20px;
		width: 20%;
	}
	input[type=text], input[type=password] {
 		width: 100%;
  		padding: 12px 20px;
  		margin: 8px 0;
  		display: inline-block;
  		border: 1px solid #ccc;
  		box-sizing: border-box;
	}
	p{
    	margin-left : 10px;
    	font-weight: bold;
	}
	button{
    	margin-top: 20px;
    	width: 100%;
    	padding: 10px;
    	text-align: center;
    	background-color: #4CAF50;
  		color: white;
	}
	#error{
    	
    	color: red;
	}

</style>

<script>
	
	function delete_error(){
    	var error = document.getElementById("error");
    	if(error != null){
        	error.style.display = "none";
        }
    }

	function main(){
    	var inputs = document.getElementsByTagName("input");
    	for(var x=0;x<inputs.length;x++){
        	inputs[x].addEventListener("keydown",delete_error);
        }
    }
	window.addEventListener("load",main);
</script>

<?php
	$html_login = '
    	<form action="" method="post">
        	<p>Username</p>
    		<input type="text" name="username" placeholder="Enter your username" required/>
            <p>Password</p>
    		<input type="password" name="password" placeholder="Enter your password" required/>
    		<span id="error" style="display: none">Please Try Again</span>
    		<button>Log in</button>
		</form>
    ';

	session_start();

if ( ! empty( $_POST ) ) {
    if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {
        // Getting submitted user data from database
       	if($_POST['username'] == "aca_members" and $_POST['password'] == "refugee_day1"){
        	
        	$_SESSION['programs'] = "refugee";
        	header('Location: refugee_stat/index.php');
        	exit;
        }
    	else{
        	echo  $html_login;
        	echo "<script>var err = document.getElementById('error');err.style.display='';</script>";
        }
    		
    	
    }
}

else{
	echo $html_login;
}

?>