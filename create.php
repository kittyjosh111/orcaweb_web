<?php
$process_count = shell_exec('ps -e o pid,ppid,pgid,cmd | grep "orca " | grep -v grep | wc -l');
  if(!empty($_FILES['uploaded_file']))
  {
    $nonce = md5(time());
    $dir = "/var/www/orcaweb_files/$nonce/";
    mkdir($dir, 0777, true);
    $path = $dir . basename( $_FILES['uploaded_file']['name']);
    $email = $_POST['email'];
    if($email && move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
        $myfile = fopen($dir."pending", "w") or die("Unable to open file!");
        fwrite($myfile, "pending");
        fclose($myfile);
        $myfile = fopen($dir."request_email", "w") or die("Unable to open file!");
        fwrite($myfile, "$email");
	fclose($myfile);
        $myfile = fopen($dir."inp_filename", "w") or die("Unable to open file!");
	fwrite($myfile, $_FILES['uploaded_file']['name']);
	fclose($myfile);
        header("Location: status.php?q=".urlencode($nonce)."&e=".urlencode($email));
        exit(); 
    } else{
        echo "There was an error uploading the file, please try again!";
    }
  }
?><html>
<head>
  <title>Upload your orca input file</title>
</head>
<body>
  <h1>Upload your orca input file, provide a valid email address</h1>
  <h2<?php if ($process_count>=3) echo " style=\"color:Tomato;\""; ?>>Running orca process count: <?php echo $process_count; ?></h2>
  <form enctype="multipart/form-data" action="create.php" method="POST">
    <h2>Upload your orca input file</h2>
    <p>Your email address (orca result will be emailed to you):
        <input type="text" size="30" id="email" name="email">
    </p>
    <p>Input file for orca:
        <input type="file" name="uploaded_file"></input><br />
    </p>
    <input type="submit" value="Upload"></input>
  </form>
</body>
</html>
