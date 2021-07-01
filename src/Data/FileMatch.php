<?php

namespace ArtARTs36\GitHandler\Data;

use ArtARTs36\GitHandler\Support\ToArray;

class FileMatch
{
    use ToArray;

    public $file;

    public $line;

    public $content;

    /**
     * @codeCoverageIgnore
     */
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
