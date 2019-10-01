<?php

namespace App;

use App\Pivots\ParentStudent;
use App\Sets\UserRolesSet;
use App\Traits\HasHumanNames;
use Carbon\Carbon;
use Eliepse\Roles\HasRoles;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
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
 * @property Family family
 * @property Carbon created_at
 * @property Carbon updated_at
 * @method static Builder teacher
 * @method static Builder parent
 */
class User extends Authenticatable
{
    use Notifiable,
        HasHumanNames,
        CanResetPassword,
        HasRoles;

    protected $table = 'users';

    protected $fillable = [
        'firstname', 'lastname', 'email',
        'type', 'phone', 'address', 'wechat_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * @return BelongsToMany
     */
    public function children(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, "student_parent")
            ->using(ParentStudent::class)
            ->withPivot([
                'relation',
            ]);
    }


    /**
     * @return BelongsTo
     */
    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }


    /**
     * @return bool
     */
    public function isAdmin(): bool { return $this->roles->has(UserRolesSet::ADMIN); }


    /**
     * @return bool
     */
    public function isTeacher(): bool { return $this->roles->has(UserRolesSet::TEACHER); }


    /**
     * @return bool
     */
    public function isStaff(): bool { return $this->type === 'staff'; }


    public function isClient(): bool { return $this->type === 'client'; }


    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeStaff(Builder $query): Builder
    {
        return $query->where('type', 'staff');
    }


    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeTeacher(Builder $query): Builder
    {
        return $query->where('type', 'staff')
            ->where('roles', UserRolesSet::TEACHER);
    }


    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeParent(Builder $query): Builder
    {
        return $query->where('type', 'client');
    }

}
