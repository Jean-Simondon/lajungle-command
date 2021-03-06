<?php
namespace YOUR_THEME_NAME\Helpers;

class TextHelper
{

    public static function printTruncated($maxLength, $html, $isUtf8=true)
    {
        $printedLength = 0;
        $position = 0;
        $tags = array();

        // For UTF-8, we need to count multibyte sequences as one character.
        $re = $isUtf8
                ? '{</?([a-z]+)[^>]*>|&#?[a-zA-Z0-9]+;|[\x80-\xFF][\x80-\xBF]*}'
                : '{</?([a-z]+)[^>]*>|&#?[a-zA-Z0-9]+;}';

        while ($printedLength < $maxLength && preg_match($re, $html, $match, PREG_OFFSET_CAPTURE, $position))
        {
            list($tag, $tagPosition) = $match[0];

            // Print text leading up to the tag.
            $str = substr($html, $position, $tagPosition - $position);
            if ($printedLength + strlen($str) > $maxLength)
            {
                print(substr($str, 0, $maxLength - $printedLength));
                $printedLength = $maxLength;
                break;
            }

            print($str);
            $printedLength += strlen($str);
            if ($printedLength >= $maxLength) break;

            if ($tag[0] == '&' || ord($tag) >= 0x80)
            {
                // Pass the entity or UTF-8 multibyte sequence through unchanged.
                print($tag);
                $printedLength++;
            }
            else
            {
                // Handle the tag.
                $tagName = $match[1][0];
                if ($tag[1] == '/')
                {
                    // This is a closing tag.

                    $openingTag = array_pop($tags);
                    assert($openingTag == $tagName); // check that tags are properly nested.

                    print($tag);
                }
                else if ($tag[strlen($tag) - 2] == '/')
                {
                    // Self-closing tag.
                    print($tag);
                }
                else
                {
                    // Opening tag.
                    print($tag);
                    $tags[] = $tagName;
                }
            }

            // Continue after the tag.
            $position = $tagPosition + strlen($tag);
        }

        // Print any remaining text.
        if ($printedLength < $maxLength && $position < strlen($html))
            print(substr($html, $position, $maxLength - $printedLength));

        // Close any open tags.
        while (!empty($tags))
            printf('</%s>', array_pop($tags));
    }

    /**
     * Tronquer une chaine de caract??re en ??vitant de couper le dernier mot
     */
    public static function tronquer_chaine_mot($string, $limit = 5, $fin = '...')
    {
        preg_match('/^\s*+(?:\S++\s*+){1,' .$limit. '}/u', $string, $matches);
        if (!isset($matches[0]) || strlen($string) === strlen($matches[0])) {
            return $string;
            }
        return rtrim($matches[0]).$fin;
    }

}