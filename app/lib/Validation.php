<?php
namespace App\lib;

class Validation
{
	public static function isEmpty($value): bool
	{
		$value = trim($value);
		return $value === null || $value === '';
	}

	public static function isText($value): bool
	{
		$pattern = "/^[\D]*$/";
		return preg_match($pattern, $value) === 1;
	}
	public static function isNumeric($value): bool
	{
		return is_numeric($value);
	}

	public static function isGreaterThan($value, $length): bool
	{
		return strlen(trim($value)) >= $length;
	}

	public static function isLessThan($value, $length): bool
	{
		return strlen(trim($value)) < $length;
	}

	public static function isEmail($value): bool
	{
		return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
	}

	public static function isPhone($value): bool
	{
		$pattern = "/^[\+]?1?[(]?\d{3}[)]?[-\s.]?\d{3}[-\s.]?\d{4}$/";
		return preg_match($pattern, $value) === 1;
	}

	public static function sanitize($value): string
	{
		return filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	public static function isDate($value): bool
	{
		$test = \DateTime::createFromFormat('Y-m-d', $value);
		return \DateTime::createFromFormat('Y-m-d', $value) !== false;
	}

	public static function isUrl($value): bool
	{
		return filter_var($value, FILTER_VALIDATE_URL) !== false;
	}

	public static function isPostalCode($value): bool
	{
		$pattern = "/^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$/i";
		return preg_match($pattern, $value) === 1;
	}

	public static function compareDates(\DateTime $dateToCompare, \DateTime $dateToCompareWith): int
	{
		if ($dateToCompare > $dateToCompareWith) {
			return 1;
		} else if ($dateToCompare < $dateToCompareWith) {
			return -1;
		} else {
			return 0;
		}
	}
}

