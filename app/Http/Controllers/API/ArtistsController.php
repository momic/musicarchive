<?php

namespace App\Http\Controllers\API;

use App\Artist;
use App\Http\Controllers\Controller;
use App\Transformers\ArtistTransformer;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class ArtistsController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $paginator = Artist::with(['albums' => function($query) {
            $query->orderBy('released', 'desc');
        }])->paginate(3);

        return $this->response->paginator($paginator, new ArtistTransformer());
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param Request $request
     * @return Response|\Illuminate\Http\JsonResponse
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
                 $this->response->errorInternal('Error saving the file');
            }
        }

        $artist = Artist::where('artist', $request->artist)->first();
        if (empty($artist)) {
            // create new
            $artist = Artist::create(['artist' => $request->artist, 'image' => 'img/' . $filename, 'musician_from' => $request->musician_from]);
        }
        else {
            // update existing
            $artist = Artist::findOrFail($artist->id);            
            $artist->musician_from = $request->musician_from;
            $artist->save();
        }

        return $this->response->created('/angular#/artists/' . $artist->id, $artist);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        $artist = Artist::with(['albums' => function($query) {
            $query->orderBy('released', 'desc');
        }])->findOrFail($id);

        return $this->response->item($artist, new ArtistTransformer());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        //TODO: delete albums and songs
        Artist::destroy($id);

        return $this->response->noContent();
    }
}
