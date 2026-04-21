<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationService
{
    /**
     * Translate Spanish text to English
     * 
     * @param string $text Spanish text to translate
     * @return string English translation
     */
    public static function translateToEnglish(string $text): string
    {
        try {
            $tr = new GoogleTranslate();
            $tr->setSource('es');
            $tr->setTarget('en');
            return $tr->translate($text);
        } catch (\Exception $e) {
            // If translation fails, return original text
            \Log::warning('Translation error: ' . $e->getMessage());
            return $text;
        }
    }

    /**
     * Create translatable array from Spanish text
     * 
     * @param string $spanishText Spanish text
     * @return array Translatable array with es and en keys
     */
    public static function makeTranslatable(string $spanishText): array
    {
        return [
            'es' => $spanishText,
            'en' => self::translateToEnglish($spanishText),
        ];
    }

    /**
     * Create translatable arrays for multiple fields
     * 
     * @param array $fields Fields to translate (key => spanish text)
     * @return array Translatable fields
     */
    public static function makeTranslatableFields(array $fields): array
    {
        $translatable = [];
        
        foreach ($fields as $key => $value) {
            if (is_string($value) && !empty($value)) {
                $translatable[$key] = self::makeTranslatable($value);
            } else {
                $translatable[$key] = $value;
            }
        }
        
        return $translatable;
    }
}
