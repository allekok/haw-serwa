<?php
require("const.php");

/* Function */
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
	$last_key = array_key_last($arr);
	foreach($arr[$last_key] as $o) {
		if(!$n--) return;
		echo "$o\n";
	}
	array_pop($arr);
	print_n($arr, $n);
}
/* https://www.php.net/manual/en/function.array-key-last.php#123016 */
if(!function_exists("array_key_last")) {
	function array_key_last($array) {
		if(!is_array($array) or empty($array))
			return NULL;
		return array_keys($array)[count($array)-1];
	}
}

/* Run */
header("Content-type: text/plain; charset=utf-8");

$input = @trim(filter_var($_REQUEST["q"], FILTER_SANITIZE_STRING));
if(!$input) exit(1);

$n = filter_var($_REQUEST["n"], FILTER_VALIDATE_INT) ?
     $_REQUEST["n"] : 30;

$path = TREE . "/" . mb_substr($input, -1) . "/1.txt";
if(!file_exists($path)) exit(1);

$words = trim(file_get_contents($path));
$words = explode("\n", $words);

$result = [];

foreach($words as $i => $word)
	@$result[serwa($input, $word)][] = $word;

print_n($result, $n);
?>
