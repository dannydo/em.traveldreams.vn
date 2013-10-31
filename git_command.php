<?php
$path = "/home/web";
$date = date('y-m-d');
$github = "https://github.com/dannydo/em.traveldreams.vn.git";

// check out
$status = exec("cd ".$path.'/sites/staging.em.traveldreams.vn/'." \n git diff");
if($status) {
	// remove folder.
	exec("rm -rf ". $path.'/respo/em.traveldreams.vn/'.$date);

	exec("cd ".$path.'/respo/em.traveldreams.vn/'." \n git clone ".$github. " ".$path.'/respo/em.traveldreams.vn/'.$date);	

	//add to stagign
	exec("rm rf ".$path.'/sites/staging.em.traveldreams.vn');
	exec("cd ".$path.'/sites/'." \n ln -s ".$path.'/respo/em.traveldreams.vn/'.$date." staging.em.traveldreams.vn");
}