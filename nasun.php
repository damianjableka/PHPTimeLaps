
<?php
$inp_folder="z/";
$out_folder="out_n/";
$prefix="nas_";
$rozszerzenie=".jpg";
$antyszum=1;
$zawartosc= array_diff_assoc(scandir($inp_folder), array('..', '.'));
$zawartosc_dl=count($zawartosc);
$czas= array();
$obr1=array();
$obr2=array();
$plik1="IMG_4075.JPG";
$plik2="IMG_4131.JPG";

  $tp=time();
  $rozmiar = getimagesize($inp_folder.$plik1);
printf("<br>%s<br>",$inp_folder.$plik1);

$wynik = imagecreatetruecolor($rozmiar[0], $rozmiar[1]);
  
 
    $im = imagecreatefromjpeg($inp_folder.$plik1);
	for($x=0;$x<$rozmiar[0];$x++)
    for($y=0;$y<$rozmiar[1];$y++)
     {  
	  $rgb1 = imagecolorat($im, $x, $y);
      $colors1 = imagecolorsforindex($im, $rgb1);
      $obr1[$x][$y] = array("r" => $colors1["red"], "g" =>$colors1["green"], "b" => $colors1["blue"]); 
	 }
    } 

   $im2= imagecreatefromjpeg($inp_folder.$plik2);
   
// zakladamy narazie ze mysle i ze rozmiar obu jest taki sam pozniej w tym mijescu trzba dodac jakis if gdyby tak nie bylo



for($x=0;$x<$rozmiar[0];$x++)
 for($y=0;$y<$rozmiar[1];$y++)
  {   
   $rgb2 = imagecolorat($im2, $x, $y);
   $colors2 = imagecolorsforindex($im2, $rgb2);
   $obr2[$x][$y] = array("r" => $colors2["red"], "g" =>$colors2["green"], "b" => $colors2["blue"]);
 }



for($x=0;$x<$rozmiar[0];$x++)
 for($y=0;$y<$rozmiar[1];$y++)
  {
   $suma1=$obr1[$x][$y]["r"]+$obr1[$x][$y]["g"]+$obr1[$x][$y]["b"];
   $suma2=$obr2[$x][$y]["r"]+$obr2[$x][$y]["g"]+$obr2[$x][$y]["b"];

  $kolor=imagecolorallocate($wynik, abs($obr2[$x][$y]["r"]-($obr1[$x][$y]["r"])),abs($obr2[$x][$y]["g"]-($obr1[$x][$y]["g"]),2),abs($obr2[$x][$y]["b"]-($obr1[$x][$y]["b"]),2));
	 
   imagesetpixel($wynik, $x,$y, $kolor);
   
  }
  //header('Content-Type: image/jpeg');

// Output the image
$outputfile=$out_folder.$prefix.$plik.$rozszerzenie;
imagejpeg($wynik,$outputfile,100);
printf("%s<br>",$outputfile);
// Free up memory
if($plik==2)
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

ob_end_flush(); 
?>
