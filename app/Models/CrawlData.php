<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


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
    protected $fillable = ['site_id', 'name', 'phone', 'address', 'url', 'lap'];

}
