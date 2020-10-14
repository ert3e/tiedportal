<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'mime_type', 'size'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public static function boot() {
        parent::boot();

        // Attach event handler, on deleting of the user
        Media::deleting(function($media) {

            $uploads_path = sprintf('%s/uploads', storage_path());

            $file_path = sprintf('%s/%s', $uploads_path, $media->id);

            if( file_exists($file_path) ) {
                unlink($file_path);

                $ext = strtolower(pathinfo($media->name, PATHINFO_EXTENSION));
                $thumbs_path = sprintf('%s/thumbnails', storage_path());
                $thumb_path = sprintf('%s/%s_*.%s', $thumbs_path, $media->id, $ext);

                foreach( glob($thumb_path) as $filename ) {

                    $file_path = sprintf('%s/%s', $thumbs_path, $filename);
                    @unlink($file_path);
                }
            }
        });
    }

    public function isImage() {
        return (substr($this->mime_type, 0, 5) == 'image');
    }
}
