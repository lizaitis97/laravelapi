<?php

namespace App\Http\Controllers;

use App\Models\Blogpost;
use App\Models\Comment;
use Illuminate\Http\Request;

class BlogpostController extends Controller
{
    public function index(Request $request)
    {
        if ($request->embed === "comments")
            return Blogpost::with('comments')->get();
        return Blogpost::all();
    }

    public function store(Request $request)
    {
        // do not forget to add header "Accept: application/json"
        // ... if not failed validation will result in html view returned,
        // ... not json response 422, which is the standard way
        $request->validate([
            'title' => 'required|unique:blogposts,title|max:255',
            'text' => 'required|max:255',
        ]);
        return Blogpost::create($request->all());
    }

    public function show($id, Request $request)
    {
        if ($request->embed === "comments")
            return Blogpost::with('comments')->find($id);
        return Blogpost::find($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:blogposts,title,' . $id . ',id|max:255',
            'text' => 'required|max:255',
        ]);
        $blogpost = Blogpost::find($id);
        $blogpost->update($request->all());
        return $blogpost;
    }

    public function destroy($id)
    {
        return Blogpost::destroy($id) === 0


            ? response(["status" => "failure"], 404)
            : response(["status" => "success"], 200);
    }
    
    public function storePostComment($id, Request $request)
    {
        $request->validate(['text' => 'required|max:255']);
        return Blogpost::find($id)
            ->comments()
            ->save(Comment::create($request->all()));
    }
}