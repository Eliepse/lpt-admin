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
     * Check if a value is activated
     * @param string $member
     * @return bool
     */
    public function has(string $member): bool;


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