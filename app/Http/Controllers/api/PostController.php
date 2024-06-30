<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\createPostRequest;
use App\Http\Requests\editPostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index (Request $request){
        try {
            $query = Post :: query();
            $perpage = 1;
            $page = $request->input("page",1);
            $search = $request->input("search");
            if($search){
                $query->whereRaw("title LIKE '%" .$search. "%' ");
                
            }
            $total = $query->count();
            $result = $query->paginate($perpage,["title","description","id"]);
            // $result = $query->offset(($page-1)*$perpage)->limit($perpage)->get();

            return response()->json([
                'status_code' => 200,
                "status"=>"les posts ont été récupéré",
                "current page"=>$page,
                "last page"=>ceil($total / $perpage),
                "items"=>$result,
                
            ]);
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }
    public function create(){
        return "Création d'un post depuis le controller";
    }
    public function store (createPostRequest $request){
        try {
            $post = new Post();
            $post->title =  $request->title;
            $post->description = $request->description;
            $post->user_id = Auth()->user()->id;
            $post->save();
            return response()->json([
                "status_code"=>200,
                "status"=>"post creer avec success",
                "data"=>$post
            ]);
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }
    public function update(editPostRequest $request,Post $post){
        try {
            $post->title = $request->title;
            $post->description = $request->description;
            if($post->user_id == Auth()->user()->id){
                $post->save();
            }else{
                return response()->json([
                    "status_code"=>422,
                    "status"=>"vous n'etes pas autorisé à modifier ce post",
                ]);
            }
            return response()->json([
                "status_code"=>200,
                "status"=>"modification fait avec success",
                "data"=>$post
            ]);
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }
    public function delete(Post $post){
        try {
            if($post->user_id == Auth()->user()->id){
                $post->delete();
                return response()->json([
                    "status_code"=>200,
                    "status"=>"suppression fait avec success",
                    "data"=>$post
                ]);
            }else{
                return response()->json([
                    "status_code"=>422,
                    "status"=>"vous n'etes pas le propriétaire de ce post donc pas autorisé à supprimer ce post",
                ]);
            }
                
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }
}
