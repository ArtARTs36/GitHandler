<?php

namespace ArtARTs36\GitHandler\DocBuilder;

class MethodSignature
{
    public $signature;

    public $exampleArguments;

    public $suggests;

    public function __construct(string $signature, array $exampleArguments, array $suggests)
    {
        $this->signature = $signature;
        $this->exampleArguments = $exampleArguments;
        $this->suggests = $suggests;
    }

    public function argsAsLine(): string
    {
        return implode(', ', $this->exampleArguments);
    }
}
