<?php

namespace ArtARTs36\GitHandler\Attributes\Loader;

use ArtARTs36\GitHandler\Contracts\Attribute\AttributeLoadDriver;
use ArtARTs36\Str\Facade\Str;

/**
 * @internal
 * Safety only self attributes
 */
class TokenDriver implements AttributeLoadDriver
{
    private static $namespace = "\ArtARTs36\GitHandler\Attributes\\";

    public function fromProperties(\ReflectionClass $class): array
    {
        $content = file_get_contents($class->getFileName());
        $tokens = token_get_all($content);

        $resolved = $this->extractVarAttributePairs($tokens);

        foreach ($resolved as &$item) {
            $item = array_merge($item, Str::globalMatch(
                $item['attribute_raw'],
                '#\#\[(?<attribute_name>.*)\((?<attribute_args>.*)\)\]#'
            )[0] ?? []);
        }

        unset($item);

        $attributes = [];

        foreach ($resolved as $item) {
            if (isset($item['attribute_name'])) {
                $class = self::$namespace . $item['attribute_name'];

                if (! class_exists($class)) {
                    continue;
                }

                $attributes[$item['var']] = new $class(... $this->extractArgs($item['attribute_args']));
            }
        }

        return $attributes;
    }

    private function extractVarAttributePairs(array $tokens): array
    {
        $resolved = [];

        $pair = [];

        foreach ($tokens as [$tokenId, $value, $other]) {
            if ($tokenId === 377) {
                $pair['attribute_raw'] = trim($value);
            } elseif (($tokenId === 320 && count($pair) === 1)) {
                $pair['var'] = Str::delete($value, ['$']);
                $resolved[] = $pair;
                $pair = [];
            }
        }

        return $resolved;
    }

    private function extractArgs(string $raw): array
    {
        return array_map(function (string $arg) {
            return trim($arg, "'\"");
        }, explode(',', $raw));
    }
}
