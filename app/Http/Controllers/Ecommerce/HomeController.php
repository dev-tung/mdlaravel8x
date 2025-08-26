<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TaxonomyRepository;

class HomeController extends Controller
{
    protected $taxonomyRepository;

    function __construct(TaxonomyRepository $taxonomyRepository) {
        $this->taxonomyRepository = $taxonomyRepository;
    }

    public function index(Request $request){
        $taxonomies = $this->taxonomyRepository->homePage();
        return view('ecommerce.home.index',['taxonomies' => $taxonomies]);
    }
}
