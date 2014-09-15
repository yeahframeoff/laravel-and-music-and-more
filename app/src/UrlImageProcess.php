<?php

namespace Karma\Util;

use Illuminate\Filesystem\Filesystem;
use Intervention\Image\Facades\Image;

class UrlImageProcess
{

    const DIR_TO_SAVE = 'public/media/images';

    /**
     * @param $data
     * @return string
     */
    private static function makeName($data)
    {
        $time = date('Ymd_His');
        $name = $data['id'] . '_' . $time . '.jpg';
        return $name;
    }

    public function fire($job, $data)
    {
        $this->prepareDir('public/media/images');

        $name = $data['save_name'];
        
        $url = $data['source_image_url'];
        try {
        	$img = Image::make($url);    
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            echo 'Couldn\'t resolve file from URL '.$url;
            App::abort(418);
        }

        $requiredWidth  = $data['resize_to_width'];
        $requiredHeight = $data['resize_to_height'];

        $requiredRatio = $requiredWidth / $requiredHeight;
        
        $width  = $img->width();
        $height = $img->height();
        $ratio  = $width / $height;

        if ($requiredWidth <= $width && $requiredHeight <= $height)
        {
            if ($ratio > $requiredRatio)
            {
                $img->heighten($requiredHeight);
                $img->crop($requiredWidth, $requiredHeight, ($height - $requiredHeight) / 2, 0);
            }
            else
            {
                $img->widen($requiredWidth);
                $img->crop($requiredWidth, $requiredHeight, 0, ($width - $requiredWidth) / 2);
            }
        }
        
        $dirToSave = base_path() .'/' . $data['save_path'];
        $path = $dirToSave.'/'.$name;

        $img->save($path);
        $img->destroy();
        $job->delete();
    }
    
    public function prepareDir($path)
    {
        $path = explode('/', $path);
        $fs = new Filesystem;
        $dir = base_path();
        foreach ($path as $child)
        {
            $dirs = $fs->directories($dir);
            if (! in_array($dir . '/' . $child, $dirs))
                $fs->makeDirectory($dir . '/' . $child);
            $dir .= '/' . $dir;
        }
    }
}