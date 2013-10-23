<?php
$path = "/home/web/sites/em.traveldreams.vn";

$content = exec("cd ".$path." \n git status");
if($content) {
	exec("rm ".$path);
	exec("cd ".$path." \n git clone https://github.com/dannydo/em.traveldreams.vn.git");
	echo "Update finished";
} else {
	echo "No change";
}