<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Support extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'support';

	 /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 
                            'phone', 
                            'email', 
                            'facebook', 
                            'zalo', 
                            'skype', 
                            'image_url',                             
                            'display_order'
                            ];    
}
