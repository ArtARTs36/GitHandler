<?php

namespace ArtARTs36\GitHandler\Exceptions;

class BranchHasNoUpstream extends GitHandlerException
{
    public $errorBranch;

    public function __construct(string $branch)
    {
        $this->errorBranch = $branch;

        parent::__construct($this->prepareMessage());
    }

    /**
     * @codeCoverageIgnore
     */
    public static function patternStdError(): string
    {
        return "The current branch (.*) has no upstream branch";
    }

    protected function prepareMessage(): string
    {
        return "The current branch $this->errorBranch has no upstream branch";
    }
}
