<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = ['ip', 'user_agent', 'first_seen', 'last_seen', 'hits' , 'type', 'visitable_id', 'visitable_type'];

    public function visitable()
    {
        return $this->morphTo();
    }
}
