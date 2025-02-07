<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Auth;

use App\Notifications\RepliedNotification;



class CommentController extends Controller
{



   public function comment(Request $request, $postId)
   {
      $request->validate([
         'content' => 'required|string|max:1024',

      ]);


      if (Auth::user()->isBanned()) {
         return redirect()->back()->with('error', 'vous etes banni et vous ne pouvez pas commenter, je suis desolé ' . Auth::user()->name);
      }

      $comment = new Comment();
      $comment->commentable_id = $postId;
      $comment->commentable_type = Post::class;
      $comment->user_id = Auth::user()->id;
      $comment->content = $request->content;
      $comment->parent_id = null;
      $comment->save();
      return redirect()->back()->with('success', 'votre commentaire a été ajouté avec succés');
   }


   public function reply(Request $request, $commentId)
   {
      $request->validate([
         'content' => 'required|string|max:1024',

      ]);


      if (Auth::user()->isBanned()) {
         return redirect()->back()->with('error', 'vous etes banni et vous ne pouvez pas commenter, je suis desolé ' . Auth::user()->name);
      }

      $comment = new Comment();
      $comment->commentable_id = Comment::find($commentId)->commentable_id;
      $comment->commentable_type = Post::class;
      $comment->user_id = Auth::user()->id;
      $comment->content = $request->content;
      $comment->parent_id = $commentId;
      $comment->save();

      if ($comment->parent_id) {
         $commentParent  = Comment::find($comment->parent_id);

         if ($commentParent && $commentParent->user_id !== Auth::id()) {
            $commentParent->user->notify(new RepliedNotification($comment));
         }
      }
      return back();
   }





   public function updateComment(Request $request, $commentId)
   {
      $comment = Comment::find($commentId);
      if (!$comment) {
         abort(404);
      } elseif ($comment->user_id != Auth::id()) {
         return redirect()->back()->with('error', 'vous etes pas l\'auteur du commentaire');
      }
      $comment->content = $request->content;
      $comment->save();

      return back();
   }

   public function deleteComment($commentId)
   {

      $replies = Comment::where('parent_id', $commentId)->get();

      foreach ($replies as $reply) {
         $this->deleteComment($reply->id);
      }

      \App\Models\Like::where('comment_id', $commentId)->delete();
      Comment::where('id', $commentId)->delete();

      return redirect()->route('home')->with('success', 'commentaire supprimer avec succes');
   }

   public function delete($commentId)
   {
      $comment = Comment::find($commentId);
      if (!$comment) {
         return redirect()->back()->with('error', 'aucun commentaire disponible pour ce post');
      } elseif ($comment->user_id != Auth::id()) {
         return redirect()->back()->with('error', 'vous etes pas l\'auteur du commentaire');
      }
      $this->deleteComment($commentId);

      return redirect()->route('home')->with('success', 'commentaire supprimer avec succes');
   }



   public function likeComment(Comment $comment)
   {

      $user = auth()->user();
      if ($comment->likes()->where('user_id', $user->id)->exists()) {

         $comment->likes()->where('user_id', $user->id)->delete();
      } else {
         $comment->likes()->create(['user_id' => $user->id]);
      }
      return back();
   }

   public function replyLike($replyId)
   {
      $user = auth()->user();
      $reply = Comment::find($replyId);
      if ($reply->likes()->where('user_id', $user->id)->exists()) {

         $reply->likes()->where('user_id', $user->id)->delete();
      } else {
         $reply->likes()->create(['user_id' => $user->id]);
      }
      return back();
   }

   public function show(Comment $comment)
   {


      try{
         
      }catch(ModelNotFoundException $e){
         return redirect()->route('home')->with('error', 'aucun commentaire disponible pour ce post');
      }
      if (!$comment) {
         dd('ww');
         
      }
      $post = Post::find($comment->commentable_id);

      if (!$post) {
         return redirect()->back()->with('error', 'le post n existe pas');
      }

      return view('comment._comment', compact('comment', 'post'));
   }
}


