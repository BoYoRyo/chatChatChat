<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\friend;
use App\Models\Member;
use App\Models\conversation;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;



class User extends Authenticatable
//メール認証したい場合はこっちに切り替える※envファイルの設定も忘れない
// class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    // アカウント削除のソフトデリート
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'account_id',
        'icon',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Userテーブルと結合.
    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function friends() {
        return $this->hasMany(Friend::class,'follow_id');
    }

    public function members() {
        return $this->hasMany(Member::class);
    }

    public function member() {
        return $this->hasOne(Member::class);
    }

    public function conversation() {
        return $this->hasMany(conversation::class);
    }
}
