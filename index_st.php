
<?php
$inp_folder="img/";
$out_folder="out/";
$prefix="rosast_";
$rozszerzenie=".jpg";
$antyszum=1;
$zawartosc= array_diff_assoc(scandir($inp_folder), array('..', '.'));
$zawartosc_dl=count($zawartosc);
$czas= array();
for($plik=2;$plik<($zawartosc_dl-1);$plik++)
 {
  $tp=time();
  if($plik==2)
   {
    $im = imagecreatefromjpeg($inp_folder.$zawartosc[$plik]);
    } 
   else
   {
    $im = imagecreatefromjpeg($out_folder.$prefix.($plik-1).$rozszerzenie);
	}
   $im2= imagecreatefromjpeg($inp_folder.$zawartosc[$plik+1]);
   
// zakladamy narazie ze mysle i ze rozmiar obu jest taki sam pozniej w tym mijescu trzba dodac jakis if gdyby tak nie bylo
$rozmiar = getimagesize($inp_folder.$zawartosc[$plik]);
printf("<br>%s<br>",$inp_folder.$zawartosc[$plik+1]);

$wynik = imagecreatetruecolor($rozmiar[0], $rozmiar[1]);
$obr1=array();
$obr2=array();
for($x=0;$x<$rozmiar[0];$x++)
 for($y=0;$y<$rozmiar[1];$y++)
  {
   $rgb1 = imagecolorat($im, $x, $y);
   $colors1 = imagecolorsforindex($im, $rgb1);
   $rgb2 = imagecolorat($im2, $x, $y);
   $colors2 = imagecolorsforindex($im2, $rgb2);
   $obr2[$x][$y] = $colors2["red"]+$colors1["green"]+$colors1["blue"];
   $obr1[$x][$y] = $colors1["red"]+$colors1["green"]+$colors1["blue"];
  }



for($x=0;$x<$rozmiar[0];$x++)
 for($y=0;$y<$rozmiar[1];$y++)
  {
   $suma1=$obr1[$x][$y];
   $suma2=$obr2[$x][$y];

   if($antyszum)
    {
	 $matryca=array();
     $srednie=0;
     $odchylenia=0;
	 if($x>0&&$x<($rozmiar[0]-1)&&$y>0&&$y<($rozmiar[1]-1))
	 {
	  $kl=0;
	  for($xs=$x-1;$xs<=$x+1;$xs++)
	   for($ys=$y-1;$ys<=$y+1;$ys++)
	    if($xs!=$x||$ys!=$y)
		{
		 $matryca[$kl]=$obr2[$x][$y];
		 $srednie+=($matryca[$kl])/8;
		 $kl++;
		}
		
        for($a=0;$a<8;$a++)
		{
		 $odchylenia+=pow(($matryca[$a]-$srednie),2)/8;
		}
		$std=sqrt($odchylenia);
		
	 }
	 else
	 {
	 $srednie=0;
     $std=0;
	 }
	   if(($suma2-$srednie)>3*$std)
     {
      $suma2=0;
     }
   }


  
   
   if($suma1>=$suma2)
     {
	 $rgb1 = imagecolorat($im, $x, $y);
     $colors1 = imagecolorsforindex($im, $rgb1);
	 $kolor=imagecolorallocate($wynik, $colors1["red"],$colors1["green"],$colors1["blue"]);
	 }
     else
	 {
	 $rgb2 = imagecolorat($im2, $x, $y);
	 $colors2 = imagecolorsforindex($im2, $rgb2);
	 $kolor=imagecolorallocate($wynik, $colors2["red"],$colors2["green"],$colors2["blue"]);
	 }
   imagesetpixel($wynik, $x,$y, $kolor);
   
  }
  //header('Content-Type: image/jpeg');

// Output the image
$outputfile=$out_folder.$prefix.$plik.$rozszerzenie;
imagejpeg($wynik,$outputfile,100);
printf("%s<br>",$outputfile);
// Free up memory
imagedestroy($im);
imagedestroy($im2);
imagedestroy($wynik);
$tk=time();
$czas[$plik]=$tk-$tp;
printf("zajelo: %d<br>",$tk-$tp);
$czas_sr=0;
for($k=2;$k<$plik+1;$k++)
 $czas_sr+=$czas[$k]/($plik-1);
printf("pozostalo %s <br><br>",gmdate("H:i:s", $czas_sr*($zawartosc_dl-$plik-2)));
 ob_flush();
 flush();
 
}
ob_end_flush(); 
?>
