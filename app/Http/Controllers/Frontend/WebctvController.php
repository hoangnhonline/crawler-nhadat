<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Product;
use App\Models\District;
use App\Models\Ward;
use App\Models\Street;
use App\Models\Project;
use App\Models\EstateType;
use App\Models\MetaData;
use App\Models\Pages;
use App\Models\Cate;

use Helper, File, Session, Auth;
use Mail;

class WebctvController extends Controller
{
    public function webctv(Request $req, $idctv, $idpro)
    	{
     		
		return view('frontend.webhtml');
	}
  
}