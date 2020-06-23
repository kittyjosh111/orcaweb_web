<?php
$nonce = $_GET['q'];
$e = $_GET['e'];
function error($message=null) {
	if ($message == null) {
		echo "Error! Please check your URL";
	} else {
		echo $message;
	}
	exit();
}
function read_file_content($filename) {
        $myfile = fopen($filename, "r") or die("Unable to open file!");
        $content = fread($myfile,filesize($filename));
        fclose($myfile);
	return $content;
}
if (!$nonce || !$e) {
	error();
}
$dir = "/var/www/orcaweb_files/$nonce/";
// check if dir exists
if (file_exists($dir."inp_filename") && file_exists($dir."request_email")) {
	$email = read_file_content($dir."request_email");
	if ($email != $e) {
		error("Email not authorized");
	}
	if (file_exists($dir."pending")) {
		echo("Your orca will be processed within a minute. Please Wait...");
	} else {
		$inp_filename = read_file_content($dir."inp_filename");
		$out_filename = $inp_filename.".out";
		if (file_exists($dir.$out_filename)) {
			$out = read_file_content($dir.$out_filename);
			//$out_html = str_replace("\n", "<br/>", $out);
			$out_html = "<pre>$out</pre>";
			echo $out_html;
			if (file_exists($dir."completed")) {
				exit();
			}
		} else {
			echo("Your orca will be processed within a minute. Please Wait...");
		}

	}
} else {
	error();
}
?><script>setTimeout(function() {
  location.reload();
}, 30000);</script>
