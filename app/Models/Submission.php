<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * Post
 *
 * @mixin Eloquent
 */

class Submission extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'comp_join';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'studentacc_id',
        'submision_id',
        'teamname',
        'appname',
        'apptags',
        'appdesc',
        'appdesc',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'uniaccid', );
    }

}
