<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable=[
        "fecha",
        "message",
        "userEnviado_id",
        "userRecibido_id",
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
