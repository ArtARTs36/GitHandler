<?php

namespace ArtARTs36\GitHandler\Support;

use ArtARTs36\GitHandler\Contracts\Log\LogQuery;
use ArtARTs36\GitHandler\Contracts\Log\LogQueryBuilder;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;

class LogBuilder implements LogQueryBuilder
{
    /** @var array<string> */
    protected $filenames = [];

    /** @var list<string> */
    protected $authors = [];

    /** @var array<callable|self> */
    protected $unions = [];

    /** @var array<string, array<string>> */
    protected $optionValues = [];

    /** @var array<string> */
    protected $diff = null;

    public function offset(int $offset): self
    {
        if ($offset === 0) {
            return $this;
        }

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

    public function union(callable $build): self
    {
        $this->unions[] = [$build, new self()];

        return $this;
    }

    /**
     * @return $this
     */
    public function diff(string $src, string $dest)
    {
        $this->diff = [$src, $dest];

        return $this;
    }

    public function build(ShellCommandInterface $command): ShellCommandInterface
    {
        $pureCommand = clone $command;

        return $command
            ->when(count($this->authors) > 0, function (ShellCommandInterface $command) {
                $command->addOptionWithValue('author', implode('|', $this->authors), true);
            })
            ->addArguments($this->filenames)
            ->when($this->diff !== null, function (ShellCommandInterface $command) {
                $command->addArgument($this->diff[0] . '..' . $this->diff[1], false);
            })
            ->when(count($this->optionValues) > 0, function (ShellCommandInterface $command) {
                foreach ($this->optionValues as $option => $values) {
                    foreach ($values as $value) {
                        $command->addOptionWithValue($option, $value, true);
                    }
                }
            })
            ->when(count($this->unions) > 0, function (ShellCommandInterface $command) use ($pureCommand) {
                foreach ($this->unions as [$callback, $builder]) {
                    $callback($builder);

                    $command->joinAnd($builder->build($pureCommand));
                }
            });
    }

    protected function setOptionValueDate(string $option, \DateTimeInterface $date): self
    {
        return $this->setOptionValue($option, $date->format('Y-m-d H:i:s'));
    }

    protected function setOptionValue(string $option, string $value): self
    {
        $this->optionValues[$option][0] = $value;

        return $this;
    }
}
