<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporterGroup extends Model
{
    use HasFactory;

    protected $table = 'reporter_group'; // Table name

    // Allow mass assignment for these fields
    protected $fillable = ['emp_id', 'group_code'];

    // Relationship with User model (optional)
    public function user()
    {
        return $this->belongsTo(User::class, 'emp_id', 'emp_id'); // Assuming `emp_id` is the foreign key
    }

    // Relationship with Group model (optional)
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_code', 'group_code'); // Assuming `group_code` is the foreign key
    }

    // Model Event: Validate that each group_code is unique for each emp_id
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Check if the group_code is already assigned to another employee
            if (self::where('group_code', $model->group_code)->exists()) {
                throw new \Illuminate\Database\Eloquent\MassAssignmentException(
                    "The group code '{$model->group_code}' is already assigned to another employee."
                );
            }
        });
    }
}
