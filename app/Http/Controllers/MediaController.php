<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AppTraits\UploadsMedia;
use \Image;

class MediaController extends Controller
{
    use UploadsMedia;

    public function get($media, $width = 0, $height = 0) {

        $uploads_path = sprintf('%s/uploads', storage_path());

        if( !is_dir($uploads_path) )
            mkdir($uploads_path);

        $thumbs_path = sprintf('%s/thumbnails', storage_path());

        if( !is_dir($thumbs_path) )
            mkdir($thumbs_path);

        $ext = strtolower(pathinfo($media->name, PATHINFO_EXTENSION));

        $thumb_path = sprintf('%s/%s_%d_%d.%s', $thumbs_path, $media->id, $width, $height, $ext);

        if( !file_exists($thumb_path) ) {

            $file_path = sprintf('%s/%s', $uploads_path, $media->id);
            $img = Image::make($file_path)->fit($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $img->save($thumb_path);
        }

        return response()->download($thumb_path, $media->name, ['Content-Type' => $media->mime_type]);
    }

    public function download($media) {

        $uploads_path = sprintf('%s/uploads', storage_path());

        if( !is_dir($uploads_path) )
            mkdir($uploads_path);

        $file_path = sprintf('%s/%s', $uploads_path, $media->id);

        return response()->download($file_path, $media->name, ['Content-Disposition' => 'attachment;filename="' . $media->name . '"', 'Content-Type' => $media->mime_type]);
    }
}
