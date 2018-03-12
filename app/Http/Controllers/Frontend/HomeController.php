<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\EstateType;
use App\Models\Product;
use App\Models\Banner;
use App\Models\Location;
use App\Models\City;
use App\Models\District;
use App\Models\Ward;
use App\Models\Street;
use App\Models\Project;
use App\Models\Articles;
use App\Models\ArticlesCate;
use App\Models\Account;
use App\Models\Newsletter;
use App\Models\PriceRange;
use App\Models\Video;
use App\Models\Price;
use App\Models\Area;
use App\Models\Settings;
use Helper, File, Session, Auth, Hash;

class HomeController extends Controller
{
    
    public static $loaiSp = []; 
    public static $loaiSpArrKey = [];    

    public function __construct(){       


    }    
    public function getChild(Request $request){
        $module = $request->mod;
        $id = $request->id;
        $column = $request->col;
        return Helper::getChild($module, $column, $id);
    }
    public function index(Request $request)
    {         
        if(Session::get('userId')){
            $userId = Session::get('userId');
            $detail = Account::find($userId);
            
            if($detail->full_name == null || 
                $detail->phone == null || 
                $detail->cmnd == null || 
                $detail->address == null || 
                $detail->nghe_nghiep == null || 
                $detail->bank_info == null
                ){                                
                return redirect()->route('xem-thong-tin');
            }
        }

        $productArr = [];        
        $loaiSp = EstateType::where('status', 1)->get();
        $bannerArr = [];          
        $articlesArr = Articles::where(['cate_id' => 1])->orderBy('id', 'desc')->get();
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
        $seo = $settingArr;
        $seo['title'] = $settingArr['site_title'];
        $seo['description'] = $settingArr['site_description'];
        $seo['keywords'] = $settingArr['site_keywords'];
        $socialImage = $settingArr['banner'];
	$commission = Product::orderByRaw('(hoa_hong_ctv * hoa_hong * price/100/100) desc')
		    ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')        
                    ->join('estate_type', 'estate_type.id', '=','product.estate_type_id')                  
                    ->select('product_img.image_url as image_url', 'product.*', 'estate_type.slug as slug_loai')
		    ->limit(6)->get();

        $estateTypeList = EstateType::where('status', 1)->get();
        foreach($estateTypeList as $estate_type){
            $productArr[$estate_type->id] = Product::where('estate_type_id', $estate_type->id)->where('product.cart_status', 1)
                    ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')        
                    ->join('estate_type', 'estate_type.id', '=','product.estate_type_id')                  
                    ->select('product_img.image_url as image_url', 'product.*', 'estate_type.slug as slug_loai')
                    ->orderBy('is_hot', 'desc')
                    ->orderBy('id', 'desc')
                    ->limit('9')
                    ->get();
        }        
        $joinedProductArrId = [];
        if(Session::get('userId') > 0){
            $joinedProductArrId = Account::joinedProduct(Session::get('userId'));       
        }
        return view('frontend.home.index', compact('hoahongcao', 'commission', 'bannerArr', 'articlesArr', 'socialImage', 'seo', 'estateTypeList', 'productArr', 'joinedProductArrId'));

    }

    public function getNoti(){
        $countMess = 0;
        if(Session::get('userId') > 0){
            $countMess = CustomerNotification::where(['customer_id' => Session::get('userId'), 'status' => 1])->count();    
        }
        return $countMess;
    }
    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function search(Request $request)
    {
        $tu_khoa = $request->keyword;       

        $productArr = Product::where('product.alias', 'LIKE', '%'.$tu_khoa.'%')->where('so_luong_ton', '>', 0)->where('price', '>', 0)->where('estate_type.status', 1)                        
                        ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')                        
                        ->join('estate_type', 'estate_type.id', '=', 'product.estate_type_id')
                        ->select('product_img.image_url', 'product.*', 'thuoc_tinh')
                        ->orderBy('id', 'desc')->paginate(20);
        $seo['title'] = $seo['description'] =$seo['keywords'] = "Tìm kiếm sản phẩm theo từ khóa '".$tu_khoa."'";
        return view('frontend.search.index', compact('productArr', 'tu_khoa', 'seo'));
    }
    public function ajaxTab(Request $request){
        $table = $request->type ? $request->type : 'category';
        $id = $request->id;

        $arr = Film::getFilmHomeTab( $table, $id);

        return view('frontend.index.ajax-tab', compact('arr'));
    }
    public function contact(Request $request){        

        $seo['title'] = 'Liên hệ';
        $seo['description'] = 'Liên hệ';
        $seo['keywords'] = 'Liên hệ';
        $socialImage = '';
        return view('frontend.contact.index', compact('seo', 'socialImage'));
    }

    

    public function registerNews(Request $request)
    {

        $register = 0; 
        $email = $request->email;
        $newsletter = Newsletter::where('email', $email)->first();
        if(is_null($newsletter)) {
           $newsletter = new Newsletter;
           $newsletter->email = $email;
           $newsletter->is_member = Account::where('email', $email)->first() ? 1 : 0;
           $newsletter->save();
           $register = 1;
        }

        return $register;
    }

}
