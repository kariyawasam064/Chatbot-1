<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditingTrait;

class Skill extends Model  implements Auditable
{
    use AuditingTrait;

    protected $fillable = ['name', 'language', 'description'];
    protected $primaryKey = 'id';

    public function agents()
    {
        return $this->belongsToMany(Agent::class, 'agent_skills', 'skill_id', 'emp_id');
    }
}

