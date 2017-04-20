<?php
class tree
{
	public $freq;
	public $alpha;
	public $left;
	public $right;
	public $parent;
}
function extract_min(&$list,$n)
{
	$min ;$i=0;$index;
	while(is_null($list[$i]))
		$i++;
	$min = $list[$i]->freq;
	$index = $i;
	for($i=$i+1;$i<$n;$i++)
	{
		if(!is_null($list[$i]) && $min>$list[$i]->freq)
		{
			$index = $i;
			$min = $list[$i]->freq;
		}
	}
	$temp = new tree;
	$temp = $list[$index];
	$list[$index]=NULL;
	return $temp;
}
function insert(&$list,$temp)
{
	$i=0;
	while(!is_null($list[$i]))
	{
		$i++;
	}
	$list[$i] = $temp;
}
function huffman(&$list,$n)
{
	for($i=0;$i<$n-1;$i++)
	{
		$temp = new tree;
		$temp->left = extract_min($list,$n);
		$temp->right = extract_min($list,$n);
		$temp->left->parent = $temp;
		$temp->right->parent = $temp;
		$temp->parent = NULL;
		$temp->freq = $temp->left->freq + $temp->right->freq;
		$temp->alpha = NULL;
		insert($list,$temp);
	}
	return  extract_min($list,$n);
}
function search($result,$x)
{
	$find_left=NULL;
	$find_right=NULL;
	if(!is_null($result))
	{
		if($result->alpha == $x)
		{
			return $result;
		}
		$find_left = search($result->left,$x);
		$find_right = search($result->right,$x);
	}
	if(!is_null($find_left))
		return $find_left;
	else if(!is_null($find_right))
		return $find_right;
	else
		return NULL;
}
function code($result,$x)
{
	$ans="";
	$find = search($result,$x);
	if(is_null($find))
	{
		echo "Entered aplhabet is not there in given data<br>";
		return "Sorry";
	}
	else
	{
		while(!is_null($find->parent))
		{
			if($find == $find->parent->right)
				$ans = "1".$ans;
			else
				$ans = "0".$ans;
			$find = $find->parent;
		}
		return $ans;
	}
}
?>