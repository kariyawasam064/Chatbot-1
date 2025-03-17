<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $fillable = [
        'emp_id', 'group_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'emp_id', 'emp_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_code', 'group_code');
    }
}
