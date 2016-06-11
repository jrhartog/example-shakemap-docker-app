<?php
/* wp_tt.php - included by comment_form.php to setup the "CAPTCHA"
 *             image and input field
 * precond - * Relies on the fact that this is included from comment_form.php 
 *             and that the captchaRoutines.php file is already include.
 *           * A tt_fonts directory exists in the same directory with truetype
 *             fonts contained within.  
 * postcon - * an 'img' tag is pointing to wp_tt_make.php to display the 
 *             CAPTCHA image
 *           * input input fields are set up for verifying input
 */

$fontdir = "tt_fonts";

$word = RandomString(4);
$altword = preg_replace("/\s+/", "", $word);
$wordlen = strlen($altword);

# Get the word and make an md5 hash of it.
$hashword = preg_replace('/=+$/','',base64_encode(pack('H*',md5($altword))));

# Check the font directory for a list of True Type fonts to
# use. I found these fonts at http://www.webfontlist.com/index.asp
$numfont = 0;
if ($dir = @opendir($fontdir)) {
    while (($file = readdir($dir)) !== false) {
        if (preg_match("/^.*\.(ttf|TTF)$/", $file)) {
            $bgcolors[$numfont] = $file;
            $numfont++;
        }
    }
    closedir($dir);
}
$numfont--;

# Pick a random font to use
$number = rand(0, $numfont);
$fontindex = round($number,0);

$font = $bgcolors[$fontindex];

$angle1 = rand(4,11);
$angle2 = rand(0,-6);

# Get the images with the word in them. This makes two
# images with the word spread across both, so they need
# to be displayed side-by-side.  The word is split into
# two pieces, which are sent as the 'alt' text for the 
# two images.

$encodedString = mungString($altword);

# use this line instead if you want "alt" text with the image.
#  printf("<img src=\"./wp_tt_make.php?w=$encodedString&f=$font&a1=%d&a2=%d\" alt=\"$altword\"></td>\n", $angle1, $angle2);

printf("<img src=\"./wp_tt_make.php?w=$encodedString&f=$font&a1=%d&a2=%d\" /></td>\n", $angle1, $angle2);

# Set up a form for them to type the word in.
printf ("<input type=hidden name=\"hash\" value=\"%s\">\n", $hashword);
echo "<br clear=\"all\">";
echo "Please enter the code above to verify that you are a human<br>";
echo "<input type=\"text\" size=\"15\" name=\"testword\">\n";
?>
