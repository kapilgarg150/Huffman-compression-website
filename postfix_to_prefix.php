<!DOCTYPE HTML> 
<html>
<head>
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Postfix To Prefix</title>
<link rel="stylesheet" href="css/my_file.css">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body align= "center"> 
<?php
include "nav_bar.php";
$postfix="Enter Postfix Expression";$error='';
$prefix_value = "Output Prefix Expression";
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(empty($_POST["postfix"]))
	{
		$error = "Some input is Required";
	}
	else
	{
		$postfix = test_input($_POST["postfix"]);
		$prefix_value = prefix_exp_only($postfix);
	}
}
function stack($temp,$input,$i)
{
	echo	"<tr>
			<td>".$input[$i]."</td>
			<td>";
			$stack = "";
			$temp->rewind();
			for($nodes=0;$nodes<$temp->count();$nodes++)
			{
				$stack = $stack.($temp->current())."<br>";
				$temp->next();
			}
			$temp->rewind();
			echo	$stack;
			echo	"</td>
					</tr>";	
}
function test_input($data)
 {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
function prefix_exp_only($input)
{
	$temp = new SplStack();
	$output = "";
	for($i = 0;$i< strlen($input);$i++) 
	{
		if($input[$i] == ' ' || $input[$i] == ',' || $input[$i] == '(' || $input[$i] == ')') 
			continue;  
		else if(is_operator($input[$i])) 
		{
			$temp_1;$temp_2;$temp_3;
			$temp_3 = $input[$i];
			$temp_1 = $temp->pop();
			$temp_2 = $temp->pop();
			$temp->push($temp_3.$temp_2.$temp_1);
		}
		else if(is_operand($input[$i]))
		{
			$temp_3 = $input[$i];
			$temp->push($temp_3);
		}
	}
	return $temp->pop();
}
function prefix_exp($input)
{
	echo"<div style='overflow-x:auto;'>
		<table align= 'center' border ='1'>
		<tr>
		<th>Postfix</th>
		<th>Stack</th>
		</tr>";
	$temp = new SplStack();
	$output = "";
	for($i = 0;$i< strlen($input);$i++) 
	{
		if($input[$i] == ' ' || $input[$i] == ',' || $input[$i] == '(' || $input[$i] == ')') 
			continue;  
		else if(is_operator($input[$i])) 
		{
			$temp_1;$temp_2;$temp_3;
			$temp_3 = $input[$i];
			$temp_1 = $temp->pop();
			$temp_2 = $temp->pop();
			$temp->push($temp_3.$temp_2.$temp_1);
			stack($temp,$input,$i);
		}
		else if(is_operand($input[$i]))
		{
			$temp_3 = $input[$i];
			$temp->push($temp_3);
			stack($temp,$input,$i);
		}
	}
	return $temp->pop();
}
function is_operand($chrc) 
{
	if(($chrc >= '0' && $chrc <= '9') || ($chrc >= 'a' && $chrc <= 'z') || ($chrc >= 'A' && $chrc <= 'Z'))
		return true;
	return false;
}
function is_operator($chrc)
{
	if($chrc == '+' || $chrc == '-' || $chrc == '*' || $chrc == '/' || $chrc == '^'|| $chrc == '%')
		return true;
	return false;
}
?>
<div class="container">
<h2>Postfix to Prefix</h2><br>
<form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
<!-- input button by bootstrap--> 
	<div class="form-group">
      <label class="control-label col-sm-4" for="postfix" >POSTFIX :</label>
      <div class="col-sm-5">          
       <input type="text" name="postfix" class="form-control" id="postfix" placeholder="<?php echo $postfix ?>">
      </div>
    </div>
	<span class="error"><?php echo $error;?></span>
   <br><br>
   <div class="form-group">
      <label class="control-label col-sm-4" for="prefix" >PREFIX :</label>
      <div class="col-sm-5">          
       <input type="text" name="prefix" class="form-control" id="prefix" placeholder="<?php echo $prefix_value ?>" Disabled>
      </div>
    </div>
   <br><br>
   <input type="submit" class="btn btn-success btn-lg" name="submit" value="Submit"> 
</form>
</div>
<br><br>
<?php if ($_SERVER["REQUEST_METHOD"] == "POST")
			if(!empty($_POST["postfix"]))
				$prefix_value = prefix_exp($postfix); 
?>
</body>
</html>