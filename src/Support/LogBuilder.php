<?php

namespace ArtARTs36\GitHandler\Support;

use ArtARTs36\GitHandler\Contracts\Log\LogQueryBuilder;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;

class LogBuilder implements LogQueryBuilder
{
    /** @var array<string> */
    protected $filenames = [];

    /** @var array<array<string|int>> */
    protected $lines = [];

    /** @var list<string> */
    protected $authors = [];

    /** @var array<callable|self> */
    protected $join = [];

    /** @var array<string, array<string>> */
    protected $optionValues = [];

    public function offset(int $offset): self
    {
        return $this->setOptionValue('skip', (string) $offset);
    }

    public function limit(int $limit): self
    {
        return $this->setOptionValue('max-count', (string) $limit);
    }

    public function before(\DateTimeInterface $date): self
    {
        return $this->setOptionValueDate('before', $date);
    }

    public function after(\DateTimeInterface $date): self
    {
        return $this->setOptionValueDate('after', $date);
    }

    public function file(string $filename): self
    {
        $this->filenames[] = $filename;

        return $this;
    }

    public function author(string $author): self
    {
        $this->authors[] = $author;

        return $this;
    }

    public function grep(string $pattern): self
    {
        $this->optionValues['grep'][] = $pattern;

        return $this;
    }

    public function lines(string $filename, int $start, int $end): self
    {
        $this->lines[] = [$filename, $start, $end];

        return $this;
    }

    public function join(callable $build): self
    {
        $this->join[] = [$build, new self()];

        return $this;
    }

    public function build(ShellCommandInterface $command): ShellCommandInterface
    {
        $pureCommand = clone $command;

        return $command
            ->when(count($this->authors) > 0, function (ShellCommandInterface $command) {
                $command->addOptionWithValue('author', '"' . implode('|', $this->authors) . '"');
            })
            ->addArguments($this->filenames)
            ->when(count($this->optionValues) > 0, function (ShellCommandInterface $command) {
                foreach ($this->optionValues as $option => $values) {
                    foreach ($values as $value) {
                        $command->addOptionWithValue($option, $value);
                    }
                }
            })
            ->when(count($this->lines) > 0, function (ShellCommandInterface $command) use ($pureCommand) {
                foreach ($this->lines as $line) {
                    $command->joinAnd($this->wrapLine($pureCommand, $line));
                }
            })
            ->when(count($this->join) > 0, function (ShellCommandInterface $command) use ($pureCommand) {
                foreach ($this->join as [$callback, $builder]) {
                    $callback($builder);

                    $command->joinAnd($builder->build($pureCommand));
                }
            });
    }

    protected function setOptionValueDate(string $option, \DateTimeInterface $date): self
    {
        return $this->setOptionValue($option, '"'. $date->format('Y-m-d H:i:s') . '"');
    }

    protected function setOptionValue(string $option, string $value): self
    {
        $this->optionValues[$option][0] = $value;

        return $this;
    }

    /**
     * @param array<string|int> $line
     */
    protected function wrapLine(ShellCommandInterface $command, array $line): ShellCommandInterface
    {
        return $command
            ->addCutOption('L')
            ->addArgument($line[1] . ',' . $line[2] . ':' . $line[0], false);
    }
}