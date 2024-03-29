<?php

namespace ArtARTs36\GitHandler\Data;

use ArtARTs36\GitHandler\Contracts\Common\Arrayable;
use ArtARTs36\GitHandler\Support\ToArray;
use JetBrains\PhpStorm\ArrayShape;

class FileMatch implements Arrayable
{
    use ToArray;

    public $file;

    public $line;

    public $content;

    public function __construct(string $file, int $line, string $content)
    {
        $this->file = $file;
        $this->line = $line;
        $this->content = $content;
    }

    /**
     * @param array<string, string|int> $data
     */
    public static function fromArray(
        #[ArrayShape(['file' => 'string', 'line' => 'int', 'content' => 'string'])]
        array $data
    ): self {
        return new self($data['file'], $data['line'], $data['content']);
    }

    public function getReference(): string
    {
        return $this->file . ':' . $this->line;
    }
}
