<?php

namespace ArtARTs36\GitHandler\Attributes\Loader;

use ArtARTs36\GitHandler\Contracts\Attribute\AttributeLoadDriver;
use ArtARTs36\GitHandler\Contracts\Attribute\GitAttribute;
use ArtARTs36\Str\Facade\Str;

final class TokenDriver implements AttributeLoadDriver
{
    private const FIND_INTERFACE = GitAttribute::class;

    public function fromProperties(\ReflectionClass $class): array
    {
        $content = file_get_contents($class->getFileName());
        $tokens = token_get_all($content);

        $resolved = $this->extractPairs($tokens);
        $requirements = $this->getRequirements($tokens);

        foreach ($resolved as &$item) {
            $item = array_merge($item, Str::globalMatch(
                $item['attribute_raw'],
                '#\#\[(?<attribute_name>.*)\((?<attribute_args>.*)\)\]#'
            )[0] ?? []);
        }

        unset($item);

        $attributes = [];

        foreach ($resolved as $item) {
            if (empty($item['attribute_name'])) {
                continue;
            }

            $classString = $requirements[$item['attribute_name']];

            if (! class_exists($classString)) {
                $classString = $requirements[$classString] ?? null;

                if ($classString === null || ! class_exists($classString)) {
                    continue;
                }
            }

            if (! class_implements($classString, self::FIND_INTERFACE)) {
                continue;
            }

            $attributes[$item['var']] = new $classString(...$this->extractArgs($item['attribute_args']));
        }

        return $attributes;
    }

    private function getRequirements(array $tokens): array
    {
        $requirements = [];
        $input = false;

        foreach ($tokens as [$tokenId, $value, $other]) {
            if ($tokenId === 353) {
                $input = true;

                $requirements[] = '';
            } elseif ($input && $tokenId === 382) {
                continue;
            } elseif ($input && in_array($tokenId, [390, 319])) {
                $requirements[array_key_last($requirements)] .= $value;
            } else {
                $input = false;
            }
        }

        $named = [];

        foreach ($requirements as $requirement) {
            $named[\ArtARTs36\Str\Str::make($requirement)->explode('\\')->last()] = $requirement;
        }

        return $named;
    }

    private function extractPairs(array $tokens): array
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
