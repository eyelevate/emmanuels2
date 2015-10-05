<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use JavaScript;
use Input;
use Validator;
use Redirect;
use Hash;
use Request;
use Route;
use Response;
use Auth;
use URL;
use Session;
use Laracasts\Flash\Flash;
use View;
use App\Http\Requests;
use App\Job;
use App\User;
use App\Admin;
use App\Role;
use App\Permission;
use App\PermissionRole;
use App\Website;
use App\Company;
use App\Menu;
use App\Page;

class HomeController extends Controller
{
    public function __construct() {
        // // THIRD TEMPLATE
        $this->layout = "layouts.public_home";

        $init_message = Website::WebInit();
        
        // Check if user is authorized to view the page
        $routes = explode("@", Route::currentRouteAction(), 2);     
        $this->controller = strtolower(str_replace('Controller', '', $routes[0]));
        $this->method = $routes[1];
        $this->parameters = Route::current()->parameters();

        $home_active = ($this->method == 'home') ? 'current' : '';
            $home_nav_active = ($this->method == 'home') ? 'selected="selected"' : '';
        $services_active = ($this->method == 'services') ? 'current' : '';
            $services_nav_active = ($this->method == 'services') ? 'selected="selected"' : '';
        $market_active = ($this->method == 'marketplace') ? 'current' : '';
            $market_nav_active = ($this->method == 'marketplace') ? 'selected="selected"' : '';
        $aboutus_active = ($this->method == 'aboutus') ? 'current' : '';
            $aboutus_nav_active = ($this->method == 'aboutus') ? 'selected="selected"' : '';
        $advice_active = ($this->method == 'advice') ? 'current' : '';
            $advice_nav_active = ($this->method == 'advice') ? 'selected="selected"' : '';
        $contactus_active = ($this->method == 'contactus') ? 'current' : '';
            $contactus_nav_active = ($this->method == 'contactus') ? 'selected="selected"' : '';

        $menu_html = Website::prepareMenuBar();
        View::share('menu_html',$menu_html);

        $nav_html = Website::prepareNavBar();
        View::share('nav_html',$nav_html);

        $home_page = Page::find(1);
        $slider_images = isset($home_page->slider_image)?json_decode($home_page->slider_image):null;
        View::share('slider_images',$slider_images);

        View::share('home_active',$home_active);
        View::share('services_active',$services_active);
        View::share('market_active',$market_active);
        View::share('aboutus_active',$aboutus_active);
        View::share('advice_active',$advice_active);
        View::share('contactus_active',$contactus_active);
        View::share('home_nav_active',$home_nav_active);
        View::share('services_nav_active',$services_nav_active);
        View::share('market_nav_active',$market_nav_active);
        View::share('aboutus_nav_active',$aboutus_nav_active);
        View::share('advice_nav_active',$advice_nav_active);
        View::share('contactus_nav_active',$contactus_nav_active);
   
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function home()
    {
        $web_data = array();
        $home = Page::find(1);
        $home_content = isset($home)?json_decode($home->content_data):null;
        return view('home.home')
        ->with('web_data',$web_data)
        ->with('layout',$this->layout)
        ->with('home_content',$home_content);

    }
    public function services()
    {
        $web_data = array();
        return view('home.home')
        ->with('layout','layouts.pages')
        ->with('web_data',$web_data);

    }
    public function marketplace()
    {
        $web_data = array();
        return view('home.home')
        ->with('layout','layouts.pages')
        ->with('web_data',$web_data);

    }
    public function aboutus()
    {
        $web_data = array();
        return view('home.home')
        ->with('layout','layouts.pages')
        ->with('web_data',$web_data);

    }
    public function advice()
    {
        $web_data = array();
        return view('home.home')
        ->with('layout','layouts.pages')
        ->with('web_data',$web_data);

    }
    public function contactus()
    {
        $web_data = array();
        return view('home.home')
        ->with('layout','layouts.pages')
        ->with('web_data',$web_data);

    }
}
