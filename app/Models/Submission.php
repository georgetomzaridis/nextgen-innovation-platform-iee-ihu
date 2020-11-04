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
        'invite_code',
        'invite_active',
        'join_type',
        'created_at',
        'updated_at'
    ];



    public function admin(){
        return $this->belongsTo(User::class, 'studentacc_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'studentacc_id', 'id');
    }

    public function team(){
        return $this->hasMany(SubmissionTeams::class, 'team_id', 'id');
    }


}
