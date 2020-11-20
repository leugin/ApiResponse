<?php
if (! function_exists('perPage')) {
    function perPage(array $options = []) {
        return array_key_exists('perPage', $options) ? $options['perPage'] : config('project.api.per_page');
    }
}
