<?php
require_once 'core/init.php';

if(isset($_POST["images"]))
{
	$all = json_decode($_POST["images"]);

	$full_thing = imagecreatetruecolor(500, 375);
	imagealphablending($full_thing, true);
	imagesavealpha($full_thing,true);
	$full_h = imagesx($full_thing);
	$full_w = imagesy($full_thing);

}

// load the frame image (png with 8-bit transparency) 
$frame = imagecreatefrompng('path/to/frame.png'); 

// load the thumbnail image 
$thumb = imagecreatefromjpeg('path/to/thumbnail.jpg'); 

// get the dimensions of the frame, which we'll also be using for the 
// composited final image. 
$width = imagesx( $frame ); 
$height = imagesy( $frame ); 

// create the destination/output image. 
$img=imagecreatetruecolor( $width, $height ); 

// enable alpha blending on the destination image. 
imagealphablending($img, true); 

// Allocate a transparent color and fill the new image with it. 
// Without this the image will have a black background instead of being transparent. 
$transparent = imagecolorallocatealpha( $img, 0, 0, 0, 127 ); 
imagefill( $img, 0, 0, $transparent ); 

// copy the thumbnail into the output image. 
imagecopyresampled($img,$thumb,32,30,0,0, 130, 100, imagesx( $thumb ), imagesy( $thumb ) ); 

// copy the frame into the output image (layered on top of the thumbnail) 
imagecopyresampled($img,$frame,0,0,0,0, $width,$height,$width,$height); 

imagealphablending($img, false); 

// save the alpha 
imagesavealpha($img,true); 

// emit the image 
header('Content-type: image/png'); 
imagepng( $img ); 

// dispose 
imagedestroy($img); 

// done. 
exit;

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