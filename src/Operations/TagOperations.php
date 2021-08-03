<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Data\Author;
use ArtARTs36\GitHandler\Data\Tag;
use ArtARTs36\GitHandler\Exceptions\TagAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\TagNotFound;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\GitHandler\Support\FormatPlaceholder;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

trait TagOperations
{
    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?Str;

    public function getTags(?string $pattern = null): array
    {
        $raw = $this
            ->executeCommand(
                $this
                    ->newCommand()
                    ->addParameter('tag')
                    ->when($pattern !== null, function (ShellCommand $command) use ($pattern) {
                        $command
                            ->addCutOption('l')
                            ->addParameter($pattern, true);
                    })
            );

        if ($raw === null || $raw->isEmpty()) {
            return [];
        }

        return $raw->trim()->lines();
    }

    /**
     * @throws TagAlreadyExists
     */
    public function performTag(string $tag, ?string $message = null): bool
    {
        if ($this->isTagExists($tag)) {
            throw new TagAlreadyExists($tag);
        }

        return $this->executeCommand($this->newCommand()
                ->addParameter('tag')
                ->addCutOption('a')
                ->addParameter($tag)
                ->addCutOption('m')
                ->addParameter($message ?? "Version {$tag}", true)) === null;
    }

    public function getTag(string $tag): Tag
    {
        $result = $this->executeCommand(
            $cmd = $this
                ->newCommand()
                ->addParameter('show')
                ->addParameter($tag)
                ->addOptionWithValue('pretty', FormatPlaceholder::format([
                    FormatPlaceholder::AUTHOR_NAME,
                    FormatPlaceholder::AUTHOR_EMAIL,
                    FormatPlaceholder::AUTHOR_DATE_RFC2822,
                    FormatPlaceholder::COMMIT_HASH,
                    FormatPlaceholder::SUBJECT,
                ]))
                ->addCutOption('s')
        );

        if ($result === null) {
            throw new UnexpectedException($cmd);
        }

        if ($result->contains("ambiguous argument '$tag': unknown revision or path not in the working tree")) {
            throw new TagNotFound($tag);
        }

        $parts = $result->explode('|');

        if (count($parts) !== 5) {
            throw new UnexpectedException($cmd);
        }

        [$authorName, $authorEmail, $date, $commit, $message] = $parts;

        return new Tag(
            new Author($authorName, $authorEmail),
            new \DateTime($date),
            $commit,
            $message
        );
    }

    public function isTagExists(string $tag): bool
    {
        return in_array($tag, $this->getTags());
    }
}
