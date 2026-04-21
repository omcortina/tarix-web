<?php

if (!function_exists('getSpanish')) {
    /**
     * Get Spanish value from translatable field
     * 
     * @param mixed $value The translatable value (array or string)
     * @return string Spanish value
     */
    function getSpanish($value): string
    {
        if (is_array($value)) {
            return $value['es'] ?? '';
        }
        return $value ?? '';
    }
}
