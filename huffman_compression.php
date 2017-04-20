<?php
session_start();
?>
<!DOCTYPE HTML> 
<html>
<head>
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Huffman Compression</title>
<link rel="stylesheet" href="css/my_file.css">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body align= "center"> 
<?php
include "nav_bar.php";
//if a user enter  input
$error='';
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if($_FILES["compress_file"]["name"])
	{
		$target_name = "uploads/" . basename($_FILES["compress_file"]["name"]);
		$extension = pathinfo($target_name,PATHINFO_EXTENSION);
		if(file_exists($target_name))
		{
			unlink($target_name);
		}
		if ($_FILES["compress_file"]["size"] >50000)
		{
			$error = "Please, upload a text file < 50 KB";
		}
		else if($extension!="txt")
		{
			$error = "Please, upload a TEXT File";
		}
		else if (!move_uploaded_file($_FILES["compress_file"]["tmp_name"], $target_name))
		{
			$error = "Sorry, there was an error in uploading your file.";
		}
	}
	else
	{
		$error = "Please upload a file";
	}
}
?>
<div class="container">
<h2>Huffman Compression</h2>
<br>
<form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data"> 
<!-- input button by bootstrap--> 
	
   <div class="form-group">
      <label class="control-label col-sm-4" for="compress_file" >File:</label>
      <div class="col-sm-5">          
       <input type="file" name="compress_file" class="form-control" id="compress_file">
      </div>
    </div>
   <span class="error"><?php echo $error;?></span>
   <br><br>
   <input type="submit" class="btn btn-success btn-lg" name="submit" value="Submit"> 
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	if ($error=="") 
	{
		include "fun.php";
		include "compress.php";
		$target_name = "uploads/" .pathinfo($_FILES["compress_file"]["name"])["filename"];
		compress($target_name);
	}
}
?>
</div>
</body>
</html>