<?php


namespace Eliepse\Set;


use Eliepse\Set\Exceptions\UnknownMemberException;

interface SetInterface
{
    /**
     * Get members of the Set
     * @return array
     */
    public static function getMembers(): array;


    /**
     * Is the Set nullable
     * @return bool
     */
    public static function isNullbale(): bool;


    /**
     * Get active members of the Set
     * @return array|null
     */
    public function getValues(): ?array;


    /**
     * Check if a single member is active
     * @param string $member
     * @return bool
     */
    public function has(string $member): bool;


    /**
     * Check if at least one of the given members is active
     * @param array $members
     * @return bool
     */
    public function hasOne(array $members): bool;


    /**
     * Check if every given members are active
     * @param array $members
     * @return bool
     */
    public function hasAll(array $members): bool;


    /**
     * To set (or activate) a member of the Set
     * @param string|array $member
     * @return mixed
     * @throws UnknownMemberException
     */
    public function set($member);


    /**
     * To unset (or unactivate) a member of the Set
     * @param string|array $member
     * @return mixed
     * @throws UnknownMemberException
     */
    public function unset($member);


    /**
     * To unset all members of the Set
     * @return void
     */
    public function unsetAll();


    /**
     * Check if the member exists
     * @param string $member
     * @return bool
     */
    public function memberExists(string $member): bool;
}