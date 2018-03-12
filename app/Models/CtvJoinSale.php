<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LichHen;
use Auth;
class CtvJoinSale extends Model  {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'ctv_join_sale';

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
    protected $fillable = [
      'id',
      'ctv_id',
      'product_id',
      'type_sale',
      'status_join',
      'status_sales',
      'hh_pr',
      'hh_ctv',
      'hh_cs',
      'updated_user',
      'full_name',
      'cmnd',
      'phone',
      'address',
      'vung_quan_tam',
      'nhu_cau',
      'loai_bds',
      'cskh_status',
      'pr_status',
      'csctv_id',
      'pr_id',
      'is_close',
      'is_success',
      'co_hen',
      'notes',
      'customer_id'
    ];
    public function ctv()
    {
        return $this->hasOne('App\Models\Account', 'id', 'ctv_id');
    }
    public function pr()
    {
        return $this->hasOne('App\Models\Account', 'id', 'pr_id');
    }
    public function hen($join_id)
    {
        return $rs = LichHen::where('join_id', $join_id)->where('user_id', Auth::user()->id)->get();
    }
    public static function userHen(){
      $dateCurr = date('Y-m-d');
      return LichHen::where('ngay_hen', $dateCurr)->where('user_id', Auth::user()->id)->get(); 
    }
    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}
