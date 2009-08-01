<?php
function getcode($length){
    $chars="23456789ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz";
    for($i=0;$i<$length;$i++){
        $code.=$chars[rand(0,61)];
    }
    return $code;
}
session_start();
$checkcode=getcode(4);
$_SESSION['verify']=strtolower($checkcode);
$im = imagecreate(50, 20);
$bg = imagecolorallocate($im,150, 150, 150);
$textcolor = imagecolorallocate($im, 0, 0, 0);
imagestring($im, 5, 8, 2, $checkcode, $textcolor);
header("Content-type: image/png");
imagepng($im);
?>

