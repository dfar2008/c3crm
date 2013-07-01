<?php
/**
added by peter zheng on 2007-05-05 for ecustomer
**/
header("Content-type: image/png");
session_start();
//session_register('code');
$width = "70";//图片宽
$height = "25";//图片高
$len = "4";//生成几位验证码
$bgcolor = "#ffffff";//背景色
$noise = true;//生成杂点
$noisenum = 300;//杂点数量
$border = false;//边框
$bordercolor = "#000000";
$image = imagecreatetruecolor($width, $height);
$back = getcolor($bgcolor);
imageFilledRectangle($image, 0, 0, $width, $height, $back);
$size = $width/$len;
if($size>$height) $size=$height;
$left = ($width-$len*($size+$size/10))/$size;
$array = $_REQUEST['authnum'];
if(strlen($array)==7)
{$randtext	= explode("," ,$array);
}

for ($i=0; $i<$len; $i++)
{	 
	$textColor = imageColorAllocate($image, 50, 50, 50);
	$font = 'include/fonts/1.ttf'; 
	$randsize = 20;
	$location = $left+($i*$size+$size/10);
	imagettftext($image, $randsize, rand(-18,18), $location, rand($size-$size/10, $size+$size/10), $textColor, $font, $randtext[$i]); 
}

//if($noise == true) setnoise();
//$_SESSION['code'] = $code;
$bordercolor = getcolor($bordercolor); 

if($border==true) imageRectangle($image, 0, 0, $width-1, $height-1, $bordercolor);

//header("Content-type: image/png");
imagePng($image);
imagedestroy($image);
function getcolor($color)
{
     global $image;
     $color = ereg_replace("^#","",$color);
     $r = $color[0].$color[1];
     $r = hexdec ($r);
     $b = $color[2].$color[3];
     $b = hexdec ($b);
     $g = $color[4].$color[5];
     $g = hexdec ($g);
     $color = imagecolorallocate ($image, $r, $b, $g); 
     return $color;
}
function setnoise()
{
	global $image, $width, $height, $back, $noisenum;
	for ($i=0; $i<$noisenum; $i++){
		$randColor = imageColorAllocate($image, rand(0, 255), rand(0, 255), rand(0, 255));  
		imageSetPixel($image, rand(0, $width), rand(0, $height), $randColor);
	} 
}
?> 