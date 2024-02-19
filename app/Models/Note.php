<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'priority',
        'status'
    ];

    protected $allowedStatus = [
        'a'=>'active',
        'c'=>'completed'
    ];

    protected $allowedPriorities = [
        '0'=>'low',
        '1'=>'medium',
        '2'=>'high'
    ];

    public function getId() : string
    {
        return $this->id;
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function getStatus() : string
    {
        return $this->allowedStatus[$this->status];
    }

    public function getPriority() : string
    {
        return $this->allowedPriorities[$this->priority];
    }

    public function setPriority(string $value) : string
    {        
        $key = array_search($value, $this->allowedPriorities);
        if ($key !== false) {            
            return $key;
        }
        return '1';

    }
}
