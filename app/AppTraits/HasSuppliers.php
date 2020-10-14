<?php namespace App\AppTraits;

use App\Events\AssigneeAddedEvent;
use App\Events\AssigneeRemovedEvent;
use App\Models\Project;
use App\Models\Supplier;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use \DB;
use \Auth;

trait HasSuppliers
{
    public function addSupplier(Request $request, $object) {

        $rules = [
            'supplier_id'   => 'required|exists:suppliers,id'
        ];

        $this->validate($request, $rules);

        $supplier = Supplier::find($request->input('supplier_id'));

        if( $object->suppliers()->where('id', $supplier->id)->count() ) {
            return response()->json(['success' => false, 'message' => 'Supplier already assigned']);
        }

        $object->suppliers()->attach($supplier);

        // TODO: Add timeline event

        if( $request->ajax() ) {
            return response()->json(['success' => true, 'user' => view('fragments.suppliers.supplier', compact('supplier'))->render()]);
        }

        return redirect()->back()->with('message', 'Supplier added!');
    }

    public function removeSupplier(Request $request, $object) {

        $rules = [
            'supplier_id'   => 'required|exists:suppliers,id'
        ];

        $this->validate($request, $rules);

        $supplier = Supplier::find($request->input('supplier_id'));

        $object->suppliers()->detach($supplier);

        // TODO: Add timeline event

        if( $request->ajax() ) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('message', 'Supplier added!');
    }
}