<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Customer extends Model  {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'customers';

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
      'full_name',      
      'address',
      'phone',     
      'cmnd',    
      'status'      
    ];

    public function ctv()
    {
        return $this->hasOne('App\Models\Account', 'id', 'ctv_id');
    }

}
