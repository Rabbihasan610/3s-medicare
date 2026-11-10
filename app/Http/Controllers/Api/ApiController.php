<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Blog;
use App\Models\City;
use App\Models\Form;
use App\Models\Page;
use App\Models\Event;
use App\Models\Auction;
use App\Models\Country;
use App\Models\EventAsk;
use App\Models\Property;
use App\Models\EventNews;
use App\Models\AllCategory;
use App\Traits\ApiResponse;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use App\Models\FinanceRequest;
use App\Models\ServiceRequest;
use App\Models\BusinessRequest;
use App\Models\PropertyRequest;
use App\Models\SubpropertyType;
use App\Models\MarketingRequest;
use App\Models\PromotionRequest;
use App\Models\PropertyFormRequest;
use App\Models\PropertyRequestSend;
use App\Models\SocialInvestRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AssetliabilitieRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\AiService;

class ApiController extends Controller
{
    use ApiResponse;

    public function countries()
    {
        $o_countries = Country::orderByRaw('ISNULL(sort_order), sort_order')->with('city')->get();
        $countries = sortOrder($o_countries);
        return $this->successResponse($countries, 'countries');
    }

    public function allcountries()
    {
        $countriesAll = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        return $this->successResponse($countriesAll, 'countries');
    }

    public function cities($country_id)
    {
        try {
           $cities = City::where('country_id', $country_id)->get();

           return $this->successResponse($cities, 'cities');
        } catch (Exception $e) {
            return $this->serverError();
        }
    }


    public function blogs()
    {
        try {
             $blogs = Blog::active()->paginate(getPaginate());
            $sections = Page::where('slug', 'blogs')->first();

            $data['blogs'] = $blogs;
            $data['sections'] = $sections;

            return $this->successResponse($data);
        }catch(Exception $e){
            return $this->serverError('Something went wrong');
        }

    }

    public function blogDetails($slug)
    {
        try {
            $blog = Blog::active()->where('slug', $slug)->first();
            $blog->view = $blog->view + 1;
            $blog->save();

            $recentPosts = Blog::active()->where('id', '!=', $blog->id)->orderBy('id', 'desc')->limit(5)->get();
            $popularPosts = Blog::active()->where('id', '!=', $blog->id)->orderBy('view', 'desc')->limit(5)->get();

            $data['blog'] = $blog;
            $data['recentPosts'] = $recentPosts;
            $data['popularPosts'] = $popularPosts;

            return $this->successResponse($data);
        }catch(Exception $e){
            return $this->serverError('Something went wrong');
        }


        return view('web.blog_details', compact('blog', 'recentPosts', 'popularPosts'));
    }




}
