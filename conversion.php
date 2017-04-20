<?php
function test_input($data)
 {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
function textbox($string)
{
	   echo "<p>";
	 //Huffman Counting
   $i=0;$count_char=array();
	for($i=0;$i<256;$i++)
		$count_char[$i]=0;
	$i=0;
	while ($i<strlen($string))
	{
		for($j=0;$j<256;$j++)
			if($string[$i]==chr($j))
			{
				$count_char[$j]++;
				break;
			}
		$i++;
	}
	echo "<h2>You Entered Total characters <em>".$i."</em></h2>";
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
	
	//Huffman Counting End
	//Huffman Compressionion start
	//class tree * 
	//Some functions for finding huffman
	
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
	$ans = "";
	for($i=0;$i<strlen($string);$i++)
	{
		$ans = $ans.code($result,$string[$i]);
	}
	echo "<h3>The converted Huffman Code is </h3><em><h2>".$ans."</h2></em>";
	echo "<h4>The Huffman code of Each distinct alphabet in given string is :</h4>";
	echo "
	<table align= 'center' border ='1'>
		<tr>
		<th>Ascii Code</th>
		<th>Char</th>
		<th>Huffman Code</th>
		</tr>";
		for($i=0;$i<256;$i++)
			if($count_char[$i]!=0)
			echo "<tr>
		<td>".($i)."</td>
		<td>".chr($i)."</td>
		<td>".code($result,chr($i))."</td>
		</tr>";
				
	echo "</table></p>";
	//Huffman compression End
}
?>