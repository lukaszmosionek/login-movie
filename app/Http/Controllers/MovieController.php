<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    public function getTitles(Request $request)//: JsonResponse
    {

        $timeOfCache = 60; //seconds

        try{

            $bar = array_column( (new \External\Bar\Movies\MovieService)->getTitles()['titles'], 'title');
            $baz = (new \External\Baz\Movies\MovieService)->getTitles()['titles'];
            $foo = (new \External\Foo\Movies\MovieService)->getTitles();

        }catch(\Exception $e){

            $e->getMessage();
            Log::info( $e->getMessage() );

            if( !Cache::get('titles') ){
                return response()->json(['status'=> 'failure']);
            }else{
                return response()->json( Cache::get('titles') );
            }

        }

        $results = array_merge($bar ,$baz ,$foo);

        Cache::remember('titles', $timeOfCache, function () use($results) {
            return $results;
        });

        return response()->json($results);

    }
}
