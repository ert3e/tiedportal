<?php namespace App\AppTraits;

use Illuminate\Http\Request;
use App\Models\Media;

trait UploadsMedia {

    protected $overwritesMedia = true;
    protected $mediaTypes = ['jpeg', 'png', 'tif', 'gif'];

    public function uploadMedia(Request $request, $object) {

        $media_types = $this->mediaTypes;

        if( method_exists($this, 'getMediaTypes') ) {
            $media_types = $this->getMediaTypes();
        }

        if( !empty($media_types) ) {
            $rules = [
                'media' => 'required|mimes:' . implode(',', $media_types)
            ];

            $this->validate($request, $rules);
        }

        $file = $request->file('media');

        $media = Media::create([
            'name'          => $file->getClientOriginalName(),
            'description'   => '',
            'mime_type'     => $file->getMimeType(),
            'size'          => $file->getClientSize()
        ]);

        $uploads_path = sprintf('%s/uploads', storage_path());

        if( !is_dir($uploads_path) )
            mkdir($uploads_path);

        if( $file->move($uploads_path, $media->id) ) {

            $original_media = $object->media;

            $object->media()->associate($media);
            $object->save();

            if( is_object($original_media) ) {
                $original_media->delete();
            }
        } else {
            $media->delete();
            abort(500);
        }

        return redirect()->back()->with('success', 'Image saved!');
    }
    
    public function attachMedia(Request $request, $name = 'media') {

        $media_types = $this->mediaTypes;

        if( method_exists($this, 'getMediaTypes') ) {
            $media_types = $this->getMediaTypes();
        }

        if( !empty($media_types) ) {
            $rules = [
                $name => 'required|mimes:' . implode(',', $media_types)
            ];

            $this->validate($request, $rules);
        }

        $file = $request->file($name);
        $media = false;
        if( $file && $file->isValid() ) {

            $media = Media::create([
                'name' => $file->getClientOriginalName(),
                'description' => '',
                'mime_type' => $file->getMimeType(),
                'size' => $file->getClientSize()
            ]);

            $uploads_path = sprintf('%s/uploads', storage_path());

            if (!is_dir($uploads_path))
                mkdir($uploads_path);

            if (!$file->move($uploads_path, $media->id)) {
                $media->delete();
                abort(500);
            }
        }

        return $media;
    }
}