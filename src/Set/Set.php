<?php


namespace Eliepse\Set;

use Eliepse\Set\Exceptions\UnknownMemberException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;

class Set implements SetInterface
{
    /**
     * The active members of the Set stored
     * @var array
     */
    private $values = [];

    /**
     * The members of the Set
     */
    protected static $members = [];

    /**
     * Is the Set nullable
     * @var bool
     */
    protected static $nullable = false;


    /**
     * Set constructor.
     * @param array $values
     * @throws UnknownMemberException
     */
    public function __construct($values = [])
    {
        // Unset all initialize $this->values
        $this->unsetAll();
        $this->set($values ?? []);
    }


    /**
     * Get members of the Set
     * @return array
     */
    public static function getMembers(): array
    {
        return static::$members;
    }


    /**
     * Is the Set nullable
     * @return bool
     */
    public static function isNullbale(): bool
    {
        return static::$nullable;
    }


    /**
     * Get active members of the Set
     * @return array|null
     */
    public function getValues(): ?array
    {
        $values = array_keys(
            array_filter($this->values, function ($value) { return $value; })
        );

        if (static::$nullable)
            return count($values) ? $values : null;
        else
            return $values;
    }


    /**
     * Check if a single member is active
     * @param string $member
     * @return bool
     */
    public function has(string $member): bool
    {
        return $this->values[ $member ] ?? false;
    }


    /**
     * Check if at least one of the given members is active
     * @param array $members
     * @return bool
     */
    public function hasOne(array $members): bool
    {
        // We only take the valid members
        $filtered = array_intersect_key($this->values, array_flip($members));

        // Then we check if one of them is valid
        foreach ($filtered as $value)
            if ($value)
                return true;

        return false;
    }


    /**
     * Check if every given members are active
     * @param array $members
     * @return bool
     */
    public function hasAll(array $members): bool
    {
        // If some members are invalid, return false
        // (because those keys are obviously not active)
        if (count(array_diff_key(array_flip($members), $this->values)))
            return false;


        // If members to test are valid, we proceed to a check
        // that stops if there is an non-active member
        foreach ($members as $member)
            if (!$this->values[ $member ] ?? true)
                return false;

        return true;
    }


    /**
     * To set (or activate) a member of the Set
     * @param string|array $member
     * @return void
     * @throws UnknownMemberException
     */
    public function set($member): void
    {
        if (is_string($member))
            $this->activateMember($member);
        else if (is_array($member))
            foreach ($member as $value)
                $this->activateMember($value);
    }


    /**
     * To unset (or unactivate) a member of the Set
     * @param string|array $member
     * @return void
     * @throws UnknownMemberException
     */
    public function unset($member): void
    {
        if (is_string($member))
            $this->unactivateMember($member);
        else if (is_array($member))
            foreach ($member as $value)
                $this->unactivateMember($value);
    }


    /**
     * To unset all members of the Set
     * @return void
     */
    public function unsetAll(): void
    {
        $r_members = array_flip(static::$members);
        $this->values = array_map(function () { return false; }, $r_members);
    }


    /**
     * Check if the member exists
     * @param string $member
     * @return bool
     */
    public function memberExists(string $member): bool
    {
        return array_key_exists($member, array_flip(static::$members));
    }


    /**
     * @param string $member
     * @return void
     * @throws UnknownMemberException
     */
    protected function activateMember(string $member): void
    {
        $member = trim($member);
        if (!$this->memberExists($member))
            throw new UnknownMemberException();
        $this->values[ $member ] = true;
    }


    /**
     * @param string $member
     * @return void
     * @throws UnknownMemberException
     */
    public function unactivateMember(string $member): void
    {
        $member = trim($member);
        if (!$this->memberExists($member))
            throw new UnknownMemberException();
        $this->values[ $member ] = false;
    }


    /**
     * Handle the creation of the table for the Set
     * @param Blueprint $table
     * @param string $column_name
     * @return ColumnDefinition
     */
    public static function createTableColumn(Blueprint $table, string $column_name): ColumnDefinition
    {
        return $table->set($column_name, static::getMembers())->nullable(static::isNullbale());
    }
}