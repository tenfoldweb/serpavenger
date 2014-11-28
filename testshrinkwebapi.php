<?php
/**
 * Sample of direct fetch for remote use.
 */

$url = "http://serpavenger.com/serp_avenger";

$args["Size"] = "xlg";

if (isset($_POST["Size"]) && $_POST["Size"])
    $args["Size"] = $_POST["Size"];
if (isset($_POST["xmax"]) && $_POST["xmax"])
    $args["xmax"] = $_POST["xmax"];
if (isset($_POST["ymax"]) && $_POST["ymax"])
    $args["ymax"] = $_POST["ymax"];
if (isset($_POST["scale"]) && $_POST["scale"])
    $args["scale"] = $_POST["scale"];
if (isset($_POST["full"]) && $_POST["full"])
    $args["full"] = 1;
if (isset($_POST["embed"]) && $_POST["embed"])
    $args["embed"] = $_POST["embed"];

function showImage($label, $src)
{
    echo "<h3>$label</h3>";

    if ($src) {
        // The extra ? is so our servers bypass varnish, a reverse proxy
        echo "<p><a href=$src?><img src=$src?></a>";
        echo "<br style=font-size:9px><a href=$src>$src</a>";
    } else
        ; // use some default image
}

showImage("Direct Call Example", AppSTW::queryRemoteThumbnail($url, $args, true));
showImage("Cached Call Example", AppSTW::getThumbnail($url, $args));
showImage("Large Scaled Image", AppSTW::getLargeThumbnail($url, true, true));
showImage("Small Scaled Image", AppSTW::getSmallThumbnail($url, true, true));
showImage("Scaled Image", AppSTW::getScaledThumbnail($url, 640, 480));

?>
<?php

/**
 * Implements sourcing thumbnails from http://www.shrinktheweb.com
 *
 * Dependent on PHP5, but could be easily back-ported.  All config
 * information is defined in constants.  No reason to ever create
 * an instance of this class, hence abstract.
 *
 * @author Entraspan, Based in part on STW sample code
 * @copyright Open Source/Creative Commons
 */
abstract class AppSTW {
    const ACCESS_KEY = "37c50d761e16b0b";
    const SECRET_KEY = "c1871";
    const THUMBNAIL_URI = "/images";
    const THUMBNAIL_DIR = "/home/serpaven/public_html/serp_avenger";
    const CACHE_DAYS = 3; // used 7 for Alexa!

    private static function make_http_request($url){
        $lines = file($url);
        return implode("", $lines);
    }

    /**
     * Calls through the API and processes the results based on the
     * original sample code from STW.  This function is public for
     * example only.  It really should not be used since thumbnails
     * should be cached locally using getThumbnail.
     *
     * It is common for this routine to return a null value when the
     * thumbnail does not yet exist and is queued up for processing.
     *
     * @param string $url URL to get thumbnail for
     * @param array $args Array of parameters to use
     * @return string full remote URL to the thumbnail
     */
    public static function queryRemoteThumbnail($url, $args = null, $debug = false) {
        $args = is_array($args) ? $args : array();

        $defaults["Service"] = "ShrinkWebUrlThumbnail";
        $defaults["Action"] = "Thumbnail";
        $defaults["stwaccesskeyid"] = self::ACCESS_KEY;
        $defaults["stwu"] = self::SECRET_KEY;

        foreach ($defaults as $k=>$v)
            if (!isset($args[$k]))
                $args[$k] = $v;

        // read where someone had to put this last to get it to work for a url.
        // the arguments should be property encoded so the separators would work
        // correctly, so could be a problem with the build query, unrecognized
        // chars in the original url, or the argument parsing, by making it last
        // then stw should at least get their required args first.  I never ran
        // into this, but typically only grabbed domain url's, and primarily use
        // the soap interface.
        $args["stwurl"] = $url;

        $request_url = "http://images.shrinktheweb.com/xino.php?".http_build_query($args);

        $line = self::make_http_request($request_url);

        if ($debug) {
            echo '<pre style=font-size:10px>';
            unset($args["stwaccesskeyid"]);
            unset($args["stwu"]);
            print_r($args);
            echo '</pre>';
            echo '<div style=font-size:10px>';
            highlight_string($line);
            echo '</div>';
        }

        $regex = '/<[^:]*:Thumbnail\\s*(?:Exists=\"((?:true)|(?:false))\")?[^>]*>([^<]*)<\//';

        if (preg_match($regex, $line, $matches) == 1 && $matches[1] == "true")
            return $matches[2];

        return null;
    }

