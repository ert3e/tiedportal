<?php namespace App\AppTraits;

use Illuminate\Http\Request;
use App\Models\Media;
use \DB;

trait HasAttachments
{
    /*
     * This trait provides support for attachments for
     * various controllers. To attach files, the container
     * must have the "dropzone" class added to provide
     * drag / drop functionalty.
     *
     * The view fragments.media.attachments will display
     * the attachments in the view.
     */

    protected function getMediaTypes() {
        return []; // Accepts all types
    }

    public function addAttachment(Request $request, $object) {

        $media = $this->attachMedia($request);

        $object->attachments()->attach($media);

        if( $request->ajax() ) {
            return response()->json(['success' => true, 'attachment' => view('fragments.media.attachment', compact('media'))->render()]);
        }

        return redirect()->back()->with('message', 'Attachment added!');
    }

    public function removeAttachment(Request $request, $object) {

        $rules = [
            'media_id'  => 'required|exists:media,id'
        ];

        $this->validate($request, $rules);

        // Is this attached?
        $media = $object->attachments()->where('id', $request->input('media_id'))->firstOrFail();

        $uploads_path = sprintf('%s/uploads', storage_path());
        $media_path = sprintf('%s/%s', $uploads_path, $media->id);

        if( file_exists($media_path) ) {
            @unlink($media_path);
        }

        DB::transaction(function() use($object, $media) {
            $object->attachments()->detach($media);
            $media->delete();
        });

        // TODO: Delete thumbnails

        if( $request->ajax() ) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('message', 'Attachment deleted!');
    }
}