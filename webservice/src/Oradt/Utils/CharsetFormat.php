<?php
/**
 * @file   CharsetFormat.php
 * <long description>
 * used for format the vcard info
 * @author Lyn
 * @date   2016-01-27
 */
namespace Oradt\Utils;
class CharsetFormat {
    /**
     * replace map
     */
   private static $replace_map =  array(
        '【' => '[',
        '】' => ']',
        '（' => '(',
        '）' => ')',
        '＜' => '<',
        '＞' => '>',
        '—' => '-',
        '－' => '-',
        '_' => '_',
        '；' => ';',
        '：' => ':',
        '。' => '.',
        '▪' => '·',
        '○' => '·',
        '•' => '·',
        '，' => ',',
        '、' => ',',
        '’' => '\'',
        '`' => '\'',
        '“' => '"',
        '”' => '"',
        '®' => ''
    );

/**
 * <long-description>
 * used for replace special char
 * @param data
 * @param replace_map
 * @return <ReturnValue>
 */
    public static function charsetReplace($data, $replace_map=''){
        if(empty($replace_map)) {
            $replace_map = self::$replace_map;
        }

        $tempData = $data;

        while(list($search, $replace) = each($replace_map)) {
            $tempData = str_replace($search, $replace, $tempData);
        }

        return $tempData;
    }
}