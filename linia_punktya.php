
<?php

function imageBoldLine($resource, $x1, $y1, $x2, $y2, $ra, $ga, $ba, $alphaa, $BoldNess, $func='imageSmoothAlphaLine')
{

    $dcol = imagecolorallocatealpha($resource, $ra, $ga, $ba,$alphaa);
    imagesetthickness($resource, $BoldNess);
    imageline($resource, $x1, $y1, $x2, $y2, $dcol);


} 

function imageGlowLines($resourceG, $x1G, $y1G, $x2G, $y2G, $raG, $gaG, $baG, $alphaaG, $BoldNessG=2, $funcG='imageSmoothAlphaLine', $funcBold='imageBoldLine')
{
$funcBold($resourceG, $x1G, $y1G, $x2G , $y2G, $raG, $gaG, $baG, $alphaaG+12, $BoldNessG+10,$funcG);
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
$fragment=15; //maksymalna dlugosc rysowana w jednym kroku
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
	 
	  
	  
	 imageGlowLines($wynik,$poczatekx,$poczateky,$poczatekx+$Nx,$poczateky+$Ny,10,245,255,100,8,"imageSmoothAlphaLine","imageBoldLine");
	
	
	
	
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
