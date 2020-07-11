<?php

namespace App\Models;

use App\Traits\HasMeta;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{

    protected $fillable = ["converser_id", "actor", "refering_actor"];

    protected $casts = [
        "meta" => "array"
    ];

    public function meta()
    {
        return [];
    }
}
