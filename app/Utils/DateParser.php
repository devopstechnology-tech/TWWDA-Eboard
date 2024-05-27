<?php

declare(strict_types=1);

namespace App\Utils;

use Carbon\Carbon;

class DateParser
{
    /**
     * Try multiple date formats to parse the input date string, including preprocessing steps.
     *
     * @param string $dateString
     * @return string
     */
    public static function parseDate($dateString)
    {
        // Normalize date string: remove ordinals and extra whitespace
        $dateString = self::normalizeDateString($dateString);

        $formats = [
            'd-m-Y H:i', 'd-m-y', 'd/m/Y', 'd/m/y',
            'jS M, Y', 'jS F, Y', 'j/n/Y', 'j-n-y',
            'd-m-Y', 'd/m/y H:i', 'Y-m-d H:i:s', 'd.m.Y',
            'j M Y', 'j F Y', 'Y-m-d'
        ];

        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, $dateString)->toDateTimeString();
            } catch (\Exception $e) {
                // Continue to the next format if parsing fails
            }
        }

        // As a last resort, use loose parsing
        try {
            return Carbon::parse($dateString)->toDateTimeString();
        } catch (\Exception $e) {
            // Handle the exception if even loose parsing fails
            throw new \Exception("Unable to parse the date: {$dateString}");
        }
    }

    /**
     * Normalize the date string by removing ordinals and trimming whitespace.
     *
     * @param string $dateString
     * @return string
     */
    private static function normalizeDateString($dateString)
    {
        // Remove ordinal suffixes
        $dateString = preg_replace('/(\d+)(st|nd|rd|th)/', '$1', $dateString);

        // Replace commas and extra spaces
        $dateString = trim(preg_replace('/\s+/', ' ', str_replace(',', '', $dateString)));

        return $dateString;
    }
}
