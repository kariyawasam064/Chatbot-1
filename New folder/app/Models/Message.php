<?php

namespace App\Models;

use Mongodb\Laravel\Eloquent\Model;

class Message extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'messages';

    

    public $timestamps = true;

    protected $dates = ['timestamp', 'created_at', 'updated_at'];

    
    protected $fillable = ['from', 'to', 'message', 'timestamp', 'is_read', 'active_chat','document_id'];


    // protected $attributes = [
    //     'is_read' => false  // Default value when inserting new messages
    // ];

    protected $casts = [
        'is_read' => 'boolean',  // Ensure boolean casting
    ];
}
