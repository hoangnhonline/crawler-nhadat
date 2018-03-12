<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Hash;
use App\Models\Settings;
use App\Models\EstateType;
use App\Models\ArticlesCate;
use App\Models\Articles;
use App\Models\District;
use App\Models\CustomLink;
use App\Models\LandingProjects;
use App\Models\ProContent;
use App\Models\Price;
use App\Models\Support;
use App\Models\Area;
use App\Models\Menu;
use App\Models\City;
use App\Models\Direction;
use Session;

class ViewComposerServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//Call function composerSidebar
		$this->composerMenu();	
		
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Composer the sidebar
	 */
	private function composerMenu()
	{
		
		view()->composer( '*' , function( $view ){		
			
			$banList = $thueList = [];	
			$estateTypeArr = EstateType::where('status', 1)->get();
			foreach($estateTypeArr as $est){
				if($est->type == 1){
					$banList[] = $est;
				}else{
					$thueList[] = $est;
				}
			}
	        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
	        $articleCate = ArticlesCate::orderBy('display_order', 'desc')->get();	     
	        $cityList = City::whereIn('id', [1, 3, 6, 23, 58])->get();
	        $districtList = District::where('city_id', 1)->where('status',1)->get();	      
	        $priceList = Price::where('type', 1)->get();
        	$areaList = Area::all();
        	$directionList = Direction::all();
        	$routeName = \Request::route()->getName();
			$view->with( ['settingArr' => $settingArr, 
			'banList' => $banList, 'thueList' => $thueList, 'articleCate' => $articleCate, 'districtList' => $districtList, 'priceList' => $priceList, 'areaList' => $areaList,
			'directionList' => $directionList, 		
			'cityList' => $cityList,
			'routeName' => $routeName,
			'estateTypeArr' => $estateTypeArr
			] );
			
		});
	}
	
}
