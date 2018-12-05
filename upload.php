<?php

if(!isset($_SESSION))
	session_start();
require_once 'core/init.php';

$pdo = DB::getconnection();

if(isset($_POST["images"]))
{
	$all = json_decode($_POST["images"]);

	$full_thing = imagecreatetruecolor(500, 375);
	imagealphablending($full_thing, true);
	imagesavealpha($full_thing,true);
	
	$full_h = imagesx($full_thing);
	$full_w = imagesy($full_thing);
	$original = $full_w/$full_h;

	$fail = false;

	foreach($all as $key => $value)
	{
		$data = explode(",", $value, 2);
		$new = base64_decode($data[1]);
		$img = imagecreatefromstring($new);

		if ($img !== false)
		{
			imagealphablending($img, true);
			imagesavealpha($img, true);
			$h = imagesx($img);
			$w = imagesy($img);
			if($w/$h > $original)
				$w = $h*$original;
			else
				$h = $w/$original;
			$img = imagescale($img, $fw, -1);
			imagecopy($full_thing, $img, 0, 0, 0, 0, $w, imagesy($img));
		}
		else
			$fail;
	}
	try{

	}
	catch(\PDOException $e){
		echo $e->getMessage;
	}
}
else{
	echo "Failure: Invalid method or file";
}

$arr =  json_decode($_POST["images"]);
$arr = str
foreach ($arr as $key => $value)
	echo $key."\n";
/*
$imagename=$_FILES["myimage"]["name"];

//Get the content of the image and then add slashes to it 
$imagetmp=addslashes (file_get_contents($_FILES['myimage']['tmp_name']));

//Insert the image name and image content in image_table
$insert_image="INSERT INTO image_table VALUES('$imagetmp','$imagename')";

mysql_query($insert_image); */

?>