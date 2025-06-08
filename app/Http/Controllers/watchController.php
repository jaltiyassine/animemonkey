<?php

namespace App\Http\Controllers;

class watchController extends HomeController
{
    public function anime(int $jikanID, string $slug, string $ep = null)
    {
        $parentView = parent::anime($jikanID, $slug, $ep);
    
        $data = $parentView->getData();

        return view('watch', $data);
    }
}
