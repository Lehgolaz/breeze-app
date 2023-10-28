<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Posts/Index', [
            'posts' => Post::orderBy('update_at', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Posts/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $post = $request->validated();

        if($request->hasFile('imagem_destaque')){
            $filePath = Storage::disck('public')->put('images/posts/feature-images', request()->file('imagem_destaque'));
            $post['imagem_destaque'] = $filePath;
        }
        $create = Post::create($post);
        if ($create){
            return redirect ()->route('post.index');
        }
        return abort(500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('Posts/Show', [ 'post' => Post::findOrFail($id),]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render(
            'Posts/Edit',
            [
                'post' => Post::findOrFail($id),
            ]
            );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id)
    {
        $post = Post::findOrFail($id);
        $validated = $request->validated();

        if ($request->hasFile('imagem_destaque')) {
            //delte a imagem
            Storage::disk('public')->delete($post->imagem_destaque);

            $filePath = Storage::disk('public')->put('images/posts/featured-images', 
            request()->file('imagem_destaque'), 'public');
            $validated['image,_destaque'] = $filePath;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::FinOrFail($id);

        Storage::disk('public')->delete($post->featured_image);

        $delete = $post->delete($id);

        if ($delete) {
            return redirect()->route('posts.index');
        }
        return abort(500);
    }
}
