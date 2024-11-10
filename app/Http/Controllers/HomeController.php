<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;


class HomeController extends Controller
{
    private $post;
    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $user)
    {
        // $this->middleware('auth');

        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $all_posts = $this->post->latest()->get();
        // ROW SQL: SELECT * FROM posts ORDER BY created_at DESC

        // return view('users.home')->with('all_posts', $all_posts);

        $home_posts = $this->getHomePosts();
        $suggested_users = $this->getSuggestedUsers();
        $all_suggested_users = $this->getAllSuggestedUsers();

        return view('users.home')->with('home_posts', $home_posts)
                                 ->with('suggested_users', $suggested_users)
                                 ->with('all_suggested_users', $all_suggested_users);
    }

    private function getHomePosts(){
        $home_posts = [];
        $all_posts = $this->post->latest()->get();

        foreach ($all_posts as $post){
            if (Auth::user()->id == $post->user_id || $post->user->isFollowed()) {
                $home_posts[] = $post;
            }
        }

        return $home_posts;
    }

    # Get the users that the Auth user is not following
    private function getSuggestedUsers(){
        $suggested_users =[];
        $all_users = $this->user->get();
        // $all_users = $this->user->all()->except(Auth::user()->id);  also works to remove Auth user from $suggested_users

        foreach ($all_users as $user){
            if(Auth::user()->id !== $user->id && !$user->isFollowed()){
                $suggested_users[] = $user;
            }
        }

        return array_slice($suggested_users, 0, 10);
        /* 
        array_slice(x, y, z)
        x -- array
        y -- offset/starting index
        z -- length/how many
        */
    }

    private function getAllSuggestedUsers(){
        $all_suggested_users =[];
        $all_users = $this->user->get();
        // $all_users = $this->user->all()->except(Auth::user()->id);  also works to remove Auth user from $suggested_users

        foreach ($all_users as $user){
            if(Auth::user()->id !== $user->id && !$user->isFollowed()){
                $all_suggested_users[] = $user;
            }
        }

        return array_slice($all_suggested_users, 10, count($all_suggested_users));

    }

    # Search for a user name from the database
    public function search(Request $request){

        $users = $this->user->where('name', 'like', '%'. $request->search . '%')->get();
        // LIKE %

        return view('users.search')->with('users', $users)
                                   ->with('search', $request->search);

        /*
        LIKE ra&
         -- Rachel
         -- Rafael
         -- Raymond

        LIKE %ra
         -- Laura
         -- Sara

        LIKE %ra%
         -- 
        */
    }
}
