<?php


namespace App\Helpers\ServiceQuestionValidationRule;

use App\Helpers\HasTypes;

abstract class ServiceQuestionValidationRule
{
    use HasTypes;

    public const REQUIRED = Required::class;
    public const EMAIL = Email::class;
    public const PHONE = Phone::class;
    public const TextLengthMin = TextLengthMin::class;
    public const TextLengthMax = TextLengthMax::class;
    public const FILE = File::class;
    public const IMAGE = Image::class;
    public const VIDEO = Video::class;
    public const FILESIZEMIN = FileSizeMin::class;
    public const FILESIZEMAX = FileSizeMax::class;

    public const TYPES = [
        self::REQUIRED => 'Required',
        self::TextLengthMin => 'Text Minimum Length',
        self::TextLengthMax => 'Text Maximum Length',
        self::EMAIL => 'Email',
        self::PHONE => 'Phone',
        self::FILE => 'File',
        self::IMAGE => 'Image',
        self::VIDEO => 'Video',
        self::FILESIZEMIN => 'File Minimum Size',
        self::FILESIZEMAX => 'File Maximum Size',
    ];

    protected $name;
    protected $rule_value;

    abstract public function getValidatorRule();

    /**
     * @param string $name
     * @param string $rule_value
     */
    public function __construct(string $name, string $rule_value)
    {
        $this->name = $name;
        $this->rule_value = $rule_value;
    }
}
