<?php
require("const.php");

const INP = ["rebwar/words/ckb/ckb.txt"];

rmdir_rec(TREE);

foreach(INP as $inp) {
	$words = trim(file_get_contents($inp));
	$words = explode("\n", $words);
	foreach($words as $word) {
		$last_letter = mb_substr($word, -1);
		$last_index = mb_strlen($word) - 2;
		@mkdir(TREE."/$last_letter", 0755, true);
		$f = fopen(TREE."/$last_letter/1.txt", "a");
		fwrite($f, "$word\t$last_index\n");
		fclose($f);
	}
}

function rmdir_rec ($path) {
	$files = array_diff(scandir($path), [".",".."]);
	foreach($files as $f) {
		if(is_dir("$path/$f"))
			rmdir_rec("$path/$f");
		else
			unlink("$path/$f");
	}
	rmdir($path);
}
?>
