<?php
$path = "/home/web";
$date = date('y-m-d');
$github = "https://github.com/dannydo/em.traveldreams.vn.git";

// remove folder.
exec("rm -rf " $path.'/respo/em.traveldreams.vn/'.$date);

// check out
$status = exec("cd ".$path.'/respo/em.traveldreams.vn/'." \n git status");
if($status) {
	exec("cd ".$path.'/respo/em.traveldreams.vn/'." \n git clone ".$github);	

	//add to stagign
	exec("rm rf ".$path.'/sites/staging.em.traveldreams.vn');
	exec("cd ".$path.'/sites/'." \n ln -s ".$path.'/respo/em.traveldreams.vn/'.$date." staging.em.traveldreams.vn");
}