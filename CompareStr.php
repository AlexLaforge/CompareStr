<?php
/**
 * @author Ovunc Tukenmez <ovunct@live.com>
 * version 1.0.0 - 2018-02-04
 *
 * This class can find number of changed chars as well as
 * indexes of commonly used sequenced chars between two strings
 */
class CompareStr
{
    private $_method = 1;
    private $_old_string = '';
    private $_new_string = '';
    private $_result = array();

    /**
     * CompareStr constructor.
     * @param string $old_string old string
     * @param string $new_string new string
     */
    public function __construct($old_string = '', $new_string = '')
    {
        $this->setOldString($old_string);
        $this->setNewString($new_string);
    }

    /**
     * sets old string value
     *
     * @param string $string
     */
    public function setOldString($string)
    {
        $this->_old_string = $string;
    }

    /**
     * returns old string
     *
     * @return string
     */
    public function getOldString()
    {
        return $this->_old_string;
    }

    /**
     * sets new string value
     *
     * @param string $string
     */
    public function setNewString($string)
    {
        $this->_new_string = $string;
    }

    /**
     * returns new string
     *
     * @return string
     */
    public function getNewString()
    {
        return $this->_new_string;
    }

    /**
     * compares two strings and returns results
     * as array with the keys
     * common_chars_length
     * common_char_indexes_old
     * common_char_indexes_new
     * number_of_changes
     *
     * @param int $method defaults to 1. set 2 to make more calculations to try to find longer common sequence
     * @return array result array
     */
    public function compare($method = 1)
    {
        $this->_method = $method;

        $this->_result = array(
            'common_chars_length' => 0,
            'common_char_indexes_old' => array(),
            'common_char_indexes_new' => array(),
            'number_of_changes' => 0);

        $this->findCommonChars();

        $new_string_length = strlen($this->_new_string);
        $old_string_length = strlen($this->_old_string);

        $diff_old = $old_string_length - $this->_result['common_chars_length'];
        $diff_new = $new_string_length - $this->_result['common_chars_length'];

        $number_of_changes = ($diff_old > $diff_new ? $diff_old : $diff_new) + abs($diff_old - $diff_new);

        $this->_result['number_of_changes'] = $number_of_changes;

        return $this->_result;
    }

    private function findCommonChars($i = 0, $char_indexes_old = array(), $char_indexes_new = array(), $length = 0, $pos_2 = 0)
    {
        for ($i2=$i; $i2 < strlen($this->_new_string); $i2++) {
            $char = $this->_new_string[$i2];

            $pos = strpos($this->_old_string, $char, $pos_2);

            if ($pos === false) {
                continue;
            } else {
                if ($this->_method == 2)
                {
                    if (strpos($this->_old_string, $char, $pos_2 + 1) !== false){
                        $this->findCommonChars($i2 + 1, $char_indexes_old, $char_indexes_new, $length, $pos_2 + 1);
                    }
                }

                $char_indexes_old[] = $pos;
                $char_indexes_new[] = $i2;
                $length++;

                $pos_2 = $pos + 1;
            }
        }

        if ($length > $this->_result['common_chars_length'])
        {
            $this->_result = array(
                'common_chars_length' => $length,
                'common_char_indexes_old' => $char_indexes_old,
                'common_char_indexes_new' => $char_indexes_new);
        }
    }
}