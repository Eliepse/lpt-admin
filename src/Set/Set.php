<?php


namespace Eliepse\Set;

use Eliepse\Set\Exceptions\UnknownMemberException;
use Illuminate\Database\Schema\Blueprint;

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
    public function __construct(array $values = [])
    {
        // Unset all initialize $this->values
        $this->unsetAll();
        $this->set($values);
    }


    /**
     * Get members of the Set
     * @return array
     */
    public static function getMembers(): array
    {
        return self::$members;
    }


    /**
     * Is the Set nullable
     * @return bool
     */
    public static function isNullbale(): bool
    {
        return self::$nullable;
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

        if (self::$nullable)
            return count($values) ? $values : null;
        else
            return $values;
    }


    /**
     * Check if a value is activated
     * @param string $member
     * @return bool
     */
    public function has(string $member): bool
    {
        return $this->values[ $member ] ?? false;
    }


    /**
     * To set (or activate) a member of the Set
     * @param string|array $member
     * @return mixed
     * @throws UnknownMemberException
     */
    public function set($member)
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
     * @return mixed
     * @throws UnknownMemberException
     */
    public function unset($member)
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
    public function unsetAll()
    {
        $this->values = array_walk(array_flip(self::$members), function () { return false; });
    }


    /**
     * Check if the member exists
     * @param string $member
     * @return bool
     */
    public function memberExists(string $member): bool
    {
        return array_key_exists($member, array_flip(self::$members));
    }


    /**
     * @param string $member
     * @throws UnknownMemberException
     */
    protected function activateMember(string $member)
    {
        $member = trim($member);

        if (!$this->memberExists($member))
            throw new UnknownMemberException();

        $this->values[ $member ] = true;
    }


    /**
     * @param string $member
     * @throws UnknownMemberException
     */
    public function unactivateMember(string $member)
    {
        $member = trim($member);

        if (!$this->memberExists($member))
            throw new UnknownMemberException();

        $this->values[ $member ] = false;
    }


    public static function createTableColumn(Blueprint $table, string $column_name)
    {
        $table->set($column_name, self::getMembers())->nullable(self::isNullbale());
    }
}