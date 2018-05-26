
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

function imageBoldLine($resource, $x1, $y1, $x2, $y2, $ra, $ga, $ba, $alphaa, $BoldNess, $func='imageSmoothAlphaLine')
{
global $rozmiar;

 /*    $polgrubosc=round($BoldNess/2);
     $dtx=$x2-$x1;
	 $dty=$y2-$y1;
	// $lt=sqrt(pow($dtx,2)+pow($dty,2));
	 $tt=$dty/$dtx;
	 
	 
	 	 $znaktx=1;
	  if($dtx<0)
	   $znaktx=-1;
	 
	 $znakty=1;
	  if($dty<0)
	   $znakty=-1;
	 
	 
     $Nty=round($znakty*abs($polgrubosc/sqrt(pow($tt,2)+1)),0);
     $Ntx=round($znaktx*abs($tt*$Nty),0); 
	 printf("$Ntx $Nty <br>");
//	 imagesetthickness($resource, $BoldNess);
 //    $func($resource, $x1 +$Ntx, $y1+$Nty, $x2 +$Ntx, $y2+$Nty, $ra, $ga, $ba, $alphaa);
$x1+=$Ntx;
$y1+=$Nty;
$x2+=$Ntx; 
$y2+=$Nty;

$x1=(($x1>$rozmiar[0])?$rozmiar[0]:$x1);
$x2=(($x2>$rozmiar[0])?$rozmiar[0]:$x2);
$y1=(($y1>$rozmiar[1])?$rozmiar[1]:$y1);
$y2=(($y2>$rozmiar[1])?$rozmiar[1]:$y2);


$x1=round((($x1<0)?0:$x1),0);
$x2=round((($x2<0)?0:$x2),0);
$y1=round((($y1<0)?0:$y1),0);
$y2=round((($y2<0)?0:$y2),0);
*/
    $dcol = imagecolorallocatealpha($resource, $ra, $ga, $ba,$alphaa);
    imagesetthickness($resource, $BoldNess);
    imageline($resource, $x1, $y1, $x2, $y2, $dcol);



/*$center = round($BoldNess/2);
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
} */     
} 

function imageGlowLines($resourceG, $x1G, $y1G, $x2G, $y2G, $raG, $gaG, $baG, $alphaaG, $BoldNessG=2, $funcG='imageSmoothAlphaLine', $funcBold='imageBoldLine')
{
$funcBold($resourceG, $x1G, $y1G, $x2G , $y2G, $raG, $gaG, $baG, $alphaaG+12, $BoldNessG+6,$funcG);
$funcBold($resourceG, $x1G, $y1G, $x2G , $y2G, $raG, $gaG, $baG, $alphaaG+6, $BoldNessG+6,$funcG);
$funcBold($resourceG, $x1G, $y1G, $x2G , $y2G, $raG, $gaG, $baG, $alphaaG, $BoldNessG,$funcG);

}


$linie=array();
$czas= array();
$obr1=array();


$punkty=array(array(array(1998,402),array(2194,393),array(2422,332),array(2610,138),array(2674,0)),
array(array(2610,138),array(2741,202),array(2864,0)),
array(array(1216,1347),array(1249,1575),array(1411,1638),array(1421,1864),array(1652,1807)));


$ilosc_ciaglych=count($punkty);
$apertura=9;

  $tp=time();
  $plik="IMG_6050.JPG";
  $rozmiar = getimagesize($plik);
  $out_folder="out_l/";
$prefix="linia_";
$rozszerzenie=".jpg";
    $wynik = imagecreatetruecolor($rozmiar[0], $rozmiar[1]);
  
  
    $im = imagecreatefromjpeg($plik);
$fragment=10; //maksymalna dlugosc rysowana w jednym kroku
$plk=0;
$r=0;
$incdec=1;
for($s=0;$s<$ilosc_ciaglych;$s++)
	{
	$ilosc_gwiazd=count($punkty[$s]);
  for($u=1;$u<$ilosc_gwiazd;$u++)
   {
     $dx=$punkty[$s][$u][0]-$punkty[$s][$u-1][0];
	 $dy=$punkty[$s][$u][1]-$punkty[$s][$u-1][1];
	 
	 
	 
	 $l=sqrt(pow($dx,2)+pow($dy,2));
	 $t=$dx/$dy;
	 if($plk>0)
	  {
	   $f=$plk-1;
	   $outputfile=$out_folder.$prefix.$f.$rozszerzenie;
	   $im = imagecreatefromjpeg($outputfile);
	  }
	 $lb=$apertura;
	 
	 
	 $znakx=1;
	  if($dx<0)
	   $znakx=-1;
	 
	 $znaky=1;
	  if($dy<0)
	   $znaky=-1;
	   
	  $poczateky=$znaky*abs($lb/sqrt(pow($t,2)+1));
      $poczatekx=$znakx*abs($t*$poczateky)+$punkty[$s][$u-1][0]; 
	  $poczateky+=$punkty[$s][$u-1][1];
	   
	   
	 while($l>($lb+2*$apertura))
	 {
	  
	  imagecopy ( $wynik , $im,0,0,0,0,$rozmiar[0], $rozmiar[1]);
	  $lb+=$fragment;
	  if($lb+2*$apertura>$l)
	   $lb=$l-2*$apertura;
	   
	  $Ny=$znaky*abs($lb/sqrt(pow($t,2)+1));
      $Nx=$znakx*abs($t*$Ny); 
	 
	  
	  
	 imageGlowLines($wynik,$poczatekx,$poczateky,$poczatekx+$Nx,$poczateky+$Ny,0,0,255,100,6,"imageSmoothAlphaLine","imageBoldLine");
	
	
	
	
$outputfile=$out_folder.$prefix.$plk.$rozszerzenie;
$plk++;
imagejpeg($wynik,$outputfile,100);
printf("%s<br>",$outputfile);



$tk=time();
$czas[$plk]=$tk-$tp;
printf("zajelo: %d<br>",$tk-$tp);

 ob_flush();
 flush();
      }
	  }
 }
ob_end_flush();
// Free up memory
 imagedestroy($wynik);
 imagedestroy($im); 
?>
