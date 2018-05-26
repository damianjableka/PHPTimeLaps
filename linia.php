
<?php

function imageSmoothAlphaLine ($image, $x1, $y1, $x2, $y2, $r, $g, $b, $alpha) {
  $icr = $r;
  $icg = $g;
  $icb = $b;
  $dcol = imagecolorallocatealpha($image, $icr, $icg, $icb, $alpha);
 
  if ($y1 == $y2 || $x1 == $x2)
    imageline($image, $x1, $y2, $x1, $y2, $dcol);
  else {
    $m = ($y2 - $y1) / ($x2 - $x1);
    $b = $y1 - $m * $x1;

    if (abs ($m) <2) {
      $x = min($x1, $x2);
      $endx = max($x1, $x2) + 1;

      while ($x < $endx) {
        $y = $m * $x + $b;
        $ya = ($y == floor($y) ? 1: $y - floor($y));
        $yb = ceil($y) - $y;
  
        $trgb = ImageColorAt($image, $x, floor($y));
        $tcr = ($trgb >> 16) & 0xFF;
        $tcg = ($trgb >> 8) & 0xFF;
        $tcb = $trgb & 0xFF;
        imagesetpixel($image, $x, floor($y), imagecolorallocatealpha($image, ($tcr * $ya + $icr * $yb), ($tcg * $ya + $icg * $yb), ($tcb * $ya + $icb * $yb), $alpha));
 
        $trgb = ImageColorAt($image, $x, ceil($y));
        $tcr = ($trgb >> 16) & 0xFF;
        $tcg = ($trgb >> 8) & 0xFF;
        $tcb = $trgb & 0xFF;
        imagesetpixel($image, $x, ceil($y), imagecolorallocatealpha($image, ($tcr * $yb + $icr * $ya), ($tcg * $yb + $icg * $ya), ($tcb * $yb + $icb * $ya), $alpha));
 
        $x++;
      }
    } else {
      $y = min($y1, $y2);
      $endy = max($y1, $y2) + 1;

      while ($y < $endy) {
        $x = ($y - $b) / $m;
        $xa = ($x == floor($x) ? 1: $x - floor($x));
        $xb = ceil($x) - $x;
 
        $trgb = ImageColorAt($image, floor($x), $y);
        $tcr = ($trgb >> 16) & 0xFF;
        $tcg = ($trgb >> 8) & 0xFF;
        $tcb = $trgb & 0xFF;
        imagesetpixel($image, floor($x), $y, imagecolorallocatealpha($image, ($tcr * $xa + $icr * $xb), ($tcg * $xa + $icg * $xb), ($tcb * $xa + $icb * $xb), $alpha));
 
        $trgb = ImageColorAt($image, ceil($x), $y);
        $tcr = ($trgb >> 16) & 0xFF;
        $tcg = ($trgb >> 8) & 0xFF;
        $tcb = $trgb & 0xFF;
        imagesetpixel ($image, ceil($x), $y, imagecolorallocatealpha($image, ($tcr * $xb + $icr * $xa), ($tcg * $xb + $icg * $xa), ($tcb * $xb + $icb * $xa), $alpha));
 
        $y ++;
      }
    }
  }
} // end of 'imageSmoothAlphaLine()' function

function imageBoldLine($resource, $x1, $y1, $x2, $y2, $ra, $ga, $ba, $alphaa, $BoldNess=2, $func='imageSmoothAlphaLine')
{
$center = round($BoldNess/2);
for($i=0;$i<$BoldNess;$i++)
{ 
  $a = $center-$i; if($a<0){$a -= $a;}
  for($j=0;$j<$BoldNess;$j++)
  {
   $b = $center-$j; if($b<0){$b -= $b;}
   $c = sqrt($a*$a + $b*$b);
   if($c<=$BoldNess)
   {
    $func($resource, $x1 +$i, $y1+$j, $x2 +$i, $y2+$j, $ra, $ga, $ba, $alphaa);
   }
  }
}        
} 

function imageGlowLines($resourceG, $x1G, $y1G, $x2G, $y2G, $raG, $gaG, $baG, $alphaaG, $BoldNessG=2, $funcG='imageSmoothAlphaLine', $funcBold='imageBoldLine')
{
$funcBold($resourceG, $x1G, $y1G, $x2G , $y2G, $raG, $gaG, $baG, $alphaaG+4, $BoldNessG+2,$funcG);
$funcBold($resourceG, $x1G, $y1G, $x2G , $y2G, $raG, $gaG, $baG, $alphaaG, $BoldNessG,$funcG);

}

$czas= array();
$obr1=array();

  $tp=time();
  $plik="IMG_6050.JPG";
  $rozmiar = getimagesize($plik);

$wynik = imagecreatetruecolor($rozmiar[0], $rozmiar[1]);
  
  
    $im = imagecreatefromjpeg($plik);
	
imageBoldLine($im,1215,1357,1241,1558,0,0,255,122,8,"imageSmoothAlphaLine","imageBoldLine");
$outputfile="linia_".$plik;
imagejpeg($im,$outputfile,100);
printf("%s<br>",$outputfile);
// Free up memory
 imagedestroy($im);

$tk=time();
$czas[$plik]=$tk-$tp;
printf("zajelo: %d<br>",$tk-$tp);

 ob_flush();
 flush();
 

?>
