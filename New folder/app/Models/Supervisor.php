<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditingTrait;


class Supervisor extends Model implements Auditable
{
    use AuditingTrait;
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
