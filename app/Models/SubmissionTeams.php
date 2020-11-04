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


class SubmissionTeams extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'comp_join_members';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id',
        'admin_id',
        'member_id',
        'created_at',
        'updated_at'
    ];

    public function submission(){
        return $this->belongsTo(Submission::class, 'studentacc_id', 'team_id');
    }


}
