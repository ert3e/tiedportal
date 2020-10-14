<?php namespace App\AppTraits;

use Illuminate\Http\Request;
use App\Models\Address;

trait HasAddresses {

    public function storeAddress(Request $request, $object) {

        $rules = [
            'name'      => 'required',
            'address1'  => 'required',
            'country'   => 'required'
        ];

        $this->validate($request, $rules);

        $input = [
            'name'      => $request->input('name', ''),
            'address1'  => $request->input('address1', ''),
            'address2'  => $request->input('address2', ''),
            'town'      => $request->input('town', ''),
            'county'    => $request->input('county', ''),
            'postcode'  => $request->input('postcode', ''),
            'country'   => $request->input('country', '')
        ];

        $address = Address::create($input);

        $object->addresses()->save($address);

        $param = array("address" => $address->asString());
        $response = \Geocoder::geocode('json', $param);

        $address_obj = json_decode($response, true);

        if( ($geometry = array_get($address_obj, 'results.0.geometry.location', false)) ) {

            $address->lat = $geometry['lat'];
            $address->lng = $geometry['lng'];
            $address->save();
        }

        return redirect()->back()->with('success', 'Address saved!');
    }
}