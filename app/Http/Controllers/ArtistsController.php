<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;

use App\Artist;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArtistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Artist::with(['albums' => function($query) {
            $query->orderBy('released', 'desc');
        }])->paginate(3)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Create Form page will be implemented in One Page App on fronted
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->has('artist'))
           return response()->json(['success' => false], 400);        

        $this->validate($request, [
            'file' => 'image|max:2000',
            'artist' => 'required|string',
            'musician_from' => 'required|string',
        ]);

        $filename = str_replace(' ', '_', strtolower($request->artist)) . '.jpg';
        if ($request->hasFile('file')) {
            $image = $request->file('file'); //Input::file('file');
            if (!$image->move(public_path('img'), $filename)) {
                 abort(400, 'Error saving the file');
            }
        }

        $artist = Artist::where('artist', $request->artist)->first();
        if (empty($artist)) {
            // create new
            Artist::create(['artist' => $request->artist, 'image' => 'img/' . $filename, 'musician_from' => $request->musician_from]);
        }
        else {
            // update existing
            $artist = Artist::findOrFail($artist->id);            
            $artist->musician_from = $request->musician_from;
            $artist->save();
        }

        return response()->json(['success' => true], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return Artist::with(['albums' => function($query) {
            $query->orderBy('released', 'desc');
        }])->findOrFail($id)->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //TODO: delete albums and songs
        Artist::destroy($id);
    }
}
