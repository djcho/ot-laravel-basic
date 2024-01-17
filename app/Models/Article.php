<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // 대량할당 방어 whitelist
    protected $fillable = ['body', 'user_id'];

    //blacklist
    //protected $guarded = ['id'];
}
