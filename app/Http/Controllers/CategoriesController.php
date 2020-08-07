<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;

class CategoriesController extends BaseController
{

    public function list(Request $req)
    {
        $parentId = $req->get("parent_id", 0);

        $res = DB::select(
            "SELECT * FROM adz_category WHERE ifnull(parent_id, 0) = ? ORDER BY name",
            [$parentId]
        );
        return response()
            ->json(['categories' => $res])
            ->header('Access-Control-Allow-Origin', 'http://localhost:3000')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    public function listAll()
    {
        $res = DB::select("SELECT * FROM adz_category ORDER BY `name` LIMIT 25");
        return response()
            ->json(['categories' => $res])
            ->header('Access-Control-Allow-Origin', 'http://localhost:3000')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    public function create()
    {
        return response('Not implemented', 200);
    }

    public function read($id)
    {
        $obj = DB::select("SELECT * FROM adz_category WHERE id = ?", [$id]);

        if (!$obj)
            return response('Resource not found', 404);

        return response()->json($obj);
    }

    public function update($id, Request $req)
    {
        $obj = DB::select("SELECT * FROM adz_category WHERE id = ?", [$id]);

        if (!$obj)
            return response('Resource not found', 404);

        return response()->json($req->all());
    }

    public function delete($id)
    {
        $obj = DB::select("SELECT * FROM adz_category WHERE id = ?", [$id]);

        if (!$obj)
            return response('Resource not found', 404);

        DB::delete("DELETE FROM adz_category WHERE id = ?", [$id]);
        return response('Deleted', 200);
    }
}
