<?php
class tree
{
	public $freq;
	public $alpha;
	public $left;
	public $right;
	public $parent;
}
function heapify(&$arr,&$check_alpha,$n,$i)
{
    $largest = $i;
    $l = 2*$i + 1;
    $r = 2*$i + 2;
    if ($l < $n && $arr[$l] > $arr[$largest])
        $largest = $l;
    if ($r < $n && $arr[$r] > $arr[$largest])
        $largest = $r;
    if ($largest != $i)
    {
		$temp_count = $arr[$i];
        $arr[$i] = $arr[$largest];
		$arr[$largest] = $temp_count;
		$temp_alpha = $check_alpha[$i];
		$check_alpha[$i] = $check_alpha[$largest];
		$check_alpha[$largest] = $temp_alpha;
        heapify($arr, $n, $largest);
    }
}
function extract_min(&$check_count,&$check_alpha,$n)
{
    heapify($check_count,$check_alpha,$n,0);
	$temp = $check_count[0];
	$check_count[0] = $check_count[$n];
	$check_count[$n] = $temp;
	$temp = $check_alpha[0];
	$check_alpha[0] = $check_alpha[$n];
	$check_alpha[$n] = $temp;
	$temp = new tree;
	$temp->freq = $count_count[$n];
	$temp->left = NULL;
	$temp->right = NULL;
	$temp->parent = NULL;
	$temp->alpha = $check_alpha[$n];
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
function huffman(&$check_count,&$check_alpha,$n)
{
	$temp_num = $n;
	for ($i=($temp_num/2)-1;$i>=0;$i--)
		heapify($check_count,$check_alpha,$temp_num,$i);
	for($i=0;$i<$temp_num-1;$i++)
	{
		$temp = new tree;
		$temp->left = extract_min($$check_count,$check_alpha,$n);
		$n--;
		$temp->right = extract_min($$check_count,$check_alpha,$n);
		$n--;
		$temp->left->parent = $temp;
		$temp->right->parent = $temp;
		$temp->parent = NULL;
		$temp->freq = $temp->left->freq + $temp->right->freq;
		$temp->alpha = NULL;
		insert($list,$temp);
	}
	return  extract_min($check_count,$check_alpha,$n);
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