<?php

namespace App\Http\Controllers;

use App\Thumbnail;
use Illuminate\Http\Request;

class ThumbnailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $picture = $request->get('picture');
        if (!isset($picture)) {
            $thumbnails = Thumbnail::where('size', 1)
                                   ->latest()
                                   ->get();
        } else {
            // да върне колекция в която първо са снимките които са избрани от потребителя и след това са всички останали снимки
            // сортиране по дата на създаване - низходящо
            $picture = implode(',', $request->get('picture'));
            $thumbnails = Thumbnail::where('size', 1)
                                   ->orderByRaw("IF(picture_id IN({$picture}), 0, 1), created_at desc")
                                   ->get();
        }

        return response()->json($thumbnails);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Thumbnail $thumbnail
     * @return \Illuminate\Http\Response
     */
    public function show(Thumbnail $thumbnail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Thumbnail $thumbnail
     * @return \Illuminate\Http\Response
     */
    public function edit(Thumbnail $thumbnail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Thumbnail           $thumbnail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thumbnail $thumbnail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Thumbnail $thumbnail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thumbnail $thumbnail)
    {
        //
    }
}
