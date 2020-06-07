<?php


namespace App\Helpers\ServiceQuestionType;

use App\Helpers\HasTypes;
use Illuminate\Support\HtmlString;

abstract class ServiceQuestionType
{
    use HasTypes;

    public const TEXT = ServiceQuestionTypeText::class;
    public const TEXT_MULTILINE = ServiceQuestionTypeTextMultiline::class;
    public const EMAIL = ServiceQuestionTypeEmail::class;
    public const PHONE = ServiceQuestionTypePhone::class;
    public const SELECT = ServiceQuestionTypeSelect::class;
    public const SELECT_MULTIPLE = ServiceQuestionTypeSelectMultiple::class;
    public const DATE = ServiceQuestionTypeDate::class;
    public const TIME = ServiceQuestionTypeTime::class;
    public const DATE_TIME = ServiceQuestionTypeDateTime::class;
    public const FILE = ServiceQuestionTypeFile::class;
    public const FILE_MULTIPLE = ServiceQuestionTypeFileMultiple::class;

    public const TYPES = [
        self::TEXT => "Text Single Line",
        self::TEXT_MULTILINE => "Text Multiple Line",
        self::PHONE => "Email",
        self::EMAIL => "Phone",
        self::SELECT => "Select From Choices",
        self::SELECT_MULTIPLE => "Select Multiple From Choices",
        self::DATE => "Date",
        self::TIME => "Time",
        self::DATE_TIME => "Date Time",
        self::FILE => "Single File",
        self::FILE_MULTIPLE => "Multiple Files",
    ];

    public $text;
    protected $rules;

    /**
     * Return the formatted text for type.
     *
     * @param string $text
     * @param array $rules
     */
    public function __construct($text, $rules = [])
    {
        $this->text = $text;
        $this->rules = $rules;
    }

    /*
     * Return Html for question type date.
     *
     * @param string $name
     * @param string $is_required
     * @param string $value
     * @param array $options
     *
     * @return string
     */
    abstract public static function getHtml($name, $is_required = false, $value = null, $options = [], $selectList = []): HtmlString;

    /**
     * Return the formatted text for type.
     *
     * @return array
     */
    public static function getAllTypes(): array
    {
        return array_keys(self::TYPES);
    }

    /**
     * Return the formatted text for type.
     *
     * @return array
     */
    public static function getAllTypesWithStringSafe(): array
    {
        $types = array_keys(self::TYPES);
        for ($i = 0, $iMax = count($types); $i < $iMax; $i++) {
            $types[$i] = str_replace("\\", "\\\\\\", $types[$i]);
        }

        return $types;
    }

    protected static function handleIsRequired(&$options, $is_required): void
    {
        if ($is_required) {
            $options['required'] = 'required';
        }
    }

    protected static function handleMultiple(&$options): void
    {
        $options['multiple'] = 'multiple';
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Check if type is select Single or Multiple.
     *
     * @return bool
     */
    public function isSelect(): bool
    {
        return $this->isSelectSingle() || $this->isSelectMultiple();
    }

    /**
     * Check if type is select Single.
     *
     * @return bool
     */
    public function isSelectSingle(): bool
    {
        return get_class($this) === ServiceQuestionTypeSelect::class;
    }

    /**
     * Check if type is select Multiple.
     *
     * @return bool
     */
    public function isSelectMultiple(): bool
    {
        return get_class($this) === ServiceQuestionTypeSelectMultiple::class;
    }

    /**
     * Check if type is file Single or Multiple.
     *
     * @return bool
     */
    public function isFile(): bool
    {
        return $this->isFileSingle() || $this->isFileMultiple();
    }

    /**
     * Check if type is file Single.
     *
     * @return bool
     */
    public function isFileSingle(): bool
    {
        return get_class($this) === ServiceQuestionTypeFile::class;
    }

    /**
     * Check if type is file Multiple.
     *
     * @return bool
     */
    public function isFileMultiple(): bool
    {
        return get_class($this) === ServiceQuestionTypeFileMultiple::class;
    }

    public function getTypeClass()
    {
        return get_class($this);
    }

    /**
     * @return array
     */
    public function getRules($is_required = true, $name): array
    {
        $this->rules[$name] = [];

        // Handle Required Field
        if(!in_array("required", $this->rules[$name])){
            array_push($this->rules[$name], "required");
        }

        return $this->rules;
    }

    public abstract function saveAnswer($answer, $options = []) : array;
}
