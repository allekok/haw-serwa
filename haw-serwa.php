<?php
require("const.php");

/* Run */
header("Content-type: text/plain; charset=utf-8");

$q = @trim(filter_var($_REQUEST["q"], FILTER_SANITIZE_STRING));
if(!$q) exit(1);
$q_last = mb_strlen($q)-2;

$n = @trim(filter_var($_REQUEST["n"], FILTER_SANITIZE_STRING));
$n = intval(translate_nums(
	translate_nums($n, "ckb", "en"), "fa", "en"));
if(!filter_var($n, FILTER_VALIDATE_INT)) $n = 30;

$path = TREE . "/" . mb_substr($q, -1) . "/1.txt";
if(!file_exists($path)) exit(1);

$words = trim(file_get_contents($path));
$words = explode("\n", $words);

$result = [];

foreach($words as $i => $word) {
	$w = explode("\t", $word);
	$i = serwa($q, $q_last, $w[0], $w[1]);
	@$result[$i][] = "$w[0]\t$i";
}

print_n($result, $n);

/* Functions */
function serwa($w_1, $w_1_last, $w_2, $w_2_last) {
	$i = 1;
	while($w_1_last >= 0 and
		$w_2_last >= 0 and
		L($w_1, $w_1_last--) == L($w_2, $w_2_last--)) $i++;
	return $i;
}
function L($word, $i) {
	return mb_substr($word, $i, 1);
}
function print_n($arr, $n) {
	if(!$arr) return;
	$last_el = array_pop($arr);
	foreach($last_el as $o) {
		if(!$n--) return;
		echo "$o\n";
	}
	print_n($arr, $n);
}
function translate_nums($str, $f, $t) {
	$numbers = [
		"en" => ["1","2","3","4","5","6","7","8","9","0"],
		"ckb" => ["١","٢","٣","٤","٥","٦","٧","٨","٩","٠"],
		"fa" => ["۰","۱","۲","۳","۴","۵","۶","۷","۸","۹"]
	];
	return str_replace($numbers[$f], $numbers[$t], $str);
}
?>
