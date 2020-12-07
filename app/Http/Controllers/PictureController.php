<?php

namespace App\Http\Controllers;

use App\Picture;
use App\Thumbnail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'picture'   => 'required',
            'picture.*' => 'image',
        ]);

//        DB::transaction(function () use ($request) {
            foreach ($request->picture as $item) {
                $filename = Picture::generateUniqueFilename($item->getClientOriginalName());

                $picture = Picture::create([
                    'filename' => $filename,
                ]);

                $picture->cropImage($item->getPathname(), 1000, 1000);
                $picture->generateThumbnails($item->getPathname());
            }
//        });

        return response()->json(['success' => true], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Picture $picture
     * @return \Illuminate\Http\Response
     */
    public function show(Picture $picture)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Picture $picture
     * @return \Illuminate\Http\Response
     */
    public function edit(Picture $picture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Picture             $picture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Picture $picture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Picture $picture
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Picture $picture)
    {
        $picture->delete();
    }
}
