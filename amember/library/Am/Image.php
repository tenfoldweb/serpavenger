<?php

class Am_Image
{
    const RESIZE_CROP = 'crop';
    const RESIZE_GIZMO = 'gizmo';
    protected $handler = null;

    public function __construct($path, $mime)
    {
        switch ($mime) {
            case 'image/gif' :
                $handler = imagecreatefromgif($path);
                break;
            case 'image/png' :
                $handler = imagecreatefrompng($path);
                break;
            case 'image/jpeg' :
                $handler = imagecreatefromjpeg($path);
                break;
            default :
                throw new Am_Exception_InternalError(sprintf('Unknown MIME type [%s]', $mime));
        }
        if (false === $handler)
            throw new Am_Exception_InternalError(sprintf('Can not open [%s] as image resource', $path));

        $this->handler = $handler;
    }

    public function __destruct()
    {
        imagedestroy($this->handler);
    }

    public function __clone()
    {
        $width = imagesx($this->handler);
        $height = imagesy($this->handler);

        $clone_handler = imagecreatetruecolor($width, $height);
        imagecopy($clone_handler, $this->handler, 0, 0, 0, 0, $width, $height);

        $this->handler = $clone_handler;
    }

    public function resize($width, $height, $resize_type = self::RESIZE_CROP)
    {
        $src_height = imagesy($this->handler);
        $src_width = imagesx($this->handler);

        switch ($resize_type) {
            case self::RESIZE_GIZMO:
                $q = min($width / $src_width, $height / $src_height);
                break;
            case self::RESIZE_CROP:
                $q = max($width / $src_width, $height / $src_height);
                break;
            default:
                throw new Am_Exception_InternalError(sprintf('Unknown resize type [%s] in %s->%s',
                        $resize_type, __CLASS__, __METHOD__));
        }

        $n_width = $src_width * $q;
        $n_height = $src_height * $q;

        $dist_x = $dist_y = 0;
        if ($n_width < $width) {
            $dist_x = floor(($width - $n_width) / 2);
        } else {
            $dist_x = -1 * floor(($n_width - $width) / 2);
        }

        if ($n_height < $height) {
            $dist_y = floor(($height - $n_height) / 2);
        } else {
            $dist_y = -1 * floor(($n_height - $height) / 2);
        }

        $result_handler = imagecreatetruecolor($width, $height);
        imagefill($result_handler, 0, 0, 0xCCCCCC);
        imagecopyresampled($result_handler, $this->handler, $dist_x, $dist_y, 0, 0, $n_width, $n_height, $src_width, $src_height);

        imagedestroy($this->handler);
        $this->handler = $result_handler;
        return $this;
    }

    public function save($filename, $mime = 'image/jpeg')
    {
        switch ($mime) {
            case 'image/gif' :
                imagegif($this->handler, $filename);
                break;
            case 'image/png' :
                imagepng($this->handler, $filename);
                break;
            case 'image/jpeg' :
                imagejpeg($this->handler, $filename);
                break;
            default :
                throw new Am_Exception_InternalError(sprintf('Unknown MIME type [%s]', $mime));
        }

        return $this;
    }

}
