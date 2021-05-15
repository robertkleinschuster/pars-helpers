<?php


namespace Pars\Helper\String;


use Cocur\Slugify\Slugify;
use joshtronic\LoremIpsum;
use Pars\Helper\Placeholder\PlaceholderHelper;

/**
 * Class StringHelper
 * @package Pars\Helper\String
 */
class StringHelper
{
    private const HTML_ENCODE_DELEIMITER = ' #<!># ';

    /**
     * @param string $str
     * @param string $needle
     * @return bool
     */
    public static function startsWith(string $str, string $needle): bool
    {
        $length = strlen( $needle );
        return substr( $str, 0, $length ) === $needle;
    }

    /**
     * @param string $str
     * @param array $needle_List
     * @return bool
     */
    public static function startsWithAny(string $str, array $needle_List): bool
    {
        foreach ($needle_List as $needle) {
            if (self::startsWith($str, $needle)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $str
     * @param string $needle
     * @return bool
     */
    public static function endsWith(string $str, string $needle): bool
    {
        $length = strlen( $needle );
        if( !$length ) {
            return true;
        }
        return substr( $str, -$length ) === $needle;
    }

    /**
     * @param string $html
     * @return array|string|string[]
     */
    public static function stripString(string $html)
    {
        $result = $html;
        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        foreach ($dom->getElementsByTagName('*') as $node) {
            if (in_array($node->tagName, self::getSafeHtmlTagName_List())) {
                $attributes = "";
                foreach ($node->attributes as $item) {
                    $attributes.= " {$item->name}='{$item->value}'";
                }

                $openTag = "<{$node->tagName}{$attributes}>";
                $closeTag = "</{$node->tagName}>";
                $openTag2 = str_replace("'", '"', $openTag);
                $result = str_replace($openTag, '', $result);
                $result = str_replace($openTag2, '', $result);
                $result = str_replace($closeTag, '', $result);
            }
        }

        $placeholders = PlaceholderHelper::findPlaceholderResolved($result);
        foreach ($placeholders as $placeholder => $placeholderClean) {
            $result = str_replace($placeholder, '', $result);
        }

        return $result;
    }

    public static function encodeHtml(string $html): string
    {
        $encodeTag = function (string $tag) {
            $delimiter = self::HTML_ENCODE_DELEIMITER;
            return $delimiter . base64_encode($tag) . $delimiter;
        };

        $result = $html;
        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        foreach ($dom->getElementsByTagName('*') as $node) {
            if (in_array($node->tagName, self::getSafeHtmlTagName_List())) {
                $attributes = "";
                foreach ($node->attributes as $item) {
                    $attributes.= " {$item->name}='{$item->value}'";
                }

                $openTag = "<{$node->tagName}{$attributes}>";
                $closeTag = "</{$node->tagName}>";
                $openTag2 = str_replace("'", '"', $openTag);
                $result = str_replace($openTag, $encodeTag($openTag), $result);
                $result = str_replace($openTag2, $encodeTag($openTag2), $result);
                $result = str_replace($closeTag, $encodeTag($closeTag), $result);
            }
        }

        $placeholders = PlaceholderHelper::findPlaceholderResolved($result);
        foreach ($placeholders as $placeholder => $placeholderClean) {
            $result = str_replace($placeholder, $encodeTag($placeholder), $result);
        }

        return $result;
    }

    /**
     * @param string $string
     * @return string
     */
    public static function decodeHtml(string $string): string
    {
        $delimiter = self::HTML_ENCODE_DELEIMITER;
        $decodeTag = function (string $tag) {
            $tag = str_replace(self::HTML_ENCODE_DELEIMITER, '', $tag);
            return base64_decode($tag);
        };

        $result = $string;
        $matches = [];
        preg_match_all("/$delimiter.*?$delimiter/", $string, $matches);
        $it = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($matches));

        foreach ($it as $code) {
            $result = str_replace($code, $decodeTag($code), $result);
        }
        return $result;
    }

    public static function getSafeHtmlTagName_List(): array
    {
        return [
            'div',
            'span',
            'pre',
            'p',
            'br',
            'hr',
            'hgroup',
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
            'ul',
            'ol',
            'li',
            'dl',
            'dt',
            'dd',
            'strong',
            'em',
            'b',
            'i',
            'u',
            'img',
            'a',
            'abbr',
            'address',
            'blockquote',
        ];
    }

    /**
     * @param string $string
     * @return string
     */
    public static function slugify(string $string): string
    {
        return (new Slugify())->slugify($string);
    }

    /**
     * @param int $words
     * @return string
     */
    public static function lipsum(int $words): string
    {
        $lipsum = new LoremIpsum();
        return $lipsum->words($words);
    }
}
