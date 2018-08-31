<?php
/**
 * @param $line __LINE__
 * @param $function __FUNCTION__
 * @param $file __FILE__
 * @param $string any string
 * @param $flag true to log; false not to log
 * @return none
 */
function d_log ($line, $function, $file, $string, $flag) {
    //d_log(__LINE__, __FUNCTION__, __FILE__, ' text to log');
    if($flag) {
        error_log('[' . $line . '@' . $function . '@' . basename($file) .'] ' . $string);
    }
    return;
}


/**
 * @param $var any variable
 * @return string: format
 */
function var_dump_str($var) {
    ob_start();
    var_dump($var);
    return ob_get_clean();
}

/**
 * @param $date integer of unixtimestamp format, not actual date type
 * @return string
 */
function zdateRelative($date){
    $now = time();
    $diff = $now - $date;

    if ($diff < 60){
        return sprintf($diff > 1 ? '%s seconds ago' : 'a second ago', $diff);
    }

    $diff = floor($diff/60);

    if ($diff < 60){
        return sprintf($diff > 1 ? '%s minutes ago' : 'one minute ago', $diff);
    }

    $diff = floor($diff/60);

    if ($diff < 24){
        return sprintf($diff > 1 ? '%s hours ago' : 'an hour ago', $diff);
    }

    $diff = floor($diff/24);

    if ($diff < 7){
        return sprintf($diff > 1 ? '%s days ago' : 'yesterday', $diff);
    }

    if ($diff < 30)
    {
        $diff = floor($diff / 7);

        return sprintf($diff > 1 ? '%s weeks ago' : 'one week ago', $diff);
    }

    $diff = floor($diff/30);

    if ($diff < 12){
        return sprintf($diff > 1 ? '%s months ago' : 'last month', $diff);
    }

    $diff = date('Y', $now) - date('Y', $date);

    return sprintf($diff > 1 ? '%s years ago' : 'last year', $diff);
}










?>