<?php

namespace ArtARTs36\GitHandler\Data;

class FileMatch
{
    public $file;

    public $line;

    public $content;

    public function __construct(string $file, int $line, string $content)
    {
        $this->file = $file;
        $this->line = $line;
        $this->content = $content;
    }

    public static function fromArray(
        array $data
    ): self {
        return new static($data['file'], $data['line'], $data['content']);
    }
}