<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactType extends Model
{
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($contactType) {
            $relationMethods = ['contacts'];
            if ($contactType->contact()->count() > 0) {
                return false;
            }
        });
    }
}
