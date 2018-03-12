<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\EstateType;
use App\Models\Cate;
use App\Models\SanPham;
use App\Models\SpThuocTinh;
use App\Models\SpHinh;
use App\Models\ThuocTinh;
use App\Models\LoaiThuocTinh;
use App\Models\Banner;
use App\Models\Location;
use App\Models\TinhThanh;
use App\Models\HoverInfo;
use App\Models\Pages;
use App\Models\MetaData;
use Helper, File, Session, Auth, DB;

class CateController extends Controller
{
    
    public static $loaiSp = []; 
    public static $loaiSpArrKey = [];    

    public function __construct(){
        
       

    }
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
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
        $slug = $request->slug;
        $rs = EstateType::where('slug', $slug)->first();
        
        if($rs){//danh muc cha
            $estate_type_id = $rs->id;
            
            $query = SanPham::where('estate_type_id', $estate_type_id)
                ->where('so_luong_ton', '>', 0)
                ->where('price', '>', 0)
                ->where('chieu_dai', '>', 0)
                ->where('chieu_rong', '>', 0)
                ->where('chieu_cao', '>', 0)
                ->where('can_nang', '>', 0)
                ->leftJoin('sp_hinh', 'sp_hinh.id', '=','product.thumbnail_id')
                ->leftJoin('sp_thuoctinh', 'sp_thuoctinh.sp_id', '=','product.id')
                ->select('sp_hinh.image_url', 'product.*', 'thuoc_tinh');
                if($rs->price_sort == 0){
                    $query->where('price', '>', 0)->orderBy('product.price', 'asc');
                }else{
                    $query->where('price', '>', 0)->orderBy('product.price', 'desc');
                }
                //->where('sp_hinh.image_url', '<>', '')
                $query->orderBy('product.id', 'desc');

                $productList  = $query->paginate(2);
                $productArr = $productList->toArray();

           

            $hoverInfo = HoverInfo::where('estate_type_id', $rs->id)->orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();
            $socialImage = $rs->banner_menu;
            if( $rs->meta_id > 0){
               $seo = MetaData::find( $rs->meta_id )->toArray();
            }else{
                $seo['title'] = $seo['description'] = $seo['keywords'] = $rs->name;
            }                                     
            return view('frontend.cate.parent', compact('productList','productArr', 'rs', 'hoverInfo', 'socialImage', 'seo'));
        }else{
            $detailPage = Pages::where('slug', $slug)->first();
            if(!$detailPage){
                return redirect()->route('home');
            }
           
            $seo['title'] = $detailPage->meta_title ? $detailPage->meta_title : $detailPage->title;
            $seo['description'] = $detailPage->meta_description ? $detailPage->meta_description : $detailPage->title;
            $seo['keywords'] = $detailPage->meta_keywords ? $detailPage->meta_keywords : $detailPage->title;           
            return view('frontend.pages.index', compact('detailPage', 'seo', 'slug'));    
        }
    }
    public function getSeoInfo($meta_id){

    }
   public function banChay(Request $request)
    {

        $productArr = [];
        $slugEstateType = $request->slugEstateType;
       
        $rs = EstateType::where('slug', $slugEstateType)->first();
        if(!$rs){
            return redirect()->route('home');
        }
        $estate_type_id = $rs->id;
       

        $cateArr = Cate::where('status', 1)->where('estate_type_id', $estate_type_id)->get();

        
        $query = SanPham::where('estate_type_id', $estate_type_id)->where('so_luong_ton', '>', 0)->where('price', '>', 0)
                ->leftJoin('sp_hinh', 'sp_hinh.id', '=','product.thumbnail_id')
                ->leftJoin('sp_thuoctinh', 'sp_thuoctinh.sp_id', '=','product.id')
                ->select('sp_hinh.image_url', 'product.*', 'thuoc_tinh')              
                ->orderBy('so_lan_mua', 'desc');
                if($rs->price_sort == 0){
                    $query->where('price', '>', 0)->orderBy('product.price', 'asc');
                }else{
                    $query->where('price', '>', 0)->orderBy('product.price', 'desc');
                }
                $query->orderBy('is_hot', 'desc')
                ->orderBy('product.id', 'desc');
                $productArr = $query->limit(24)->get();
        $hoverInfo = HoverInfo::where('estate_type_id', $rs->id)->orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();  
        $seo = Helper::seo();      
        return view('frontend.cate.ban-chay', compact('productArr', 'cateArr', 'rs', 'rsCate', 'hoverInfo', 'seo'));
    }  
    public function sanPhamMoi(Request $request)
    {

        $productArr = [];
        $slugEstateType = $request->slugEstateType;
       
        $rs = EstateType::where('slug', $slugEstateType)->first();
        if(!$rs){
            return redirect()->route('home');
        }
        $estate_type_id = $rs->id;
       

        $cateArr = Cate::where('status', 1)->where('estate_type_id', $estate_type_id)->get();

        
        $query = SanPham::where('estate_type_id', $estate_type_id)->where('so_luong_ton', '>', 0)->where('price', '>', 0)
                ->leftJoin('sp_hinh', 'sp_hinh.id', '=','product.thumbnail_id')
                ->leftJoin('sp_thuoctinh', 'sp_thuoctinh.sp_id', '=','product.id')
                ->select('sp_hinh.image_url', 'product.*', 'thuoc_tinh');
               if($rs->price_sort == 0){
                    $query->where('price', '>', 0)->orderBy('product.price', 'asc');
                }else{
                    $query->where('price', '>', 0)->orderBy('product.price', 'desc');
                }
                $query->orderBy('product.id', 'desc')

                    ->orderBy('is_hot', 'desc');
                $productArr = $query->limit(48)->paginate(24);
        $hoverInfo = HoverInfo::where('estate_type_id', $rs->id)->orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();        
        $seo['title'] = $seo['description'] = $seo['keywords'] = $rs->name ." sản phẩm mới";
        return view('frontend.cate.san-pham-moi', compact('productArr', 'cateArr', 'rs', 'rsCate', 'hoverInfo', 'seo'));
    } 
    public function giamGia(Request $request)
    {

        $productArr = [];
        $slugEstateType = $request->slugEstateType;
       
        $rs = EstateType::where('slug', $slugEstateType)->first();
        if(!$rs){
            return redirect()->route('home');
        }
        $estate_type_id = $rs->id;
       

        $cateArr = Cate::where('status', 1)->where('estate_type_id', $estate_type_id)->get();

        
        $productArr = SanPham::where('estate_type_id', $estate_type_id)->where('is_sale', 1)->where('so_luong_ton', '>', 0)->where('price', '>', 0)
                ->leftJoin('sp_hinh', 'sp_hinh.id', '=','product.thumbnail_id')
                ->leftJoin('sp_thuoctinh', 'sp_thuoctinh.sp_id', '=','product.id')
                ->select('sp_hinh.image_url', 'product.*', 'thuoc_tinh')
                //->where('sp_hinh.image_url', '<>', '')
                ->orderBy('product.id', 'desc')
                ->orderBy('is_hot', 'desc')
                ->limit(48)->paginate(24);
        $hoverInfo = HoverInfo::where('estate_type_id', $rs->id)->orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();        
         $seo['title'] = $seo['description'] = $seo['keywords'] = $rs->name ." giảm giá";
        return view('frontend.cate.giam-gia', compact('productArr', 'cateArr', 'rs', 'rsCate', 'hoverInfo', 'seo'));
    } 
    public function theoGia(Request $request)
    {

        $productArr = [];
        $slugEstateType = $request->slugEstateType;
        $slugGia = $request->slugGia; 
        
        
        $rs = EstateType::where('slug', $slugEstateType)->first();
        if(!$rs){
            return redirect()->route('home');
        }
        $estate_type_id = $rs->id;
        
        $tmp = DB::table('price_range')->where('estate_type_id', $estate_type_id)->where('alias', $slugGia)->first();
        $title = $tmp->name;
        $from = $tmp->from;
        $to = $tmp->to;        
        $cateArr = Cate::where('status', 1)->where('estate_type_id', $estate_type_id)->get();

        
        $query = SanPham::where('estate_type_id', $estate_type_id)->where('so_luong_ton', '>', 0)->where('price', '>', 0)
                ->leftJoin('sp_hinh', 'sp_hinh.id', '=','product.thumbnail_id')
                ->leftJoin('sp_thuoctinh', 'sp_thuoctinh.sp_id', '=','product.id')
                ->select('sp_hinh.image_url', 'product.*', 'thuoc_tinh')
                ->where('price', '>=', $from)
                ->where('price', '<=', $to);
                if($rs->price_sort == 0){
                    $query->where('price', '>', 0)->orderBy('product.price', 'asc');
                }else{
                    $query->where('price', '>', 0)->orderBy('product.price', 'desc');
                }                
                $query->orderBy('product.id', 'desc')
                ->orderBy('is_hot', 'desc');
                $productArr = $query->paginate(24);                
        $hoverInfo = HoverInfo::where('estate_type_id', $rs->id)->orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();        
        
        $seo['title'] = $seo['description'] = $seo['keywords'] = $rs->name ." ".$title;

        return view('frontend.cate.theo-gia', compact('productArr', 'cateArr', 'rs', 'rsCate', 'hoverInfo', 'title', 'seo'));
    } 
    function getGiaFromTo($slugGia){
        switch ($slugGia) {
            case 'duoi-1-trieu':
                $from = 0;
                $to = 1000000;
                $title = "Dưới 1 triệu";
                break;           
            case 'tu-1-den-2-trieu':
                $from = 1000001;
                $to = 2000000;
                $title = "Từ 1 - 2 triệu";
                break;
            case 'tu-2-den-4-trieu':
                $from = 2000001;
                $to = 4000000;
                $title = "Từ 2 - 4 triệu";
                break;
            case 'tu-4-den-8-trieu':
                $from = 4000001;
                $to = 8000000;
                $title = "Từ 4 - 8 triệu";
                break;
            case 'tu-8-den-16-trieu':
                $from = 8000001;
                $to = 16000000;
                $title = "Từ 8 - 16 triệu";
                break;
            case 'tren-16-trieu':
                $from = 16000001;
                $to = 1000000000;
                $title = "Trên 16 triệu";
                break;         
            default:
                $from = 0;
                $to = 100000000;
                $title = "Trên 16 triệu";
                break;
        }
        return ['from' => $from, 'to' => $to, 'title' => $title];
    }
    public function ajaxTab(Request $request){
        $table = $request->type ? $request->type : 'category';
        $id = $request->id;

        $arr = Film::getFilmHomeTab( $table, $id);

        return view('frontend.index.ajax-tab', compact('arr'));
    }
    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function search(Request $request)
    {

        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
        
        $layout_name = "main-category";
        
        $page_name = "page-category";

        $cateArr = $cateActiveArr = $moviesActiveArr = [];

        $tu_khoa = $request->k;
        
        $is_search = 1;

        $moviesArr = Film::where('alias', 'LIKE', '%'.$tu_khoa.'%')->orderBy('id', 'desc')->paginate(20);

        return view('frontend.cate', compact('settingArr', 'moviesArr', 'tu_khoa',  'is_search', 'layout_name', 'page_name' ));
    }

    public function cate(Request $request)
    {

        $productArr = [];
        $slugEstateType = $request->slugEstateType;
        $slug = $request->slug;
        $rs = EstateType::where('slug', $slugEstateType)->first();
        if(!$rs){
            return redirect()->route('home');
        }
        $estate_type_id = $rs->id;
        $rsCate = Cate::where(['estate_type_id' => $estate_type_id, 'slug' => $slug])->first();
        $cate_id = $rsCate->id;

        $cateArr = Cate::where('status', 1)->where('estate_type_id', $estate_type_id)->get();

        
        $query = SanPham::where('cate_id', $rsCate->id)->where('estate_type_id', $estate_type_id)->where('so_luong_ton', '>', 0)->where('price', '>', 0)
                ->leftJoin('sp_hinh', 'sp_hinh.id', '=','product.thumbnail_id')
                ->leftJoin('sp_thuoctinh', 'sp_thuoctinh.sp_id', '=','product.id')
                ->select('sp_hinh.image_url', 'product.*', 'thuoc_tinh');
                    if($rs->price_sort == 0){
                        $query->where('price', '>', 0)->orderBy('product.price', 'asc');
                    }else{
                        $query->where('price', '>', 0)->orderBy('product.price', 'desc');
                    }
                $query->orderBy('product.id', 'desc');
                $productArr = $query->paginate(24);
        $hoverInfo = HoverInfo::where('estate_type_id', $rs->id)->orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();  
        $socialImage = $rsCate->icon_url;
        if( $rsCate->meta_id > 0){            
           $seo = MetaData::find( $rsCate->meta_id )->toArray();           
        }else{
            $seo['title'] = $seo['description'] = $seo['keywords'] = $rsCate->name;
        }
        
        return view('frontend.cate.child', compact('productArr', 'cateArr', 'rs', 'rsCate', 'hoverInfo', 'socialImage', 'seo'));
    }    
    
    

    public function newsList(Request $request)
    {
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
        $layout_name = "main-news";
        
        $page_name = "page-news";

        $cateArr = $cateActiveArr = $moviesActiveArr = [];
       
        $cateDetail = ArticlesCate::where('slug' , 'tin-tuc')->first();
        $title = trim($cateDetail->meta_title) ? $cateDetail->meta_title : $cateDetail->name;

        $articlesArr = Articles::where('cate_id', 1)->orderBy('id', 'desc')->paginate(10);
        $hotArr = Articles::where( ['cate_id' => 1, 'is_hot' => 1] )->orderBy('id', 'desc')->limit(5)->get();
        return view('frontend.news-list', compact('title','settingArr', 'hotArr', 'layout_name', 'page_name', 'articlesArr'));
    }

    public function newsDetail(Request $request)
    {
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
        $layout_name = "main-news";
        
        $page_name = "page-news";

        $id = $request->id;

        $detail = Articles::where( 'id', $id )
                ->select('id', 'title', 'slug', 'description', 'image_url', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'custom_text')
                ->first();
        if(!$detail){
            return redirect()->route('home');
        }

        if( $detail ){
            $cateArr = $cateActiveArr = $moviesActiveArr = [];
        
            
            $title = trim($detail->meta_title) ? $detail->meta_title : $detail->title;

            $hotArr = Articles::where( ['cate_id' => 1, 'is_hot' => 1] )->where('id', '<>', $id)->orderBy('id', 'desc')->limit(5)->get();

            return view('frontend.news-detail', compact('title', 'settingArr', 'hotArr', 'layout_name', 'page_name', 'detail'));
        }else{
            return view('erros.404');
        }     

        
    }

}
