<?php

namespace App;

use App\Scopes\CommonFilterScopes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, CommonFilterScopes, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'first_name', 'last_name', 'sex'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getShortNameAttribute(): string
    {
        if($this->first_name && $this->last_name) {
            return mb_substr($this->first_name, 0, 1) . '. ' . $this->last_name;
        }else{
            return $this->getFullNameAttribute;
        }
    }

    // Ако е записан пол на потребителя връща г-н или г-жо плюс фамилията
    // а ако не е записан връща г-н/г-жа плюс фамилията
    public function getRespectfulNameAttribute(): string
    {
        if($this->sex) {
            return ($this->sex == 'Male' ? 'г-н' : 'г-жа') . ' ' . $this->last_name;
        }else{
            return 'г-н/г-жа' . ' ' . $this->last_name;
        }
    }
}
