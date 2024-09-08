<?
$rating = $_GET['number'];
$limit = intval($_GET['limit']);
$ratings = $rating;
if($rating>=100)
{
$ratings = 99;
}
if($rating>100)
{
$rating = 100;
}
if($limit=="")
{
$limit = 50;
}
if($limit>100)
{
$limit = 100;
}
header("Content-type: image/gif");
$im = imageCreateFromGif("../images/rating.gif");
$color = imagecolorallocate($im, 234, 237, 237);
$color2 = imagecolorallocate($im, 227, 222, 222);
$color3 = imagecolorallocate($im, 204, 200, 200);
$color4 = imagecolorallocate($im, 185, 181, 181);
$color5 = imagecolorallocate($im, 197, 195, 195);
imagefilledrectangle ($im, 2, 1, 99, 2, $color);
imagefilledrectangle ($im, 1, 3, 100, 4, $color2);
imagefilledrectangle ($im, 1, 5, 100, 6, $color3);
imagefilledrectangle ($im, 1, 7, 100, 8, $color4);
imagefilledrectangle ($im, 2, 9, 99, 10, $color5);
$color = imagecolorallocate($im, 255, 204, 204);
$color2 = imagecolorallocate($im, 255, 153, 153);
$color3 = imagecolorallocate($im, 255, 102, 102);
$color4 = imagecolorallocate($im, 255, 51, 51);
$color5 = imagecolorallocate($im, 255, 102, 102);
$color6 = imagecolorallocate($im, 0, 0, 0);
if($rating>0)
{
imagefilledrectangle ($im, 2, 1, $ratings, 2, $color);
imagefilledrectangle ($im, 1, 3, $rating, 4, $color2);
imagefilledrectangle ($im, 1, 5, $rating, 6, $color3);
imagefilledrectangle ($im, 1, 7, $rating, 8, $color4);
imagefilledrectangle ($im, 2, 9, $ratings, 10, $color5);
}
ImageString($im, 1, 70, 2, "$rating%", $color6);
ImageGIF($im);
?>