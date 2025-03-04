<?php

namespace App\Http\Controllers;




use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Auth;
use App\Notifications\RepliedNotification;

class PostController extends Controller
{

    public function index(Request $request)


    {
        if ($request->has('query')) {
            $query = $request->query;
            $posts = Post::where('title', 'LIKE', '%' . $query . '%')
                ->orWhere('content', 'LIKE', '%' . $query . '%')
                ->orWhere('content', 'LIKE', '%' . $query . '%')
                ->paginate(12);


            return view('post.index', compact('posts'));
        } else {
            $posts = Post::with('user')->paginate(12);

            return view('post.index', compact('posts'));
        }
    }
    public function post()
    {
        return view('post.post');
    }

    public function postStore(Request $request)
    {

        

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|mimes:jpeg,jpg,svg,png,gif,mp4,mov,avi,wmv,flv,webm|max:51200',
            'content' => 'required|string|max:1024',

        ], [
            'file.max' => 'la taille max de fichier est de 50 Mo',
            'file.mimes' => 'le format du  fichier est incorect',
            'file.required' => 'le fichier est requis'
        ]);
        $posts = new Post();


        $file = $request->file('file');
        
        if ($file) {
            $path = $file->store('Upload', 'public');
            $posts->file = $file->getClientOriginalExtension();
            $posts->path = $path;
        }



        $posts->title = $request->title;

        $posts->content = $request->content;
        $posts->user_id = Auth::user()->id;
        $posts->save();
        return redirect()->back()->with('success', 'post added');
    }

    public function show($hashid, $connection = 'main')
    {
        $user = User::all();
        $decoded = Hashids::connection($connection)->decode($hashid);
        if (!$decoded) {
            return redirect()->back()->with('error', 'id du post invalide');
        }
        $post = Post::find($decoded[0]);

        if (!$post) {
            return redirect()->back()->with('error', 'le post n existe pas');
        }

        return view('post.show', compact('post', 'user'));
    }

    public function postEdit($hashid, $connection = 'main')
    {

        $decoded = Hashids::connection($connection)->decode($hashid);
        if (!$decoded) {
            return redirect()->back()->with('error', 'id du post invalide');
        }
        $post = Post::find($decoded[0]);

        if (!$post) {
            return redirect()->back()->with('error', 'le post n existe pas');
        }
        return view('post.edit', compact('post'));
    }

    public function postUpdate(Request $request, $hashid, $connection = 'main')
    {


        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1024',

            'file' => 'nullable|mimes:jpeg,jpg,svg,png,gif,mp4,mov,avi,wmv,flv,webm|max:10248',



        ]);
        $decodeId = Hashids::connection($connection)->decode($hashid);

        if (!$decodeId || empty($decodeId)) {
            return redirect()->back()->with('error', 'id du post invalide');
        }
        $post = Post::find($decodeId[0]);

        if (!$post) {
            return redirect()->back()->with('error', 'le post n existe pas');
        }
        $file = $request->file('file');
        
        if ($file) {
            $path = $file->store('Upload', 'public');
            $post->file = $file->getClientOriginalExtension();
            $post->path = $path;
        }



        $post->title = $request->title;
        $post->user_id = Auth::user()->id;
        $post->content = $request->content;


        $post->save();

        $user = Auth::user();
        return redirect()->back()->with('success', 'votre post a été mis à jour merci   ' . $user->name);
        return redirect()->route('home');
    }

    public function postDelete($hashid, $connection = 'main')
    {
        $decodeId = Hashids::connection($connection)->decode($hashid);

        if (!$decodeId || empty($decodeId)) {
            return redirect()->back()->with('error', 'id du post invalide');
        }
        $post = Post::find($decodeId[0]);
        $post->delete();

        $user = Auth::user();
        return redirect()->back()->with('success', 'votre post a été supprimer avec succés   ' . $user->name);
        return redirect('/');
    }

    public function createComment($hashid, $connection = 'main')
    {
        $decodeId = Hashids::connection($connection)->decode($hashid);

        if (!$decodeId || empty($decodeId)) {
            return redirect()->back()->with('error', 'id du post invalide');
        }
        $post = Post::find($decodeId[0]);
        return view('post.comment', compact('post'));
    }

}
