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

    //관계 설정(One to many)
    public function user() {
        return $this->belongsTo(User::class);
    }
}
