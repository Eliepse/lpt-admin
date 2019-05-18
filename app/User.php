<?php

namespace App;

use App\Pivots\StudentParent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

/**
 * Class User
 * @package App
 * @property int id
 * @property string firstname
 * @property string lastname
 * @property string email
 * @property string type
 * @property string wechat_id
 * @property string phone
 * @property string address
 * @property string password
 * @property bool active
 * @property string remember_token
 * @property Collection children
 * @property Collection grades
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @method static Builder teacher
 * @method static Builder parent
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'firstname', 'lastname', 'email',
        'type', 'phone', 'address',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
//        'email_verified_at' => 'datetime',
    ];


    public function children(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, "student_parent")
            ->using(StudentParent::class)
            ->withPivot([
                'relation',
            ]);
    }


    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class, 'teacher_id');
    }


    public function getFullname(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }


    public function getInitials(): string
    {
        return Str::upper(Str::substr($this->firstname, 0, 1) .
            Str::substr($this->lastname, 0, 1));
    }


    public function isAdmin(): bool { return $this->type === 'admin'; }


    public function isTeacher(): bool { return $this->type === 'teacher'; }


    /**
     * Scope a query to only include popular users.
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeTeacher(Builder $query)
    {
        return $query->where('type', 'teacher');
    }


    /**
     * Scope a query to only include popular users.
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeParent(Builder $query)
    {
        return $query->where('type', 'parent');
    }

}
