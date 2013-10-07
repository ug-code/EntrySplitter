<?php

/*
This class is oriented to separate a text which is composed of plain text or html.

*/

class EntrySplitter
{
    /*
     * This function return array of split plain text or html
     * $srt input text
     * $limit number of split by
     * $option option
     * 
     * return value array of split text or html
     */
    function split ($string, $limit = 100, $option = 0) {
        $str = str_replace(array("?r?n", "?r"), "?n", $str);
        $temp = preg_split("/(<?\/[^>]+>)(<[^>]+>)|(<?img[^>]+>)/s", $str, -1, PREG_SPLIT_DELIM_CAPTURE);

        if (count($temp) > 1) {
            $str = '';
            for($i = 0; $i < count($temp); $i++){
                $checkword = $temp[$i];
                if (!preg_match("/(<?\/[^>]+>)|(<?img[^>]+>)/s", $checkword)) {
                    if ($str != '') {
                        // splitted block is stack
                        $checkword = $str.$checkword;
                        $str = '';
                    }

                    $length = $limit;
                    for ( $j=0; $j<mb_strlen($checkword); $j+=$length ) {
                        $array[] = mb_substr($checkword,$j,$length);
                    }
                } else {
                    $str = $str.$temp[$i];
                    if(mb_strlen($str) > $limit){
                        $array[] = $str;
                        $str = '';
                    }
                }

            }
        } else {
            $length = $limit;
            for ( $i=0; $i<mb_strlen($temp[0]); $i+=$length ) {
                $array[] = mb_substr($temp[0],$i,$length);
            }
        }

        return (isset($array) ? $array : array());
    }
}
?>
