<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['content', 'contact_type_id', 'client_id', 'created_at', 'updated_at'];
}
