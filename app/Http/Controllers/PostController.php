<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
  public function create(){
    return view('post.create');
  }
  public function store(Request $request){
    Post::create([
        'title' => $request->title,
        'content' => $request->content
      ]);
    return ['message' => 'posted successfully'];
  }
}
