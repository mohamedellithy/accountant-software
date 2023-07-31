<?php
if (!function_exists('IsActiveOnlyIf')) {
    function IsActiveOnlyIf($routes = [])
    {
        if (count($routes) == 0) {
            return '';
        }

        $current_route = \Route::currentRouteName();

        if (in_array($current_route, $routes)):
            return 'active open';
        endif;

        return '';
    }
}

?>
