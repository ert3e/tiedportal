<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

use App\Http\Requests;

class CostController extends Controller
{
    public function edit($project, $cost) {
        return view('costs.edit', compact('project', 'cost'));
    }

    public function update(Request $request, $project, $cost) {

        $rules = [
            'supplier_id'   => 'exists:suppliers,id',
            'value'         => 'required|numeric'
        ];

        $this->validate($request, $rules);

        $description = $request->input('description', '');
        $value = $request->input('value', 0);
        $cost_value = $request->input('cost', 0);

        // Update the cost object
        $input = [
            'value'             => $value,
            'cost'              => $cost_value,
            'description'       => $description
        ];

        $cost->update($input);

        if( $request->has('supplier_id') ) {
            $supplier = Supplier::find($request->input('supplier_id'));
            $cost->supplier()->associate($supplier);
        }
        $cost->save();

        return redirect()->route('projects.details', [$project->id, '#finance']);
    }

    public function delete($project, $cost) {
        if( $project->id != $cost->project->id )
            abort(400);

        $cost->delete();
        return redirect()->route('projects.details', [$project->id, '#finance']);
    }
}
