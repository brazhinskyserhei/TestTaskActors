<?php

namespace App\Http\Controllers;

use App\Actor;
use Illuminate\Http\Request;
use DB;

class ActorController extends Controller
{
    public function getActorsByCategory(Request $request)
    {
        $offset = $request['offset'];
        $limit = $request['limit'];
        $category_id = $request['category_id'];

        $query = DB::table('actor');
        $query->select('actor.actor_id', 'actor.first_name', 'actor.last_name', DB::raw('COUNT(actor.actor_id) as cat_film_app'));
        $query->leftJoin('film_actor', 'actor.actor_id', '=', 'film_actor.actor_id');
        $query->whereIn('film_id', function ($query) use ($category_id) {
            $query->select('film_id');
            $query->from('film_category');
            $query->where('film_category.category_id', '=', $category_id);
        });
        $query->groupBy('actor.actor_id');
        $query->orderBy('cat_film_app', 'desc');

        if ($offset)
            $query->offset($offset);
        if ($limit)
            $query->limit($limit);
        $response = $query->get();

        if(!isset($response))
            return response()->json(null, 404);
        return response()->json($response, 200);
    }
}
