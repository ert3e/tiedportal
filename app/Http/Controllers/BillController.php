<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class BillController extends Controller
{
    public function edit($project, $bill) {
        return view('bills.edit', compact('project', 'bill'));
    }

    public function update(Request $request, $project, $bill) {

        $rules = [
            'date'          => 'required|date_format:d/m/Y',
            'due_date'      => 'required|date_format:d/m/Y',
            'paid_date'     => 'date_format:d/m/Y',
            'reference'     => 'required',
            'amount'        => 'required|numeric',
        ];

        $this->validate($request, $rules);

        $input = [
            'date'          => Carbon::createFromFormat('d/m/Y', $request->input('date')),
            'due_date'      => Carbon::createFromFormat('d/m/Y', $request->input('due_date')),
            'paid_date'     => strlen($request->input('paid_date', '')) ? Carbon::createFromFormat('d/m/Y', $request->input('paid_date')) : null,
            'reference'     => $request->input('reference', ''),
            'amount'        => $request->input('amount', 0)
        ];

        $bill->update($input);

        return redirect()->back()->with('success', 'Bill updated successfully!');
    }
}
