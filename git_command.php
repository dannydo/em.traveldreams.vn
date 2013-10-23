<?php
$path = "/home/web/sites/em.traveldreams.vn";

$content = exec("cd ".$path." \n git pull origin master");
if($content) {
	echo "Update finished\n";
} else {
	echo "No change\n";
}