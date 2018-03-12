<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\LandingProjects;
use App\Models\ArticlesCate;
use App\Models\Pages;
use App\Models\Menu;
use App\Models\Account;
use App\Models\Product;
use App\Models\CtvJoinSale;

use DB, Session, Auth;
class GeneralController extends Controller
{
    public function updateOrder(Request $request){
        if ($request->ajax())
        {
        	$dataArr = $request->all();
        	$str_order = $dataArr['str_order'];        	
            $table = $dataArr['table'];        
            if( $str_order ){
            	$tmpArr = explode(";", $str_order);
            	$i = 0;
            	foreach ($tmpArr as $id) {
            		if( $id > 0 ){
            			$i++;
            			DB::table($table)
				        ->where('id', $id)				        
				        ->update(array('display_order' => $i));			
            		}
            	}
            }
        }        
    }

    public function updateStatus(Request $request){
        if ($request->ajax())
        {
            $column = $request->col;
            $table = $request->table;
            $status = $request->status;
            $id = $request->id;
            DB::table($table)->where('id', $id)->update([$column => $status, 'updated_user' => Auth::user()->id ]);
            
            // set giao dich thanh cong
            if($column == "is_success" && $status == 1){
                $sales = CtvJoinSale::find($id);
                $product_id = $sales->product_id;
                $detailProduct = Product::find($product_id);
                if($sales->type_sale == 2){ // de lai so dien thoai
                    //$sales->hh_ctv = ($detailProduct->hoa_hong_ctv*$detailProduct->price/100)/2;
                    $sales->hh_ctv = ($detailProduct->hoa_hong_ctv*$detailProduct->hoa_hong*$detailProduct->price/100/100);
                    $sales->hh_pr = $detailProduct->hoa_hong_pr*$detailProduct->hoa_hong*$detailProduct->price/100/100;
                    $sales->hh_cs = $detailProduct->hoa_hong_cs*$detailProduct->hoa_hong*$detailProduct->price/100/100;
                }else{
                    $sales->hh_ctv = $detailProduct->hoa_hong_ctv*$detailProduct->hoa_hong*$detailProduct->price/100/100;
                    $sales->hh_pr = 0;
                    $sales->hh_cs = ($detailProduct->hoa_hong_cs+$detailProduct->hoa_hong_pr)*$detailProduct->hoa_hong*$detailProduct->price/100/100;
                }
                $sales->save();

                 //update CTV sales
                $rsJoin = CtvJoinSale::where('product_id', $product_id)->get();
                if($rsJoin->count() > 0){
                    foreach($rsJoin as $join){
                        $newJoin = CtvJoinSale::find($join->id);                        
                        $newJoin->is_close = 2;                 
                        $newJoin->save();
                    }
                }
                
            }

        }        
    }
    
    public function getSlug(Request $request){
    	$strReturn = '';
    	if( $request->ajax() ){
    		$str = $request->str;
    		if( $str ){
    			$strReturn = str_slug( $str );
    		}
    	}
    	return response()->json( ['str' => $strReturn] );
    }
    public function setupMenu(Request $request){
        $landingList = LandingProjects::where('status', 1)->orderBy('id', 'desc')->get();        
        $articlesCateList = ArticlesCate::where('status', 1)->orderBy('display_order', 'asc')->get();
        $pageList = Pages::where('status', 1)->get();
        return view('backend.menu.index', compact( 'landingList', 'articlesCateList', 'pageList'));
    }
    public function renderMenu(Request $request){        
        $dataArr = $request->all();       
        return view('backend.menu.render-menu', compact( 'dataArr' ));   
    }
    public function storeMenu(Request $request){
        $data = $request->all();
        Menu::where('menu_id', 1)->delete();
        if(!empty($data)){
            $i = 0;
            foreach($data['title'] as $k => $title){
                $i++;
                Menu::create([
                    'menu_id' => 1,
                    'title' => $title,
                    'url' => $data['url'][$k],
                    'slug' => $data['slug'][$k],
                    'type' => $data['type'][$k],
                    'object_id' => $data['object_id'][$k],
                    'status' => 1,
                    'title_attr' => $title,
                    'display_order' => $i
                ]);
            }
        }
        Session::flash('message', 'Cập nhật menu thành công.');

        return redirect()->route('menu.index');
    }
}
