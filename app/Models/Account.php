<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Account extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

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
                    'full_name', 
                    'email', 
                    'password', 
                    'status', 
                    'changed_password', 
                    'remember_token', 
                    'role', 
                    'leader_id',
                    'facebook_id',
                    'key_reset',
                    'image_url',
                    'address',
                    'phone',
                    'last_login',
                    'changed_password',
                    'created_user',
                    'updated_user',
                    'bank_info',
                    'nghe_nghiep',
                    'cmnd'
                    ];
    
    public static function joinedProduct($ctvId){
      $query = CtvJoinSale::where(['ctv_id' => $ctvId, 'type_sale' => 1])
              ->pluck('product_id')->toArray();
        return $query;
    }
}