<?php
require("const.php");

/* Run */
header("Content-type: text/plain; charset=utf-8");

$q = @trim(filter_var($_REQUEST["q"], FILTER_SANITIZE_STRING));
if(!$q) exit(1);

$n = filter_var($_REQUEST["n"], FILTER_VALIDATE_INT) ?
     $_REQUEST["n"] : 30;

$path = TREE . "/" . mb_substr($q, -1) . "/1.txt";
if(!file_exists($path)) exit(1);

$words = trim(file_get_contents($path));
$words = explode("\n", $words);

$result = [];

foreach($words as $i => $word)
	@$result[serwa($q, $word)][] = $word;

print_n($result, $n);

/* Functions */
function serwa ($word_1, $word_2) {
	$i = 0;
	$word_1_len = mb_strlen($word_1) - 1;
	$word_2_len = mb_strlen($word_2) - 1;
	while($word_1_len >= 0 and $word_2_len >= 0 and
		mb_substr($word_1, $word_1_len--, 1) ==
			mb_substr($word_2, $word_2_len--, 1)) $i++;
	return $i;
}
function print_n ($arr, $n) {
	if(!$arr) return;
	$last_el = array_pop($arr);
	foreach($last_el as $o) {
		if(!$n--) return;
		echo "$o\n";
	}
	print_n($arr, $n);
}
?>
