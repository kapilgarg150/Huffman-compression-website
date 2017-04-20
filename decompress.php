<?php
function decimal(&$a,$n)
{
	$value= 0;
	for($j=$n-1;$j>=0;$j--)
		$value += $a[$j]*pow(10,($n-$j-1));
	return $value;
}
function decompress($decompress_file, $freq)
{
	$name = "uploads/Encoded_by_Kapil.txt";
	//Downloading message
	echo "<br><span class='glyphicon glyphicon-download'></span>&nbsp;<a href= ".$name." download>Click here</a> to Download Decompressed file<br><br>";
	//decompression procedure
	$total_char = 0;$i=0;$count_char=array();
	for($i=0;$i<256;$i++)
		$count_char[$i]=0;
	$file = fopen($decompress_file,"r");
	$chrc = fgetc($file);
	$check2="\0";
	$temp=array();
	while (!feof ($file))
	{
		$check = fgetc($file);
		if($chrc=="\n" && feof ($file))
		{
		}
		else
		{
			if($chrc>=chr(48) && $chrc<=chr(57))
			{
				$temp[$i] = ($chrc-chr(48));
				$i++;
			}
			else
			{
				if($check2!="\0")
					{
						$count_char[ord($check2)]=decimal($temp,$i);
						$check2="\0";
						if($chrc==chr(10) && ($check>=chr(48) && $check<=chr(57)))
						{
							$check2 = $check;
							$check = fgetc($file);
						}
					}
				else
					$check2=$chrc;
				$i=0;
			}
			$chrc = $check;
		}
	}
	$count_char[ord($check2)]=decimal($temp,$i);
	fclose($file);
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
//make huffman tree
	$data = array();
	$total=0;	
	for($i=0;$i<256;$i++)
	{
		if($count_char[$i]!=0)
		{
			$data[$total] = new tree;
			$data[$total]->freq = $count_char[$i];
			$data[$total]->left = NULL;
			$data[$total]->right = NULL;
			$data[$total]->parent = NULL;
			$data[$total]->alpha = chr($i);
			$total++;
		}
	}
	$result = huffman($data,$total);
	$root = $result;
	$bit = array();
	for($j=0;$j<8;$j++)
		$bit[$j] =FALSE;
	$i=0;
	$file = fopen($freq,"r");
	$chrc = fgetc($file);
	$ready = fopen($name,"w");
	$prev = "";
		while (!feof ($file))
		{
			$check = fgetc($file);
			if(($chrc=="\n" && feof ($file)))
			{
			}
			else
			{
				if($chrc==chr(10) && $check>chr(48) && $check<chr(56))
				{
					$i=$check-chr(48);
					$chrc = $prev;
				}
				else if($check==chr(10) || feof ($file))
				{
					$i=0;
					$prev = $chrc;
				}
				else
				{
					$i=8;
				}
				for($j=0;$j<8;$j++)
					$bit[$j] = ord($chrc) & (1<<$j);
				for($j=0;$j<8;$j++)
					if($bit[$j]>0)
						$bit[$j]=1;
				for($j=0;$j<$i;$j++)
				{	
					if($root->left==NULL && $root->right==NULL)
					{
						fwrite($ready, $root->alpha);
						$root = $result;
					}
					if($bit[$j]==0)
						$root=$root->left;
					else if($bit[$j]==1)
						$root = $root->right;	
				}
				$i=0;
				$chrc = $check;
			}
		}	
		fwrite($ready, $root->alpha);
		fwrite($ready, "\n@Encoded by Kapil Garg (101403085) and Kapil Batra (101403084)");
	fclose($file);
	fclose($ready);
	echo "<strong>Your File has been Successfully Decompressed<br>The File name is <em>Encoded_by_kapil.txt</em></strong>";
}
?>