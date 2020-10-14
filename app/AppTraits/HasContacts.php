<?php namespace App\AppTraits;

use App\Models\ContactType;
use App\Models\Contact;
use App\Models\Media;
use Illuminate\Http\Request;
use \DB;

trait HasContacts {

    public function storeContact(Request $request, $object) {

        $rules = [
            'first_name'    => 'required',
            'type_id'       => 'exists:contact_types,id'
        ];

        $this->validate($request, $rules);

        DB::transaction(function() use($request, $object) {

            $input = $request->only(['first_name', 'last_name', 'telephone', 'mobile', 'email', 'description']);
            $input['contact_type_id'] = $request->input('type_id');

            $contact = Contact::create($input);

            if( $request->hasFile('media') ) {

                $file = $request->file('media');

                $media = Media::create([
                    'name'          => $file->getClientOriginalName(),
                    'description'   => '',
                    'mime_type'     => $file->getMimeType()
                ]);

                $uploads_path = sprintf('%s/uploads', storage_path());

                if( !is_dir($uploads_path) )
                    mkdir($uploads_path);

                if( $file->move($uploads_path, $media->id) ) {

                    $original_media = $contact->media;

                    $contact->media()->associate($media);

                    if( is_object($original_media) ) {
                        $file_path = sprintf('%s/%s', $uploads_path, $original_media->id);

                        if( file_exists($file_path) ) {
                            unlink($file_path);

                            // TODO: Remove thumbnailed images
                        }
                    }
                } else {
                    $media->delete();
                    abort(500);
                }
            }

            $contact->save();

            $object->contacts()->save($contact);
        });

        return redirect()->back()->with('success', 'Contact saved!');
    }
}