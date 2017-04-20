<!DOCTYPE HTML> 
<html>
<head>
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Infix To Postfix</title>
<link rel="stylesheet" href="css/my_file.css">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body align="center"> 
<?php
include "nav_bar.php";
$infix="Enter Infix Expression";$error='';
$postfix_value = "Output Postfix Expression";
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(empty($_POST["infix"]))
	{
		$error = "Input is Required";
	}
	else
	{
		$infix = test_input($_POST["infix"]);
		$infix = '('.$infix.')';
		$postfix_value = postfix_exp_only($infix);
	}
}
function test_input($data)
 {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
function stack($temp,$input,$i,$output)
{
	echo	"<tr>
			<td>".$input[$i]."</td>
			<td>";
			$stack = "";
			$temp->rewind();
			for($nodes=0;$nodes<$temp->count();$nodes++)
			{
				$stack = ($temp->current()).$stack;
				$temp->next();
			}
			$temp->rewind();
			echo	$stack;
			echo	"</td>
					<td>".$output."</td>
					</tr>";	
}
function only_once($temp,$input,$i,$output,$k)
{
	if($k==1)
	{
		stack($temp," ",0,$output);
	}
	else
		stack($temp,$input,$i,$output);
}
function postfix_exp($input)
{
	echo"<div style='overflow-x:auto;'>
		<table align= 'center' border ='1'>
		<tr>
		<th>Infix</th>
		<th>Stack</th>
		<th>Postfix</th>
		</tr>";
	$temp = new SplStack();
	$output = "";
	for($i = 0;$i< strlen($input);$i++) 
	{
		if($input[$i] == ' ' || $input[$i] == ',') 
		{
			continue;  
		}
		else if(is_operator($input[$i])) 
		{
			$k=0;
			while(!$temp->isEmpty() && $temp->top() != '(' && precedence($temp->top(),$input[$i]))
			{
				$output.= $temp->top();
				$temp->pop();
				only_once($temp,$input,$i,$output,$k);
				$k++;
			}
			$temp->push($input[$i]);
			if($k==0)
				stack($temp,$input,$i,$output);
			else
				stack($temp," ",0,$output);	
		}
		else if(is_operand($input[$i]))
		{
			$output.=$input[$i];
			stack($temp,$input,$i,$output);
		}
		else if ($input[$i] == '(') 
		{
			$temp->push($input[$i]);
			stack($temp,$input,$i,$output);
		}
		else if($input[$i] == ')') 
		{
			$k=0;
			while(!$temp->isEmpty() && $temp->top() !=  '(') 
			{
				$output .= $temp->top();
				$temp->pop();
				only_once($temp,$input,$i,$output,$k);
				$k++;
			}
			$temp->pop();
			stack($temp," ",0,$output);	
		}
	}
	while(!$temp->isEmpty())
	{
		$output .= $temp->top();
		$temp->pop();
		stack($temp,$input,$i,$output);
	}
	echo "</table></div>";
	return $output;
}
function postfix_exp_only($input)
{
	$temp = new SplStack();
	$output = "";
	for($i = 0;$i< strlen($input);$i++) 
	{
		if($input[$i] == ' ' || $input[$i] == ',') 
		{
			continue;  
		}
		else if(is_operator($input[$i])) 
		{
			while(!$temp->isEmpty() && $temp->top() != '(' && precedence($temp->top(),$input[$i]))
			{
				$output.= $temp->top();
				$temp->pop();
			}
			$temp->push($input[$i]);	
		}
		else if(is_operand($input[$i]))
		{
			$output.=$input[$i];
		}
		else if ($input[$i] == '(') 
		{
			$temp->push($input[$i]);
		}
		else if($input[$i] == ')') 
		{
			while(!$temp->isEmpty() && $temp->top() !=  '(') 
			{
				$output .= $temp->top();
				$temp->pop();
			}
			$temp->pop();	
		}
	}
	while(!$temp->isEmpty())
	{
		$output .= $temp->top();
		$temp->pop();
	}
	return $output;
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
function right_to_left($chrc)
{
	if($chrc=='^')
		return true;
	return false;
}
function operator_precedence($opera)
{
	$num;
	if($opera=='+' || $opera=='-')
		$num=1;
	else if($opera=='*' || $opera=='/' || $opera=='%')
		$num=2;
	else if($opera=='^')
		$num=3;
	return $num;
} 
function precedence($operator_1, $operator_2)
{
	$op1_precedence = operator_precedence($operator_1);
	$op2_precedence = operator_precedence($operator_2);
	if($op1_precedence == $op2_precedence)
	{
		return !right_to_left($operator_1);
	}
	return $op1_precedence > $op2_precedence ?  true: false;
}
?>
<div class="container">
<h2>Infix to Postfix</h2><br>
<form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
<!-- input button by bootstrap--> 
	<div class="form-group">
      <label class="control-label col-sm-4" for="infix" >INFIX :</label>
      <div class="col-sm-5">          
       <input type="text" name="infix" class="form-control" id="infix" placeholder="<?php echo $infix ?>">
      </div>
    </div>
	<span class="error"><?php echo $error;?></span>
   <br><br>
   <div class="form-group">
      <label class="control-label col-sm-4" for="postfix" >POSTFIX :</label>
      <div class="col-sm-5">          
       <input type="text" name="postfix" class="form-control" id="postfix" placeholder="<?php echo $postfix_value ?>" Disabled>
      </div>
    </div>
   <br><br>
   <input type="submit" class="btn btn-success btn-lg" name="submit" value="Submit"> 
</form>
</div>
<br><br>
<?php if(!empty($_POST["infix"]))$postfix_value = postfix_exp($infix); ?>
</body>
</html>