<?php
require_once("CompareStr.php");

// strings
$old_string = '285427';
$new_string = '296427';

// initialize CompareStr class
$CompareStr = new CompareStr($old_string, $new_string);

// compare two strings
$result = $CompareStr->compare();

// print the results using the $result array
echo 'Old string: ' . $old_string. '<br>';
echo 'New string: ' . $new_string . '<br>';
echo 'Number of changes: ' . $result['number_of_changes'] . '<br>';
echo 'Commonly used sequenced chars count: ' . $result['common_chars_length'] . '<br>';

// print two strings with the bold commonly used characters to reflect changes visually
echo '<br>';
for ($i=0; $i<strlen($old_string); $i++)
{
    $char = $old_string[$i];
    if (in_array($i, $result['common_char_indexes_old'])){
        echo '<b>' . $char . '</b>';
    }
    else{
        echo $char;
    }
}
echo '<br>';
for ($i=0; $i<strlen($new_string); $i++)
{
    $char = $new_string[$i];
    if (in_array($i, $result['common_char_indexes_new'])){
        echo '<b>' . $char . '</b>';
    }
    else{
        echo $char;
    }
}

/*
sample output:

Old string: 285427<br>
New string: 296427<br>
Number of changes: 2<br>
Commonly used sequenced chars count: 4<br>
<br>
<b>2</b>85<b>4</b><b>2</b><b>7</b><br>
<b>2</b>96<b>4</b><b>2</b><b>7</b>

*/