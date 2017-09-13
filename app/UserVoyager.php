<?php

namespace App;

use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Foundation\Auth\User as AuthUser;
use TCG\Voyager\Traits\VoyagerUser;

class UserVoyager extends AuthUser
{
    use VoyagerUser;

    protected $guarded = [];
    public $table = 'users';

    /**
     * On save make sure to set the default avatar if image is not set.
     */
    public function save(array $options = [])
    {
        // If no avatar has been set, set it to the default
        $this->avatar = $this->avatar ?: config('voyager.user.default_avatar', 'users/default.png');

        parent::save();
    }

    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public static function TimeZone()
    {
        $timezonelist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        return  $timezonelist;
    }
}
