<?php


namespace App\Helpers;

trait HasTypes
{
    /**
     * Return all types with replacing '\' with '\\\'
     * (For DB migration use only)
     *
     * @return array
     */
    public static function getAllTypesWithStringSafe(): array
    {
        $types = self::getAllTypes();
        foreach ($types as $i => $iValue) {
            $types[$i] = str_replace("\\", "\\\\\\", $types[$i]);
        }

        return $types;
    }

    /**
     * Return all types.
     *
     * @return array
     */
    public static function getAllTypes(): array
    {
        return array_keys(self::TYPES);
    }
}
