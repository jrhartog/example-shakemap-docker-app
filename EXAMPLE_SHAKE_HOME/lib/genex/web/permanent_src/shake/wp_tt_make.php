<?php
/* wp_tt_make.php - make CAPTCHA image
 * precond - word is passed in "munged" form
 * operation -  The skeleton for this came from a tutorial I found on PHP
 *              graphics-on-the-fly at:
 *              http://www.macdonald.egate.net/CompSci/PHP/graphics1.html
 */

include 'captchaRoutines.php';

# Put out an expires header in the past.
header ("Expires: Thu, 01 Dec 1994 16:00:00 GMT");

# Get the db connect info and the font directory

$fontdir = "tt_fonts";

$word = $_GET['w'];   // the word in "munged" format
$font = $_GET['f'];   // which font to use
$a1 = $_GET['a1'];    // angle of first image
$a2 = $_GET['a2'];    // angle of second image

header("Content-type: image/jpeg");

// Decode the word
$word = unMungString($word);

# If we can't find a font, then fall back on this one.
if ($font == '') {
    $fontdir = "";
    $font = "/usr/local/jdk1.3.1/jre/lib/fonts/LucidaSansOblique.ttf";
}

# Use the image 'bg.jpg' as a base. It's a 250x90 light-blue JPEG
# with a beveled edge made with GIMP.
 
$bgimage = "tt_bg.jpg";
$im_size = GetImageSize ( "$bgimage" );
$imageWidth = $im_size[0];
$imageHeight = $im_size[1];

$im = imageCreatetruecolor( $imageWidth, $imageHeight ) or die("cannot initialiize new GD image stream");

# Set up some colors. Black, gray, and the background color
$font_color_black = ImageColorAllocate( $im, 0,0,0);
$font_color_gray = ImageColorAllocate( $im, 128,128,128);
$font_color_gray2 = ImageColorAllocate( $im, 192,192,192);
$bg_color = ImageColorAllocate( $im, 218,218,252);

$im2 = ImageCreateFromJPEG("$bgimage");

ImageCopy ($im,$im2,0,0,0,0, $imageWidth, $imageHeight); 

# Now draw some lines to break up the text
$linestart = 10;
$lineend = $imageWidth - 10;
$numlines = $imageHeight/10 - 1;

for ($i=0; $i<$numlines; $i++) {
    $curY = $i*10 + 10;
    ImageLine($im,$linestart,$curY,$lineend,$curY,$font_color_gray2);
}
$linestart = 10;
$lineend = $imageHeight - 10;
$numlines = $imageWidth/10 - 1;
for ($i=0; $i<$numlines; $i++) {
    $curX = $i*10 + 10;
    ImageLine($im,$curX,$linestart,$curX,$lineend,$font_color_gray2);
}

# Use this to get the bounds of the box for the text.
$fontsize = 60;

$box = imagettfbbox ($fontsize, $angle, "$fontdir/$font", $word);
$left = min($box[0], $box[6]);
$right = max($box[2], $box[4]);
$bottom = min($box[1], $box[3]);
$top = max($box[5], $box[7]);
$wid = abs($right - $left);
$hi = abs($top - $bottom);

$xscale = $imageWidth/$wid;
$yscale = $imageHeight/$hi;
$scale = min($xscale, $yscale);
$scale = 0.8*$scale;

$fontsize = $fontsize * $scale;

$box = imagettfbbox ($fontsize, $angle, "$fontdir/$font", $word);
$left = min($box[0], $box[6]);
$right = max($box[2], $box[4]);
$bottom = min($box[1], $box[3]);
$top = max($box[5], $box[7]);
$wid = abs($right - $left);
$hi = abs($top - $bottom);

#
# Work out the coordinates to center the text
$initx = ($imageWidth/2) - ($wid/2);
$inity = ($imageHeight/2) + ($hi/2);

# Add the text. Once in gray and once in black for a shadowed effect
	$angle = $a1;
  ImageTTFText ($im, $fontsize, $angle, $initx, $inity, $font_color_gray, "$fontdir/$font", $word);

	$angle = $a2;

# Same as above to center the text
$box = imagettfbbox ($fontsize, $angle, "$fontdir/$font", $word);
$left = min($box[0], $box[6]);
$right = max($box[2], $box[4]);
$bottom = min($box[1], $box[3]);
$top = max($box[5], $box[7]);
$wid = abs($right - $left);
$hi = abs($top - $bottom);
$initx = ($imageWidth/2) - ($wid/2);
$inity = ($imageHeight/2) + ($hi/2);

ImageTTFText ($im, $fontsize, $angle, $initx, $inity, $font_color_black, "$fontdir/$font", $word);

# Take just the left half of the image
#ImageCopy ($image,$im,0,0,0,0, $imageWidth, $imageHeight); 

# Output the image and then trash it.
Imagejpeg ($im);
#ImageDestroy ($image);
ImageDestroy ($im);
ImageDestroy ($im2);
?>
