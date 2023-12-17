<?php

/**
 * @param mixed ...$params
 * @return void
 */
function dump()
{
    $vars = func_get_args();
    $last = end($vars);

    echo "<pre>";
    echo "<div id='debug-data' style='padding: 10px; color: #FFFFFF; background-color: #000000;'>";
    print_r((count($vars) > 1) ? $vars : $vars[0]);
    echo "</div>";
    echo "</pre>";

    if (is_int($last)) {
        exit;
    }
}

/**
 * @param array|object $input
 * @param int $case
 * @return array
 */
function arr_upr($input, $case = MB_CASE_TITLE)
{
    $convToCamel = function ($str) {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $str)));
    };

    if (is_object($input)) {
        $input = json_decode(json_encode($input), true);
    }

    $newArray = array();
    foreach ($input as $key => $value) {
        if (is_array($value) || is_object($value)) {
            $newArray[$convToCamel($key)] = arr_upr($value, $case);
        } else {
            $newArray[$convToCamel($key)] = $value;
        }
    }
    return $newArray;
}

/**
 * @param string $text
 * @return string
 */
function conText($text)
{
    $outText = stripslashes(htmlspecialchars(trim($text), ENT_QUOTES));
    return $outText;
}

/**
 * @param string $file
 * @param array $message
 * @param boolean $write_file
 * @return mixed
 */
function write_log($file, $message, $write_file = false)
{
    if ($write_file == false) return false;

    $message = is_array($message) ? var_export($message, true) : null;
    $log = function () use ($message, $file) {
        $nowT = date('Y-m-d h:i:s');
        $log = "[data {$nowT}] => $message\n";
        return file_put_contents($file, $log, FILE_APPEND | LOCK_EX);
    };

    if (file_exists($file)) return $log();
    return $log();
}
