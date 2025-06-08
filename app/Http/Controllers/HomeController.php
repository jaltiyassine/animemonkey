<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use DateTime;

class HomeController extends Controller
{
    protected $apiJikan = "https://api.jikan.moe/v4";

    public function index()
    {
        $page = request('page');
        if(!isset($page) || empty($page)){
            $page = 1;
        }

        $anime_array = array();
        $res = Http::get($this->apiJikan . "/top/anime?page={$page}&filter=bypopularity");

        if ($res->successful()) {
            $data = $res->json()['data'];
            foreach ($data as $anime) { 
                if($anime["type"] == "TV"){
                    $year = $anime["year"];
                }else{
                    $year = $anime["aired"]["prop"]["from"]["year"];
                }

                if($anime["images"]["webp"]["large_image_url"] == "https://cdn.myanimelist.net/img/sp/icon/apple-touch-icon-256.png"){
                    $poster = "/img/none.webp";
                }else{
                    $poster = $anime["images"]["webp"]["large_image_url"];
                }

                $prepare_data = [
                    'cover_image' => $poster,
                    'rating' => is_numeric($anime["score"]) ? number_format((float)$anime["score"], 1) : '0.0',
                    'year' => $year,
                    'name' => $anime["title"],
                    'slug' => $this->createSlug($anime["title"]),
                    'jikanID' => $anime["mal_id"],
                    'show_type' => $anime["type"],
                    'eng_title' => $anime["title_english"],
                ];

                array_push($anime_array, $prepare_data);
            }

            if($page > 1){
                return $anime_array;
            }
            return view('index', ['data' => $anime_array]);

        } else {
            abort(500);
        }
    }

    public function anime(int $jikanID, string $slug, string $ep=null){

        $res = Http::get($this->apiJikan . "/anime/$jikanID");
    
        if ($res->successful()) {
            $data = $res->json()['data'];

            $newEpisodes = [];

            $res1 = Http::get($this->apiJikan."/anime/$jikanID/episodes");
            
            if ($res1->successful()) {
                $data1 = $res1->json()['data'];

                if(empty($data1)){
                    array_push($data1,[
                        "aired" => null,
                        "score" => null,
                    ]);
                }

                for ($i = 0; $i < count($data1); $i++) {
                    if (isset($data1[$i]) && isset($data1[$i]["aired"])) {
                        $date = new \DateTime($data1[$i]["aired"]);

                        $formattedDate = $date->format('F d, Y');

                        array_push($newEpisodes, [
                            "id" => null,
                            "ep" => $i + 1,
                            "date" => $formattedDate,
                            "rating" => (isset($data1[$i]["score"]) && is_numeric($data1[$i]["score"])) ? number_format((float)$data1[$i]["score"], 1) : null,
                        ]);

                    }else{
                        if($data["type"] == "Movie"){
                            $formattedDate = (new DateTime($data["aired"]["from"]))->format("F d, Y");
                            array_push($newEpisodes, [
                                "id" => null,
                                "ep" => $i + 1,
                                "date" => $formattedDate,
                                "rating" => (isset($data1[$i]["score"]) && is_numeric($data1[$i]["score"])) ? number_format((float)$data1[$i]["score"], 1) : null,
                            ]);
                        }else{
                            array_push($newEpisodes, [
                                "id" => null,
                                "ep" => $i + 1,
                                "date" => 'تاريخ غير معروف',
                                "rating" => (isset($data1[$i]["score"]) && is_numeric($data1[$i]["score"])) ? number_format((float)$data1[$i]["score"], 1) : null,
                            ]);
                        }
                    }
                }
            }else{
                abort(500);
            }

            if($data["type"] == "TV"){
                $year = $data["year"];
            }else{
                $year = $data["aired"]["prop"]["from"]["year"];
            }

            if (is_numeric($ep)) {
                $mainEpData = (int) $ep;
            }else{
                $mainEpData = null;
            }

            return view('anime', ['anime' => 
                [
                    'cover_image' => $data["images"]["webp"]["large_image_url"],
                    'rating' => is_numeric($data["score"]) ? number_format((float)$data["score"], 1) : '0.0',
                    'name' => $data["title"],
                    'id' => $data["mal_id"],
                    'myanimelist' => $data["mal_id"],
                    'show_type' => $data["type"],
                    'anime_season' => $data["season"],
                    'year' => $year,
                    'aired_from' => isset($data["aired"]["from"])? $data["aired"]["from"] : $data["aired"]["prop"]["from"]["year"],
                    'anime_trailer' => $data["trailer"]["url"],
                    'slug' => $slug,
                    'title_eng' => $data["title_english"],
                    'anime_status' => null,
                    'anime_genres' => [],
                    'anime_source' => null,
                    'anime_duration' => null,
                    'anime_episodes_num' => null,
                    'episodes' => array_reverse($newEpisodes),
                    'mainEpData' => $mainEpData,
                    'description' => null,
                ]
            ]);
        } else {
            return response()->json(['error' => 'Jikan data not found'], 404);
        }
    }

    static public function createSlug(string $title): string {

        if (empty($title)) {
            return "not-found";
        }
    
        $slug = mb_strtolower($title, 'UTF-8');
    
        $slug = preg_replace('/[^\p{L}\p{N}\p{Sm}\p{Pd}\s]+/u', '', $slug);
    
        $slug = preg_replace('/[\s\-]+/', '-', $slug);
    
        $slug = trim($slug, '-');
    
        if (empty($slug)) {
            $slug = "not-found";
        }
    
        return $slug;
    }
}
