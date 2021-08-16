<?php

namespace ArtARTs36\GitHandler\Command\Groups;

use ArtARTs36\GitHandler\Command\Groups\Contracts\GitTagCommandGroup;
use ArtARTs36\GitHandler\Data\Author;
use ArtARTs36\GitHandler\Data\Commit;
use ArtARTs36\GitHandler\Data\Tag;
use ArtARTs36\GitHandler\Exceptions\TagAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\TagNotFound;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\GitHandler\Support\FormatPlaceholder;
use ArtARTs36\ShellCommand\ShellCommand;

class TagCommand extends AbstractCommand implements GitTagCommandGroup
{
    public function getAll(?string $pattern = null): array
    {
        $raw = $this->builder->make()->addArgument('tag')
            ->when($pattern !== null, function (ShellCommand $command) use ($pattern) {
                $command
                    ->addCutOption('l')
                    ->addArgument($pattern, true);
            })->executeOrFail($this->executor)->getResult();

        return $raw->trim()->lines();
    }

    public function add(string $tag, ?string $message = null): bool
    {
        if ($this->exists($tag)) {
            throw new TagAlreadyExists($tag);
        }

        return $this
            ->builder
            ->make()
            ->addArgument('tag')
            ->addCutOption('a')
            ->addArgument($tag)
            ->addCutOption('m')
            ->addArgument($message ?? "Version {$tag}", true)
            ->executeOrFail($this->executor)
            ->isEmpty();
    }

    public function get(string $tag): Tag
    {
        $result = $this->builder
            ->make()
            ->addArgument('show')
            ->addArgument($tag)
            ->addOptionWithValue('pretty', FormatPlaceholder::format([
                FormatPlaceholder::AUTHOR_NAME,
                FormatPlaceholder::AUTHOR_EMAIL,
                FormatPlaceholder::AUTHOR_DATE_RFC2822,
                FormatPlaceholder::COMMIT_HASH,
                FormatPlaceholder::SUBJECT,
            ]))
            ->addCutOption('s')
            ->execute($this->executor);

        if ($result
            ->getError()
            ->contains("ambiguous argument '$tag': unknown revision or path not in the working tree")) {
            throw new TagNotFound($tag);
        }

        $parts = $result->getResult()->explode('|');

        if ($result->isFail() || count($parts) !== 5) {
            throw new UnexpectedException($result->getCommandLine());
        }

        [$authorName, $authorEmail, $date, $commit, $message] = $parts;

        return new Tag(
            new Author($authorName, $authorEmail),
            new \DateTime($date),
            new Commit($commit),
            $message
        );
    }

    public function exists(string $tag): bool
    {
        return in_array($tag, $this->getAll());
    }
}