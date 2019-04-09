<?php

namespace App\Http\Controllers;

use App\Models\Cast;
use App\Models\Movies;
use App\Models\Post;
use App\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = [];
        if (\Auth::check()) {
            $user = new User();
            $posts = $user->followedPosts();
        }
        $posts = Post::inRandomOrder()->limit(3)->get();
        $movies = DB::table('movies')->orderBy('created_at', 'desc')->limit(3)->get();

        $videos = DB::table('videos')->inRandomOrder()->first();
        $channel_id = $videos->api_id;
        $api_key = config('youtube.API_Key');

        $json_url = "https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=$channel_id" .
            "&maxResults=10&order=date&type=video&id=$channel_id&key=$api_key";
        $json_url2 = "https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=50&q=%D8%A7%D9%84%D8%B3%D9%8A%D9%86%D9%85%D8%A7%2C+cinema%2Cfilmmaking%2Cfilm+analysis&key=$api_key";

        $youtubeVideo = $this->getVideo($json_url2);
        $channelVideo = $this->getVideo($json_url);
        return view('home', compact('movies', 'youtubeVideo', 'posts', 'channelVideo'));
    }

    /**
     * Search about user, movie or crew
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        $query = \request('query');
        $cast = Cast::where('name', 'like', '%' . $query . '%')->select('id', 'name', 'image')->limit(3)->get();
        $movies = Movies::where('title', 'like', '%' . $query . '%')->select('id', 'title', 'poster')->limit(3)->get();
        $users = User::where('name', 'like', '%' . $query . '%')->select('id', 'name', 'image')->limit(3)->get();
        return view('search', compact('cast', 'movies', 'users'));
    }


    /**
     * Get random Video from json url
     *
     * @param $string
     * @return mixed
     */
    protected function getVideo(string $string)
    {
        $listFromYouTube = json_decode(file_get_contents($string));

        $keys = array_rand($listFromYouTube->items, 6);

        foreach ($keys as $key)
            $video[] = $listFromYouTube->items[$key];

        return $video;
    }

    protected function GetYoutubeVideosByKeyWords(... $keywords)
    {
//        $keywords = func_get_args();

    }

    public function notifications(){

    }

}
