<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = ['name', 'status', 'subscription_type'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
