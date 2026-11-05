<?php

if (!function_exists('_count')) {
    /**
     * Count elements of an array or Countable, or safely return 0/1 for models and objects (PHP 8.2 compatibility).
     *
     * @param mixed $val
     * @return int
     */
    function _count($val): int
    {
        if ($val === null) {
            return 0;
        }
        if (is_array($val) || $val instanceof \Countable) {
            return count($val);
        }
        if (is_object($val)) {
            return 1;
        }
        return empty($val) ? 0 : 1;
    }
}

