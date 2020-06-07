<?php


namespace App\Helpers;

/*
 * Holds the questions for registration of guest user.
 */

use App\Helpers\ServiceQuestionType\ServiceQuestionTypeEmail;
use App\Helpers\ServiceQuestionType\ServiceQuestionTypePhone;
use App\Helpers\ServiceQuestionType\ServiceQuestionTypeText;

trait DefaultServiceQuestionsTrait
{

    /**
     * Get default questions for uGuest User.
     *
     * @return array
     */
    public static function getGuestUserQuestions(): array
    {
        return [
            self::getGuestNameQuestion(),
            self::getGuestEmailQuestion(),
            self::getGuestPhoneQuestion(),
        ];
    }

    /**
     * Get default question for user's name (Guest User).
     *
     * @return self
     */
    public static function getGuestNameQuestion(): self
    {
        return new self([
            'name' => "name",
            'question' => "Whats your name?",
            'placeholder' => "Enter your name",
            'type' => ServiceQuestionTypeText::class,
            'is_locked' => true,
            'is_required' => true,
            'auth_rule' => ServiceQuestionAuthRule::GUEST,
        ]);
    }

    /**
     * Get default question for user's email (Guest User).
     *
     * @return self
     */
    public static function getGuestEmailQuestion(): self
    {
        return new self([
            'name' => "email",
            'question' => "Whats your email?",
            'placeholder' => "Enter your email",
            'type' => ServiceQuestionTypeEmail::class,
            'is_locked' => true,
            'is_required' => true,
            'auth_rule' => ServiceQuestionAuthRule::GUEST,
        ]);
    }

    /**
     * Get default question for user's phone (Guest User).
     *
     * @return self
     */
    public static function getGuestPhoneQuestion(): self
    {
        return new self([
            'name' => "phone",
            'question' => "Whats your phone?",
            'placeholder' => "Enter your phone",
            'type' => ServiceQuestionTypePhone::class,
            'is_locked' => true,
            'is_required' => true,
            'auth_rule' => ServiceQuestionAuthRule::GUEST,
        ]);
    }
}
