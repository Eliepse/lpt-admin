<?php


namespace Eliepse\Roles;


use App\Sets\UserRolesSet;
use Illuminate\Support\Arr;

/**
 * Trait HasRoles
 *
 * @package Eliepse\Roles
 * @property-read UserRolesSet $roles
 */
trait HasRoles
{
    /**
     * @param $value
     *
     * @return UserRolesSet
     */
    public function getRolesAttribute($value): UserRolesSet
    {
        return new UserRolesSet($value ? explode(',', $value) : []);
    }


    /**
     * @param UserRolesSet $value
     */
    public function setRolesAttribute(UserRolesSet $value)
    {
        $this->attributes['roles'] = join(',', $value->getValues());
    }


    /**
     * @param UserRolesSet|array|string $value
     *
     * @throws \ErrorException
     */
    public function setRoles($value)
    {
        if (is_string($value)) {
            $this->setRole($value);

            return;
        }

        if (is_array($value)) {
            $this->setRoleArray($value);

            return;
        }

        if (is_a($value, UserRolesSet::class)) {
            $this->attributes['roles'] = join(',', $value->getValues());

            return;
        }

        throw new \ErrorException("The parameter is not in a valid type (string or UserRolesSet).");
    }


    public function setRoleArray(array $roles)
    {
        UserRolesSet::validate($roles);

        $this->attributes['roles'] = join(',', $roles);
    }


    public function setRole(string $role)
    {
        $roles = $this->roles;
        $roles->set($role);

        $this->attributes['roles'] = join(',', $roles->getValues());
    }


    /**
     * @param array|string $roles
     *
     * @return bool
     */
    public function hasRoles($roles): bool
    {
        return $this->roles->hasOne(Arr::wrap($roles));
    }


    /**
     * @param array|string $roles
     *
     * @return bool
     */
    public function hasRolesStrict($roles): bool
    {
        return $this->roles->hasStrict(Arr::wrap($roles));
    }


    /**
     * @param string $role
     *
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return $this->roles->has($role);
    }
}
