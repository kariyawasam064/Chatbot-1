<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditingTrait;


class AgentSkill extends Model implements Auditable
{
    use AuditingTrait;

    // Specify the table if it's not the default "agent_skill"
    protected $table = 'agent_skill';

    // Define fillable attributes (fields that are mass assignable)
    protected $fillable = ['skill_id', 'emp_id'];

    // Relationship to Skill model
    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id', 'id');
    }

    // Relationship to Agent model
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'emp_id', 'emp_id');
    }
}
