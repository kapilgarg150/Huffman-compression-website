<?php
session_start();
?>
<!DOCTYPE HTML> 
<html>
<head>
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Huffman Decompression</title>
<link rel="stylesheet" href="css/my_file.css">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body align= "center"> 
<?php
include "nav_bar.php";
//if a user enter  input
$error1='';$error2='';
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if($_FILES["convert_file"]["name"])
	{
		$target_name = "uploads/" . basename($_FILES["convert_file"]["name"]);
		$extension = pathinfo($target_name,PATHINFO_EXTENSION);
		if(file_exists($target_name))
		{
			unlink($target_name);
		}
		if ($_FILES["convert_file"]["size"] >50000)
		{
			$error1 = "Please, upload a text file < 50 KB";
		}
		else if($extension!="txt")
		{
			$error1 = "Please, upload a TEXT File";
		}
		else if (!move_uploaded_file($_FILES["convert_file"]["tmp_name"], $target_name))
		{
			$error1 = "Sorry, there was an error in uploading your file.";
		}
	}
	else
	{
		$error1 = "Please upload a file";
	}
	if($_FILES["frequency_file"]["name"])
	{
		$target_name = "uploads/" . basename($_FILES["frequency_file"]["name"]);
		$extension = pathinfo($target_name,PATHINFO_EXTENSION);
		if(file_exists($target_name))
		{
			unlink($target_name);
		}
		if ($_FILES["frequency_file"]["size"] >50000)
		{
			$error2 = "Please, upload a text file < 50 KB";
		}
		else if($extension!="txt")
		{
			$error2 = "Please, upload a TEXT File";
		}
		else if (!move_uploaded_file($_FILES["frequency_file"]["tmp_name"], $target_name))
		{
			$error2 = "Sorry, there was an error in uploading your file.";
		}
	}
	else
	{
		$error2 = "Please upload a file";
	}
}
?>
<div class="container">
<h2>Huffman Decompression</h2>
<br>
<form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data"> 
<!-- input button by bootstrap--> 
	
   <div class="form-group">
      <label class="control-label col-sm-4" for="convert_file" >Converted File :</label>
      <div class="col-sm-5">          
       <input type="file" name="convert_file" class="form-control" id="convert_file">
      </div>
    </div>
   <span class="error"><?php echo $error1;?></span>
   <br><br>
   <div class="form-group">
      <label class="control-label col-sm-4" for="frequency_file" >Frequency File:</label>
      <div class="col-sm-5">          
       <input type="file" name="frequency_file" class="form-control" id="frequency_file">
      </div>
    </div>
   <span class="error"><?php echo $error2;?></span>
   <br><br>
   <input type="submit" class="btn btn-success btn-lg" name="submit" value="Submit"> 
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	if ($error1=="" && $error2=="") 
	{
		include "fun.php";
		include "decompress.php";
		$target_name1 = "uploads/" .basename($_FILES["frequency_file"]["name"]);
		$target_name2 = "uploads/" .basename($_FILES["convert_file"]["name"]);
		decompress($target_name1, $target_name2);
	}
}
?>
</div>
</body>
</html>