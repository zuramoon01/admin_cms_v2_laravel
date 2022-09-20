<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'authorization_type_id',
        'menu_id',
        'has_access',
    ];
    // protected $with = ['menu'];
    public $timestamps = false;

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
