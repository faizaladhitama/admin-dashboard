<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : Response
    {
        $perPage = request()->query('perPage')?: 5;
        $perPage = $perPage < 1 ? null : $perPage;

        $genres = Genre::paginate($perPage)->withPath('/api/genre');
        Log::info("genres");
        Log::info($genres);
        //
        return Inertia::render('Genre', [
            'genres' => $genres
        ]);
    }

    public function get() : JsonResponse
    {
        $builder = Genre::where('id', '>', 0);
        
        $orderBy =  request()->query('orderBy') ?: "";
        if($orderBy){
            if(strlen($orderBy) > 1){
                $column = substr($orderBy,1);
                if($orderBy[0] === "+"){
                    $builder = $builder->orderBy($column);
                }else{
                    $builder = $builder->orderByDesc($column);
                }
            }
        }

        $search = request()->query('search') ?: "";
        $builder = $builder->search($search);

        $perPage = request()->query('perPage')?: 5;
        $perPage = $perPage < 1 ? null : $perPage;
        $page = request()->query('page')?: 1;
        $genres = $builder->paginate($perPage, ['*'], 'page', $page)->withPath('/api/genre');
        $genres->appends([
            'perPage'=>$perPage,
            'page'=>$page,
            'orderBy'=>$orderBy
        ]);
        return response()->json($genres);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return $this->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre) : RedirectResponse
    {
        //
        $genre->delete();
        return redirect(route('genre.index'));
        
    }
}
