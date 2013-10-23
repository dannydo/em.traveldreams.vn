<?php
$path = "/home/web/sites/em.traveldreams.vn";

$content = exec("cd ".$path." \n git pull origin master");
if($content) {
	echo "Update finished";
} else {
	echo "No change";
}