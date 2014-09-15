<?php

namespace Karma\Util;

class UrlImageProcess
{
    public function fire($job, $data)
    {
        $this->prepareDir($data['save_path']);

        $name = $data['save_name'];

        $url = $data['source_image_url'];
        try {
        	$img = \Image::make($url);
        }
        catch (\Exception $e)
        {
            $url = '/public/images/icon-user-default.jpg';
            $img = \Image::make($url);
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
                $width = $img->width();
                $img->crop($requiredWidth, $requiredHeight, (int) (($width - $requiredWidth) / 2), 0);
            }
            else
            {
                $img->widen($requiredWidth);
                $height = $img->height();
                $img->crop($requiredWidth, $requiredHeight, 0, (int) (($height - $requiredHeight) / 2));
            }
        }

        $dirToSave = $data['save_path'];
        $path = $dirToSave.'/'.$name;

        $img->save($path);
        $img->destroy();
        $job->delete();

        $id = $data['user_id'];

        \Queue::push(function($job) use ($id, $name){
            $user = \Karma\Entities\User::find($id);
            $user->update(['photo' => $name]);
            $job->delete();
        });
    }

    public function prepareDir($path)
    {
        if (! \File::exists($path))
            \File::makeDirectory($path);
    }
}