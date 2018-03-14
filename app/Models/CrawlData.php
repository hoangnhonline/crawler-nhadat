<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class CrawlData extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'crawl_data';   

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['site_id', 'name', 'phone', 'address', 'url', 'lap', 'moigioi',
    'dien_tich',
    'gia',
    'tieu_de',
    'so_lau',
    'huong',
    'so_phong',
    'so_toilet',
    'duong_truoc_nha',
    'loai_so',
    'ngay_gap',
    'notes',
    'status_1',
    'status_2',
    'status_3',
    'type',
    'loai_bds',
    'co_hen',
    'thumbnail_id',
    'video_url'

];

    public function hen($join_id)
    {
        return $rs = LichHen::where('join_id', $join_id)->where('user_id', Auth::user()->id)->get();
    }
    public static function userHen(){
      $dateCurr = date('Y-m-d');
      return LichHen::where('ngay_hen', $dateCurr)->where('user_id', Auth::user()->id)->get(); 
    }
}
