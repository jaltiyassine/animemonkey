<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class SearchAnimeController extends Controller
{
    private $apiJikan = "https://api.jikan.moe/v4";

    public function search(){
        $text = request("q");
        $res = Http::get($this->apiJikan."/anime?q=$text&limit=5");

        if ($res->successful()) {
            $data = $res->json()['data'];
            
            $newData = array();

            foreach($data as $animeResult){
                if($animeResult["images"]["webp"]["large_image_url"] == "https://cdn.myanimelist.net/img/sp/icon/apple-touch-icon-256.png"){
                    $poster = "/img/none.webp";
                }else{
                    $poster = $animeResult["images"]["webp"]["large_image_url"];
                }

                switch($animeResult["status"]){
                    case "Currently Airing":
                        $status = "يعرض الان";break;
                    case "Finished Airing":
                        $status = "مكتمل";break;
                    case "Not Yet Aired":
                        $status = "لم يعرض بعد";break;
                    default:
                        $status = "غير محدد";break;
                }

                $slug = HomeController::createSlug($animeResult["title"]);

                array_push($newData, [
                    "mal_id" => $animeResult["mal_id"],
                    "name" => $animeResult["title"],
                    "poster" => $poster,
                    "slug" => $slug,
                    "rating" => isset($animeResult["score"]) ? $animeResult["score"] : "0.0",
                    "status" => $status,
                    "date" => ($animeResult["aired"]["string"] == "Not available")? 'تاريخ غير معروف' : $animeResult["aired"]["string"],
                    'eng_title' => $animeResult["title_english"],
                ]);
            }

            return $newData;
            
        }else{
            abort(500);
        }
    }

    public function searchList(){
        $text = request("q");
        $res = Http::get($this->apiJikan."/anime?q=$text&limit=25");

        if ($res->successful()) {
            $data = $res->json()['data'];

            $anime_array = array();

            foreach ($data as $anime) { 
                if($anime["type"] == "TV"){
                    $year = $anime["year"];
                }else{
                    $year = $anime["aired"]["prop"]["from"]["year"];
                }

                $slug = HomeController::createSlug($anime["title"]);

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
                    'slug' => $slug,
                    'jikanID' => $anime["mal_id"],
                    'show_type' => $anime["type"],
                    'eng_title' => $anime["title_english"],
                ];

                array_push($anime_array, $prepare_data);
            }

            $srry = request('srry');
            if(isset($srry) && $srry == 1){
                return view('search', ['data' => $anime_array, 'srry'=>true]);
            }else{
                return view('search', ['data' => $anime_array, 'srry'=>false]);
            }

        }else{
            abort(500);
        }
    }
}
