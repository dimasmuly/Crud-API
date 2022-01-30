<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
                 'title' => 'required',
                 'category' => 'required',
                 'description' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $blog = new Blog;
        $blog->title = $request->title;
        $blog->category = $request->category;
        $blog->description = $request->description;
        $is_save = $blog->save();
        if($is_save){
            $status = 201;
            $data = array (
                'message' => 'Blog Berhasil di buat',
                'data' => $blog
            );
        }else{
            $data = array(
                'message' => 'Blog Gagal di buat',
            );
            $status = 400;
        }
        return response()->json($data, $status);
    }

    public function show($id)
    {
        $blog = Blog::find($id);
        if($blog){
            $status = 200;
            $data = array(
                'message' => 'Data terlihat',
                'data' => $blog
            );
        }else{
            $data = array(
                'message' => 'Data tidak ada',
            );
            $status = 400;
        }
        return response()->json($data, $status);
    }

    public function update(Request $request, $id)
    {
       $validator = Validator::make($request->all(), [
        'title' => 'required',
        'category' => 'required',
        'description' => 'required'
       ]);
          if($validator->fails()){
          return response()->json($validator->errors(), 422);
      }
      $blog = Blog::find($id);
      if($blog){
        $blog->title = $request->title;
        $blog->category = $request->category;
        $blog->description = $request->description;
        $is_save = $blog->save(); 
        if($is_save){
            $status = 201;
            $data = array (
              'message' => 'Blog berhasil di ubah',
              'data' => $blog
            );
        }else{
            $data = array(
                'message' => 'Blog gagal di ubah',
        );
            $status = 400;
    }
        }else{
             $data = array(
            'message' => 'Data not found'
        );
            $status = 400;
    }
      return response()->json($data, $status);
    }

    public function delete($id)
    {
        $blog = Blog::find($id);
        if($blog){
            $is_delete = $blog->delete();
            if($is_delete){
                $data = array(
                   'message' => 'Data Berhasil di hapus'
                );
                $status = 200;
            }else{
                $data = array(
                    'message' => 'Data gagal di hapus'
                );
             $status = 400;
            }
        }else{
            $data = array(
                'message' => 'Data Not found'
            );
           $status = 400; 
        }
        return response()->json($data,$status);
        }
        public function search(Request $request)
        {
            $keyword = $request->search;
            $users = Blog::where('title','like','%'.$keyword. '%')->paginate(5);
            
        }
    }

