<?php
session_start();
?>
<!DOCTYPE HTML> 
<html>
<head>
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Huffman Conversion</title>
<link rel="stylesheet" href="css/my_file.css">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body align= "center"> 
<?php
include "nav_bar.php";
//if a user enter  input
$string="Enter String Here";$error='';
if ($_SERVER["REQUEST_METHOD"] == "POST")
	if (empty($_POST["input"])) 
	{
		$error = "Please Enter some text";
	}
	else 
   {
	 include "fun.php";
	 include "conversion.php";
    $string = test_input($_POST["input"]);
   }
?>
<div class="container">
<h2>Huffman Conversion</h2>
<br>
<form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
<!-- input button by bootstrap--> 
	<div class="form-group">
      <label class="control-label col-sm-4" for="input" >String :</label>
      <div class="col-sm-5">          
       <input type="text" name="input" class="form-control" id="input" placeholder="<?php echo $string ?>">
      </div>
    </div>
	<span class="error"><?php echo $error;?></span>
   <br><br>
   <input type="submit" class="btn btn-success btn-lg" name="submit" value="Submit"> 
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
   if (empty($_POST["input"])) 
   {
     $error = "Some input is required";
   }
   else 
   {
     $string = test_input($_POST["input"]);
	textbox($string);
   }
}
?>
</div>
</body>
</html>