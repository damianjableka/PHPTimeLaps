
<?php
$inp_folder="img/";
$out_folder="out/";
$prefix="rosaspw_";
$rozszerzenie=".jpg";
$antyszum=1;
$zawartosc= array_diff_assoc(scandir($inp_folder), array('..', '.'));
$zawartosc_dl=count($zawartosc);
$czas= array();
$im = imagecreatefromjpeg($inp_folder.$zawartosc[2]);
for($plik=2;$plik<($zawartosc_dl-1);$plik++)
 {
  $tp=time();
  if($plik==2)
   {
    $im = imagecreatefromjpeg($inp_folder.$zawartosc[$plik]);
    } 
   //else
  // {
  //  $im = imagecreatefromjpeg($out_folder.$prefix.($plik-1).$rozszerzenie);
	//}
   $im2= imagecreatefromjpeg($inp_folder.$zawartosc[$plik+1]);
   
// zakladamy narazie ze mysle i ze rozmiar obu jest taki sam pozniej w tym mijescu trzba dodac jakis if gdyby tak nie bylo
$rozmiar = getimagesize($inp_folder.$zawartosc[$plik]);
printf("<br>%s<br>",$inp_folder.$zawartosc[$plik+1]);

$wynik = imagecreatetruecolor($rozmiar[0], $rozmiar[1]);

for($x=0;$x<$rozmiar[0];$x++)
 for($y=0;$y<$rozmiar[1];$y++)
  {
  
  $rgb1 = imagecolorat($im, $x, $y);
  $colors1 = imagecolorsforindex($im, $rgb1);
  
    
  $rgb2 = imagecolorat($im2, $x, $y);
  $colors2 = imagecolorsforindex($im2, $rgb2);
     
  $suma2 = $colors2["red"]+$colors1["green"]+$colors1["blue"];
	
	
  $suma1 = $colors1["red"]+$colors1["green"]+$colors1["blue"];

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
		 $rgb = imagecolorat($im2, $xs, $ys);
         $colors= imagecolorsforindex($im2, $rgb);
		 $matryca[$kl]=$colors["red"]+$colors["green"]+$colors["blue"];
		 $srednie+=($matryca[$kl]);
		 $kl++;
		}
		
        for($a=0;$a<8;$a++)
		{
		 $odchylenia+=pow(($matryca[$a]-$srednie/8),2);
		}
		
		
	 }
	 else
	 {
	 $srednie=0;
     $std=0;
	 }
	   if(8*pow(($suma2-$srednie/8),2)>3*$odchylenia)
     {
      $suma2=0;
     }
   }


  
   
   if($suma1>=$suma2)
     {
	 $kolor=imagecolorallocate($wynik, $colors1["red"],$colors1["green"],$colors1["blue"]);
	 }
     else
	 {
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
//imagedestroy($im);
$im=$wynik;
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
