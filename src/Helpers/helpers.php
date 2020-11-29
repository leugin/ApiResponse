<?php
if (! function_exists('perPage')) {
    function perPage(array $options = [], $default = 20) {
        return array_key_exists('perPage', $options) ? $options['perPage'] : $default;
    }
}
