<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class LichHen extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'lich_hen';

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
                    'join_id', 
                    'user_id', 
                    'ngay_hen', 
                    'ghi_chu', 
                    'status'
                    ];
    public function info()
    {
        return $this->hasOne('App\Models\CtvJoinSale', 'id', 'join_id');
    }
    public function user()
    {
        return $this->hasOne('App\Models\Account', 'id', 'user_id');
    }
}