    /**
     * Refreshes the thumbnail if it is expired or creates it if it does
     * not exist.  There is no cleanup of the thumbnails for ones that don't
     * get used again, e.g. find /share/images/thumbnails -type f -mtime +7 -delete
     *
     * Every combination of url and call arguments results in a unique filename
     * through a MD5 hash.  The size argument can also be an array where you can
     * add any parameter you wish to the request, or override any default.
     *
     * It is up to the calling function to decide what to do with the results when
     * a null is returned.  I often store the src in a database with a timestamp so
     * that I do not bombard the server with repeated requests for a thumbnail that
     * doesn't yet exist, although STW is very fast at processing.
     *
     * @param string $url URL to get thumbnail for
     * @param array $args Array of parameters to use
     * @param boolean $force Force call to bypass cache, was used for debugging
     * @return string Local SRC URI for the thumbnail.
     */
    public static function getThumbnail($url, $args = null, $force = false) {
        $args = $args ? $args : array("stwsize"=>"lg");
        $name = md5($url.serialize($args)).".jpg";
        $src = self::THUMBNAIL_URI."/$name";
        $path = self::THUMBNAIL_DIR.$src;
        $cutoff = time() - 3600 * 24 * self::CACHE_DAYS;

        if ($force || !file_exists($path) || filemtime($path) <= $cutoff)
            if (($jpgurl = self::queryRemoteThumbnail($url, $args)))
                if (($im = imagecreatefromjpeg($jpgurl)))
                    imagejpeg($im, $path, 100);

        if (file_exists($path))
            return $src;

        return null;
    }

    /**
     * Always retrieves the X-Large thumbnail from STW, then uses
     * local gd library to create arbitrary sized thumbnails.
     *
     * By passing the same arguments used for small/large should
     * generate cache hits so the only size every retrieved would
     * be xlg.
     *
     * @param string $url URL to get thumbnail for
     * @param string $width The desired image width
     * @param string $height The desired image height
     * @param string $args Used to make name same as sm/lg fetches.
     */
    public static function getScaledThumbnail($url, $width, $height, $args = null, $force = false) {
        $args = $args ? $args : array("width"=>$width, "height"=>$height);
        $name = md5($url.serialize($args)).".jpg";
        $src = self::THUMBNAIL_URI."/$name";
        $path = self::THUMBNAIL_DIR.$src;
        $cutoff = time() - 3600 * 24 * self::CACHE_DAYS;

        if ($force || !file_exists($path) || filemtime($path) <= $cutoff)
            if (($xlg = self::getXLargeThumbnail($url)))
                if (($im = imagecreatefromjpeg(self::THUMBNAIL_DIR.$xlg))) {
                    list($xw, $xh) = getimagesize(self::THUMBNAIL_DIR.$xlg);
                    $scaled = imagecreatetruecolor($width, $height);

                    if (imagecopyresampled($scaled, $im, 0, 0, 0, 0, $width, $height, $xw, $xh))
                        imagejpeg($scaled, $path, 100);
                }

        if (file_exists($path))
            return $src;

        return null;
    }

    /**
     * Convenience Function for 320x240
     *
     * @param string $url URL to get thumbnail for
     */
    public static function getXLargeThumbnail($url) {
        return self::getThumbnail($url, array("Size"=>"xlg"));
    }

    /**
     * Convenience Function for 200x150
     *
     * @param string $url URL to get thumbnail for
     * @param boolean $scaler Scale image from xlg
     */
    public static function getLargeThumbnail($url, $scaler = true, $force = false) {
        if ($scaler)
            return self::getScaledThumbnail($url, 200, 150, array("Size"=>"lg"), $force);

        return self::getThumbnail($url);
    }

    /**
     * Convenience Function for 120x90
     *
     * @param string $url URL to get thumbnail for
     * @param boolean $scaler Scale image from xlg
     */
    public static function getSmallThumbnail($url, $scaler = true, $force = false) {
        if ($scaler)
            return self::getScaledThumbnail($url, 120, 90, array("Size"=>"sm"), $force);

        return self::getThumbnail($url, array("Size"=>"sm"));
    }
}

?>
