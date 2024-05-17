<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function search(Request $request)
{
    $request->validate([
        // "ingredient"=>"required",
        // "dietry"=>"required",
        "recepi"=>"required",
    ]);
    $ingredient = $request->ingredient;
    $dietary = $request->dietry;
    $recipe = $request->recepi;
    // dd($recipe);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.spoonacular.com/recipes/complexSearch?query=$recipe&apiKey=56c217c5e1714ff4a3fc5e50cdcbdf19&apiKey=56c217c5e1714ff4a3fc5e50cdcbdf19",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
      ));

      $response = curl_exec($curl);

      curl_close($curl);

    $response = json_decode($response);
    $html = "";

    if (!empty($response->results)) {
        foreach ($response->results as $result) {
            $html .= '<div class="col-12 col-sm-6 col-lg-4">
                <div class="single-best-recipe-area mb-30">
                    <img src="' . $result->image . '" alt="">
                    <div class="recipe-content">
                        <a href="recipe-post.html">
                            <h5>' . $result->title . '</h5>
                        </a>
                        <div class="ratings">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }else{
        $html.='<div class="col-12 col-sm-6 col-lg-4">
        <div class="single-best-recipe-area mb-30"><p class="text-black">No data found</p></div></div>';
    }

    echo $html;
}

}
