<?php


namespace App\Helpers;

use Exception;

class ServiceQuestionAuthRule
{
    use HasTypes;

    private const AUTHENTICATED = 'authenticated';
    private const GUEST = 'guest';

    public const TYPES = [
        self::AUTHENTICATED => 'Authenticated User',
        self::GUEST => 'Guest User',
    ];

    private $rule;

    public function __construct($rule = '')
    {
        if( !($rule === null || $rule === self::AUTHENTICATED || $rule === self::GUEST) ) {
            throw new \UnexpectedValueException('Invalid Rule for Authentication!');
        }

        $this->rule = $rule;
    }

    public function __toString()
    {
        return $this->rule ?? '';
    }


    /*
     * Check if question is only for guest user.
     *
     * @return bool
     */
    public function isForEveryone(): bool
    {
        return empty($this->rule);
    }

    /*
     * Check if question is only for authenticated user.
     *
     * @return bool
     */
    public function isOnlyForGuestUser(): bool
    {
        return $this->rule === self::GUEST;
    }

    /*
     * Check if question is only for guest user.
     *
     * @return bool
     */
    public function isOnlyForAuthenticatedUser(): bool
    {
        return $this->rule === self::AUTHENTICATED;
    }
}
