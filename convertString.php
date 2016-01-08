<?php

/**
 * Convert from Title Case to Slug String.
 * 
 * For eg:
 * 
 * array (
 *   'firstKey' => 'Value of key',
 *   'secondKey' => 'Value of key',
 *   'firstKey' => array(
 *       'subFirstKey' =>'Value of key',
 *       'subSecondKey' => array (
 *           'subSubFirstKey' = > ' Value of key ',
 *       ),
 *   ),
 *   'thirdKey' => 'Value of first key',
 * )
 *
 * will be
 *
 * array (
 *   'first-key' =>
 *     array (
 *         'sub-first-key' => 'Value of key',
 *         'sub-second-key' =>
 *             array (
 *                   'sub-sub-first-key' => ' Value of key ',
 *             ),
 *     ),
 *     'second-key' => 'Value of key',
 *     'third-key' => 'Value of first key',
 * )
 */
function convertFromTitleCaseToSlug($text)
{
    return strtolower(preg_replace('#([a-zA-Z])(?=[A-Z])#', '$1-', $text));
}

//pass file param to $file variable
$file = $argv[1];
//pass array from file to $arr variable
$arr = include $file;
$newArr = [];
//loop through the array, convert the key that contains TitleCase to dash as a delim

function convertArray($arr)
{
    $newArr = [];

    foreach ($arr as $key => $value) {
        $newKey = convertFromTitleCaseToSlug($key);
        if (is_array($value)) {
            $newArr += [$newKey => convertArray($value)];
        } else {
            $newArr += [$newKey => $value];
        }
    }

    return $newArr;
}
//save to output.txt
$newArr = convertArray($arr);

$output = "<?php\n" . "return " . var_export($newArr, true) . ";";
file_put_contents('output.txt', $output);
