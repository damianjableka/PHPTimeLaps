
<?php

$nazwa_pliku1="IMG_2403.jpg";
$nazwa_pliku2="IMG_2473.jpg";
$exif=exif_read_data($nazwa_pliku1,"FILE");
var_dump($exif);
echo "<br>";

$im = imagecreatefromjpeg($nazwa_pliku1);
$im2= imagecreatefromjpeg($nazwa_pliku2);
// zakladamy narazie ze mysle i ze rozmiar obu jest taki sam pozniej w tym mijescu trzba dodac jakis if gdyby tak nie bylo
$rozmiar = getimagesize($nazwa_pliku1);


$wynik = imagecreatetruecolor($rozmiar[0], $rozmiar[1]);


var_dump($rozmiar);
echo "<br>";
for($x=0;$x<$rozmiar[0];$x++)
 for($y=0;$y<$rozmiar[1];$y++)
  {
   
  $rgb1 = imagecolorat($im, $x, $y);
  $colors1 = imagecolorsforindex($im, $rgb1);
  
  
  $rgb2 = imagecolorat($im2, $x, $y);
  $colors2 = imagecolorsforindex($im2, $rgb2);
  
  
  $suma1 = $colors1["red"]+$colors1["green"]+$colors1["blue"];
  $suma2 = $colors2["red"]+$colors1["green"]+$colors1["blue"];
   
   if($suma1>=$suma2)
     {
	 $kolor=imagecolorallocate($wynik, $colors1["red"],$colors1["green"],$colors1["blue"]);
	 }
     else
	 {
	 $kolor=imagecolorallocate($wynik, $colors2["red"],$colors2["green"],$colors2["blue"]);
	 }
   imagesetpixel($wynik, $x,$y, $kolor);
   
  //var_dump($suma);
  //echo " ";
  }
  //header('Content-Type: image/jpeg');

// Output the image
imagejpeg($wynik,'simpletext.jpg',100);

// Free up memory
imagedestroy($wynik);
?>
