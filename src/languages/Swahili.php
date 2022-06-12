<?php
namespace js\tools\numbers2words\languages;

use js\tools\numbers2words\exceptions\UnsupportedCurrencyException;
use js\tools\numbers2words\Speller;

/**
 * @internal
 */
final class Swahili extends Language
{
	public function spellMinus(): string
	{
		return 'hasi';
	}
	
	public function spellMinorUnitSeparator(): string
	{
		return 'na';
	}
	
	public function spellHundred(int $number, int $groupOfThrees, bool $isDecimalPart, string $currency): string
	{
		static $tens = [
			1 => 'kumi',
			2 => 'ishirini',
			3 => 'thelathini',
			4 => 'arobaini',
			5 => 'hamsini',
			6 => 'sitini',
			7 => 'sabini',
			8 => 'themanini',
			9 => 'tisini',
		];
		static $teens = [
			11 => 'kumi na moja',
			12 => 'kumi na mbili',
			13 => 'kumi na tatu',
			14 => 'kumi na nne',
			15 => 'kumi na tano',
			16 => 'kumi na sita',
			17 => 'kumi na saba',
			18 => 'kumi na nane',
			19 => 'kumi na tisa',
		];
		static $singles = [
			0 => 'sifuri',
			1 => 'moja',
			2 => 'mbili',
			3 => 'tatu',
			4 => 'nne',
			5 => 'tano',
			6 => 'sita',
			7 => 'saba',
			8 => 'nane',
			9 => 'tisa',
		];
		
		$text = '';

		if ($number >= 1000)
		{
			$text .='elfu '. $singles[intval(substr("$number", 0, 1))];
			$number = $number % 1000;
			if ($number === 0) // exact hundreds
			{
				return $text;
			}
			
			$text .= ' ';
		}

		if ($number >= 100)
		{
			$text .='mia '. $singles[intval(substr("$number", 0, 1))];
			$number = $number % 100;
			if ($number === 0) // exact hundreds
			{
				return $text;
			}
			
			$text .= ' ';
		}
		
		if ($number < 10)
		{
			$text .= $singles[$number];
		}
		else if (($number > 10) && ($number < 20))
		{
			$text .= $teens[$number];
		}
		else
		{
			$text .= $tens[intval(substr("$number", 0, 1))];
			
			if ($number % 10 > 0)
			{
				$text .= ' na ' . $singles[$number % 10];
			}
		}
		return $text;
	}
	
	public function spellExponent(string $type, int $number, string $currency): string
	{
		if ($type === 'milioni')
		{
			return 'milioni';
		}
		
		if ($type === 'elfu')
		{
			return 'elfu';
		}
		
		return '';
	}
	
	public function getCurrencyNameMajor(int $amount, string $currency): string
	{
		static $names = [
			Speller::CURRENCY_EURO                => ['yuro', 'yuro'],
			Speller::CURRENCY_BRITISH_POUND       => ['paundi', 'paundi'],
			Speller::CURRENCY_LATVIAN_LAT         => ['lat', 'lats'],
			Speller::CURRENCY_LITHUANIAN_LIT      => ['litas', 'litai'],
			Speller::CURRENCY_RUSSIAN_ROUBLE      => ['ruble', 'rubles'],
			Speller::CURRENCY_US_DOLLAR           => ['dola', 'dola'],
			Speller::CURRENCY_PL_ZLOTY            => ['zloty', 'zlote'],
			Speller::CURRENCY_TANZANIAN_SHILLING  => ['shilingi', 'shilingi'],
		];
		
		return self::getCurrencyName($names, $amount, $currency);
	}
	
	public function getCurrencyNameMinor(int $amount, string $currency): string
	{
		static $names = [
			Speller::CURRENCY_EURO                => ['senti', 'senti'],
			Speller::CURRENCY_BRITISH_POUND       => ['senti', 'senti'],
			Speller::CURRENCY_LATVIAN_LAT         => ['senti', 'senti'],
			Speller::CURRENCY_LITHUANIAN_LIT      => ['senti', 'senti'],
			Speller::CURRENCY_RUSSIAN_ROUBLE      => ['senti', 'senti'],
			Speller::CURRENCY_US_DOLLAR           => ['senti', 'senti'],
			Speller::CURRENCY_PL_ZLOTY            => ['senti', 'senti'],
			Speller::CURRENCY_TANZANIAN_SHILLING  => ['senti', 'senti'],
		];
		
		return self::getCurrencyName($names, $amount, $currency);
	}
	
	private static function getCurrencyName(array $names, int $amount, string $currency): string
	{
		$index = (($amount === 1) ? 0 : 1);
		
		return $names[$currency][$index] ?? self::throw(new UnsupportedCurrencyException($currency));
	}
}
