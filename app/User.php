<?php

namespace App;

use App\Pivots\StudentParent;
use App\Sets\UserRoles;
use App\Traits\HasHumanNames;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 * @property int id
 * @property string firstname
 * @property string lastname
 * @property string email
 * @property UserRoles roles
 * @property string type
 * @property string wechat_id
 * @property string phone
 * @property string address
 * @property string password
 * @property bool active
 * @property string remember_token
 * @property Collection children
 * @property Collection grades
 * @property Family family
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @method static Builder teacher
 * @method static Builder parent
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasHumanNames;

    protected $table = 'users';

    protected $fillable = [
        'firstname', 'lastname', 'email',
        'type', 'phone', 'address', 'wechat_id',
        'roles',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * @param $value
     * @return UserRoles
     * @throws \Eliepse\Set\Exceptions\UnknownMemberException
     */
    public function getRolesAttribute($value): UserRoles
    {
        return new UserRoles($value ? explode(',', $value) : []);
    }


    /**
     * @param UserRoles $value
     */
    public function setRolesAttribute(UserRoles $value)
    {
        $this->attributes['roles'] = join(',', $value->getValues());
    }


    /**
     * @return BelongsToMany
     */
    public function children(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, "student_parent")
            ->using(StudentParent::class)
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
     * @return HasMany
     */
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class, 'teacher_id');
    }


    /**
     * @return bool
     */
    public function isAdmin(): bool { return $this->roles->has(UserRoles::ADMIN); }


    /**
     * @return bool
     */
    public function isTeacher(): bool { return $this->roles->has(UserRoles::TEACHER); }


    /**
     * @return bool
     */
    public function isStaff(): bool { return $this->type === 'staff'; }


    public function isClient(): bool { return $this->type === 'client'; }


    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeStaff(Builder $query): Builder
    {
        return $query->where('type', 'staff');
    }


    /**
     * @param  Builder $query
     * @return Builder
     */
    public function scopeTeacher(Builder $query): Builder
    {
        return $query->where('type', 'staff')
            ->where('roles', UserRoles::TEACHER);
    }


    /**
     * @param  Builder $query
     * @return Builder
     */
    public function scopeParent(Builder $query): Builder
    {
        return $query->where('type', 'client');
    }

}
