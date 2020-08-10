<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;

class CategoriesController extends BaseController
{

    public function list(Request $req)
    {
        $id = $req->get('id', null);
        $slug = $req->get('slug', null);
        $parentId = $req->get('parentId', null);
        $fields = $req->get('fields', 'id,name,slug,parent_id');

        $where = '1=1';
        $params = [];
        if ($id) {
            $where = 'id = ?';
            $params = [$id];
        } elseif ($slug) {
            $where = 'slug = ?';
            $params = [$slug];
        } elseif ($parentId !== null) {
            $where = 'ifnull(parent_id, 0) = ?';
            $params = [$parentId];
        }

        $allowedFields = ['id', 'name', 'slug', 'parent_id', 'description', 'keywords'];
        $sqlFields = '';
        foreach (preg_split('/,/', $fields) as $field) {
            if (in_array(trim($field), $allowedFields)) {
                $sqlFields .= $sqlFields ? ',' : '';
                $sqlFields .= "`$field`";
            }
        }
        if (!$sqlFields) {
            return response('Bad Request', 400);
        }

        $res = DB::select("SELECT $sqlFields FROM `adz_category` WHERE $where ORDER BY `name`", $params);

        return response()
            ->json(['categories' => $res])
            ->header('Access-Control-Allow-Origin', 'http://localhost:3000')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    public function create()
    {
        return response('Not implemented', 200);
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
