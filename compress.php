<?php
function compress($compress_file)
{
	//Downloading message
	echo "<br><span class='glyphicon glyphicon-download'></span>&nbsp;<a href= ".$compress_file."_convert.txt download>Click here</a> to Download Convert file<br>";
	echo "<span class='glyphicon glyphicon-download'></span>&nbsp;<a href= ".$compress_file."_frequency.txt download>Click here</a> to Download Frequency file<br><br>";
	//name coorectness
	$old_size = filesize($compress_file.".txt");
	$arr = explode("/",$compress_file);
	$next="";
	$i=1;
	while($i<count($arr))
	{
		$next = $next.$arr[$i];
		$i++;
	}	
	//next movement
	$file_name="";$name="";
	$file_name = $compress_file;
	$name = $file_name;
	$file_name = $file_name.".txt";
	$file = fopen($file_name,"r");
	$chrc;
	$total_char = 0;$i=0;$count_char = array();
	for($i=0;$i<256;$i++)
		$count_char[$i]=0;
	$chrc = fgetc($file);
	while (!feof ($file))
	{
		$check = fgetc($file);
		if($chrc==chr(10) && feof ($file))
		{
		}
		else
		{
			if($chrc==chr(13) && $check == chr(10))
			{
				$chrc = chr(10);
				$check = fgetc($file);
			}
			for($i=0;$i<256;$i++)
				if($chrc==chr($i))
				{
					$count_char[$i]++;
					break;
				}
			$total_char++;
			$chrc = $check;
		}
	}
	fclose($file);
	$data=array();
	$total=0;
	$decompress="";
	$decompress = $name."_frequency.txt";
	$myfile = fopen($decompress, "w") 
	or
		die("Unable to open file!");	
	for($i=0;$i<256;$i++)
	{
		if($count_char[$i]!=0)
		{	
			fwrite($myfile, chr($i).$count_char[$i].chr(10));
			$data[$total] = new tree;
			$data[$total]->freq = $count_char[$i];
			$data[$total]->left = NULL;
			$data[$total]->right = NULL;
			$data[$total]->parent = NULL;
			$data[$total]->alpha = chr($i);
			$total++;
		}
	}
	fclose($myfile);
	$new_size = filesize($decompress);
	$result = huffman($data,$total);
	$ans="";
	$file = fopen($file_name,"r");
	$chrc = fgetc($file);
	while (!feof ($file))
	{
		$check = fgetc($file);
		if(($chrc==chr(10) && feof ($file)))
		{
		}
		else
		{
			if($chrc==chr(13) && $check == chr(10))
			{
				$chrc = chr(10);
				$check = fgetc($file);
			}
			$ans = $ans.code($result,$chrc);
			$chrc = $check;
		}
	}
	fclose($file);
	
	//Write code to a converted file	

	$convert = $name."_convert.txt";
	$myfile = fopen($convert, "w") 
	or
		die("Unable to open file!");	
	fwrite($myfile, $ans);
	fclose($myfile);
		
	//this has to be done correct		
	$bit=array();$i=0;
	$alpha=chr(0);
	$ans_new="";
	$file = fopen($convert,"r");
	$chrc = fgetc($file);
	while (!feof ($file))
	{
		$check;
		$check = fgetc($file);
		if($chrc=="\n" && feof ($file))
		{
		}
		else
		{
			if($chrc=="0")
				$bit[$i] = FALSE;
			else
				$bit[$i] = TRUE;
			++$i;
			$chrc = $check;
			if($i==8)
			{
				for($j=0;$j<8;$j++)
					$alpha = $alpha | ($bit[$j] << $j);
				$ans_new = $ans_new.chr($alpha);
				$i=0;
				$alpha=chr(0);
			}
			
		}
	}
	fclose($file);
	
	if($i!=0)
	for($j=$i;$j<8;$j++)
	{
		$bit[$j]=FALSE;
	}
	for($j=0;$j<8;$j++)
		$alpha = $alpha | ($bit[$j] << $j);
	$ans_new = $ans_new.chr($alpha);		
	$alpha = chr(48+$i);
	$ans_new = $ans_new."\n".$alpha;		
	//again write to file after converting 8 bits to 1 byte
			
	$myfile = fopen($convert, "w") 
	or
		die("Unable to open file!");	
	fwrite($myfile, $ans_new);
	/*
	for($i=0;$i<256;$i++)
	{
		if($count_char[$i]!=0)
		{	
			fwrite($myfile, chr($i).$count_char[$i].chr(10));
		}
	}*/
	fclose($myfile);
	$new_size += filesize($convert);
	echo '<div class="progress">
    <div class="progress-bar progress-bar-';
	if($new_size < $old_size)
	{
		echo 'success"';
	}
	else
	{
		echo 'danger"';
	}
	echo 'role="progressbar" aria-valuenow="'.(100-($new_size*100/$old_size)).'" aria-valuemin="0" aria-valuemax="100" style="width:'.(100-($new_size*100/$old_size)).'%">
     '. (100-($new_size*100/$old_size))
    .' compressed</div>
  </div>';
	echo "<strong>Thank You, Your File has been compressed  ".(100-($new_size*100/$old_size))." %</strong><br>";
	echo "<h4>So , Some of the info of your Files are :</h4>";
	echo "<h3>total char are <em>".$total_char."</em></h3>";
	$_SESSION["count"] = &$count_char;
	echo "<img src='check_graph.php' alt='Frequency graph' /><br><br>";
	echo "
	<table align= 'center' border ='1'>
		<tr>
		<th>Ascii Code</th>
		<th>Char</th>
		<th>Count</th>
		</tr>";
		for($i=0;$i<256;$i++)
			if($count_char[$i]!=0)
			echo "<tr>
		<td>".$i."</td>
		<td>".chr($i)."</td>
		<td>".$count_char[$i]."</td>
		</tr>";	
	echo "</table>";
	echo "<h4>The File will be compressed in </h4><h3><em>".$next."_convert.txt</em></h3><h4> and frequencies will be save in </h4><h3><em>".$next."_frequency.txt</em></h3>'";
}
?>