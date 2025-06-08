<?php

namespace App\Http\Controllers;

class AnimeListController extends Controller
{
    public function index(){
        return view("anime_list");
    }
}
