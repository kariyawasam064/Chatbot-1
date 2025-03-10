<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditingTrait;

class Group extends Model implements Auditable
{
    use AuditingTrait;

    protected $table = 'group';  // Ensure this matches the actual table name
    protected $primaryKey = 'id'; // Primary key column
    protected $fillable = ['group_name', 'group_code', 'address', 'contact_number']; // Ensure 'group_code' is fillable


}
