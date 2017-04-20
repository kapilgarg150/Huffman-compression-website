<?php
session_start();
$count_char = $_SESSION["count"];
include('phpgraphlib/phpgraphlib.php');
$data = array();
for($i=0;$i<256;$i++)
{
	if($count_char[$i]!=0)
		$data[chr($i)] = $count_char[$i];
}
$graph = new PHPGraphLib(800,500);
$graph->addData($data);
$graph->setTitle('Frequency Graph');
$graph->setGradient('red', 'maroon');
$graph->createGraph();
session_destroy();
?>