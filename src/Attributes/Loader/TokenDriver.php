<?php

namespace ArtARTs36\GitHandler\Attributes\Loader;

use ArtARTs36\GitHandler\Contracts\Attribute\GitAttribute;
use ArtARTs36\Str\Facade\Str;

final class TokenDriver extends AbstractAttributeLoadDriver
{
    private const FIND_INTERFACE = GitAttribute::class;

    public function fromProperties(\ReflectionClass $class, ?array $only = null): array
    {
        $tokens = token_get_all(file_get_contents($class->getFileName()));

        $pairs = $this->extractPairs($tokens);
        $requirements = $this->getRequirements($tokens);

        foreach ($pairs as &$pair) {
            $pair = array_merge($pair, Str::globalMatch(
                $pair['attribute_raw'],
                '#\#\[(?<attribute_name>.*)\((?<attribute_args>.*)\)\]#'
            )[0] ?? []);
        }

        $attributes = [];

        foreach ($pairs as $item) {
            if (empty($item['attribute_name'])) {
                continue;
            }

            $classString = $this->getClass($item['attribute_name'], $requirements);

            if ($classString === null || ! $this->isInputToFilterOnly($classString, $only)) {
                continue;
            }

            $attributes[$item['var']] = new $classString(...$this->extractArgs($item['attribute_args']));
        }

        return $attributes;
    }

    private function getClass(string $name, array $requirements): ?string
    {
        $classString = $name;

        if (! class_exists($classString)) {
            $classString = $requirements[$classString] ?? null;

            if ($classString === null || ! class_exists($classString)) {
                return null;
            }
        }

        if (! $this->isImplementsAttributeInterface($classString)) {
            return null;
        }

        return $classString;
    }

    private function isImplementsAttributeInterface(string $that): bool
    {
        return in_array(self::FIND_INTERFACE, class_implements($that));
    }

    private function getRequirements(array $tokens): array
    {
        $requirements = $named = [];
        $input = false;

        foreach ($tokens as $index => [$tokenId, $value, $other]) {
            // token USE
            if ($tokenId === 353) {
                $input = true;

                $requirements[] = '';
            } elseif ($input && $tokenId === 382) {
                continue;
            } elseif ($input && in_array($tokenId, [390, 319])) {
                $requirements[array_key_last($requirements)] .= $value;

                if ($tokens[$index + 1] === ';') {
                    $named[$value] = $requirements[array_key_last($requirements)];
                }
            } else {
                $input = false;
            }
        }

        return $named;
    }

    private function extractPairs(array $tokens): array
    {
        $pairs = $pair = [];

        foreach ($tokens as [$tokenId, $value, $other]) {
            if ($tokenId === 377) {
                $pair['attribute_raw'] = trim($value);
            } elseif (($tokenId === 320 && count($pair) === 1)) {
                $pair['var'] = Str::delete($value, ['$']);
                $pairs[] = $pair;
                $pair = [];
            }
        }

        return $pairs;
    }

    private function extractArgs(string $raw): array
    {
        return array_map(function (string $arg) {
            return trim($arg, "'\"");
        }, explode(',', $raw));
    }
}
