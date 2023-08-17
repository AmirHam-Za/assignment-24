<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function eventsPage()
    {
        return view('events.event-list');
    }

    public function index()
    {
        return Event::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id =  Auth::user()->id;
        return Event::create([
            'title'=>$request->input('title'),
            'description'=>$request->input('description'),
            'date'=>$request->input('date'),
            'time'=>$request->input('time'),
            'location'=>$request->input('location'),
            'user_id'=>$user_id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user_id = Auth::user()->id;
        return Event::where('id', $id)->where('user_id', $user_id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user_id = Auth::user()->id;
        return Event::where('id',$id)->where('user_id',$user_id)->update([
            'title'=>$request->input('title'),
            'description'=>$request->input('description'),
            'date'=>$request->input('date'),
            'time'=>$request->input('time'),
            'location'=>$request->input('location'),
            'user_id'=>$user_id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user_id = Auth::user()->id;
       return Event::where('id', $id)->where('user_id', $user_id)->delete();
    }
}
