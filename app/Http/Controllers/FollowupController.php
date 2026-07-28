<?php

namespace App\Http\Controllers;

use App\Models\Followup;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class FollowupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($inquiryId)
    {
        $inquiry = Inquiry::findOrFail($inquiryId);
        $followups = Followup::where('inquiry_id', $inquiryId)->orderBy('followup_date', 'desc')->get();
        return view('followup', compact('inquiry', 'followups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($inquiryId)
    {
        $inquiry = Inquiry::findOrFail($inquiryId);
        return view('add-followup', compact('inquiry'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $inquiryId)
    {
        $request->validate([
            'type_of_contact' => 'required|string|max:255',
            'remarks' => 'nullable|string',
            'followup_date' => 'required|date',
        ]);

        Followup::create([
            'inquiry_id' => $inquiryId,
            'type_of_contact' => $request->type_of_contact,
            'remarks' => $request->remarks,
            'followup_date' => $request->followup_date,
        ]);

        return redirect()->route('followup', $inquiryId)
            ->with('success', 'Follow up added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Followup  $followup
     * @return \Illuminate\Http\Response
     */
    public function show(Followup $followup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Followup  $followup
     * @return \Illuminate\Http\Response
     */
    public function edit(Followup $followup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Followup  $followup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Followup $followup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Followup  $followup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Followup $followup)
    {
        //
    }
}
