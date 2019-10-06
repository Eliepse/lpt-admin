<?php


namespace Eliepse\Set;


use Eliepse\Set\Exceptions\UnknownMemberException;

interface SetInterface
{
    /**
     * Get members of the Set
     *
     * @return array
     */
    public static function getKeys(): array;


    /**
     * Get active members of the Set
     *
     * @return array|null
     */
    public function getValues(): ?array;


    /**
     * Check if a member is active
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool;


    /**
     * Check if at least one of the given members is active
     *
     * @param array $keys
     *
     * @return bool
     */
    public function hasOne(array $keys): bool;


    /**
     * Check if every given members are active
     *
     * @param array $keys
     *
     * @return bool
     */
    public function hasStrict(array $keys): bool;


    /**
     * To set (or activate) a member of the Set
     *
     * @param string|array $member
     *
     * @return void
     * @throws UnknownMemberException
     */
    public function set($member): void;


    /**
     * To unset (or unactivate) a member of the Set
     *
     * @param string|array $member
     *
     * @return void
     * @throws UnknownMemberException
     */
    public function unset($member): void;


    /**
     * To unset all members of the Set
     *
     * @return void
     */
    public function reset(): void;


    /**
     * Check if the member exists
     *
     * @param string $key
     *
     * @return bool
     */
    public static function hasKey(string $key): bool;


    /**
     * Is the Set nullable
     *
     * @return bool
     */
    public static function isNullbale(): bool;
}
