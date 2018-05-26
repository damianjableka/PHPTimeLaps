
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
global $rozmiar;

     $polgrubosc=round($BoldNess/2);
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


$x1=(($x1<0)?0:$x1);
$x2=(($x2<0)?0:$x2);
$y1=(($y1<0)?0:$y1);
$y2=(($y2<0)?0:$y2);


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
$funcBold($resourceG, $x1G, $y1G, $x2G , $y2G, $raG, $gaG, $baG, $alphaaG+4, $BoldNessG+6,$funcG);
$funcBold($resourceG, $x1G, $y1G, $x2G , $y2G, $raG, $gaG, $baG, $alphaaG, $BoldNessG,$funcG);

}


$linie=array();
$czas= array();
$obr1=array();


#$linie[0]=array("x1"=>473,"y1"=>43,"x2"=>516,"y2"=>74);
#$linie[1]=array("x1"=>523,"y1"=>80,"x2"=>581,"y2"=>106);
#$linie[2]=array("x1"=>589,"y1"=>109,"x2"=>655,"y2"=>100);
#$linie[3]=array("x1"=>662,"y1"=>103,"x2"=>676,"y2"=>133);
#$linie[4]=array("x1"=>683,"y1"=>136,"x2"=>753,"y2"=>103);
#$linie[5]=array("x1"=>756,"y1"=>95,"x2"=>732,"y2"=>64);
#$linie[6]=array("x1"=>724,"y1"=>60,"x2"=>665,"y2"=>96);


$linie[0]=array("x1"=>2007,"y1"=>400,"x2"=>2187,"y2"=>394);
$linie[1]=array("x1"=>2199,"y1"=>392,"x2"=>2420,"y2"=>334);
$linie[2]=array("x1"=>2426,"y1"=>328,"x2"=>2607,"y2"=>143);
$linie[3]=array("x1"=>2615,"y1"=>135,"x2"=>2690,"y2"=>1);
$linie[4]=array("x1"=>2615,"y1"=>142,"x2"=>2730,"y2"=>200);
$linie[5]=array("x1"=>2744,"y1"=>200,"x2"=>2819,"y2"=>1);

$linie[6]=array("x1"=>1216,"y1"=>1352,"x2"=>1248,"y2"=>1570);
$linie[7]=array("x1"=>1255,"y1"=>1578,"x2"=>1406,"y2"=>1636);
$linie[8]=array("x1"=>1411,"y1"=>1643,"x2"=>1420,"y2"=>1861);
$linie[9]=array("x1"=>1427,"y1"=>1865,"x2"=>1647,"y2"=>1812);

$ilosc_linii=count($linie);


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
for($s=0;$s<$ilosc_linii;$s++)
	{
     $dx=$linie[$s]["x2"]-$linie[$s]["x1"];
	 $dy=$linie[$s]["y2"]-$linie[$s]["y1"];
	 $l=sqrt(pow($dx,2)+pow($dy,2));
	 $t=$dx/$dy;
	 if($plk>0)
	  {
	   $f=$plk-1;
	   $outputfile=$out_folder.$prefix.$f.$rozszerzenie;
	   $im = imagecreatefromjpeg($outputfile);
	  }
	 $lb=0;
	 
	 
	 $znakx=1;
	  if($dx<0)
	   $znakx=-1;
	 
	 $znaky=1;
	  if($dy<0)
	   $znaky=-1;
	   
	 while($l>$lb)
	 {
	  
	  imagecopy ( $wynik , $im,0,0,0,0,$rozmiar[0], $rozmiar[1]);
	  $lb+=$fragment;
	  if($lb>$l)
	   $lb=$l;
	   
	  $Ny=$znaky*abs($lb/sqrt(pow($t,2)+1));
      $Nx=$znakx*abs($t*$Ny); 
	 imageBoldLine($wynik,$linie[$s]["x1"],$linie[$s]["y1"],$linie[$s]["x1"]+$Nx,$linie[$s]["y1"]+$Ny,0,0,255,110,8,"imageSmoothAlphaLine","imageBoldLine");
	 /*$color=imagecolorallocatealpha($wynik, 255, 255, 255, 227);
     imageellipse ( $wynik , 471 , 42 , $r, $r ,  $color );
	 imageellipse ( $wynik , 471 , 42 , $r+1, $r+1 ,  $color );
	 imageellipse ( $wynik , 471 , 42 , $r+2, $r+2 ,  $color );
     $r=$r+$incdec;
	 if($r>10)
	  $incdec=-1;
     if($r<1)
	  $incdec=1;
*/
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
ob_end_flush();
// Free up memory
 imagedestroy($wynik);
 imagedestroy($im); 
?>
