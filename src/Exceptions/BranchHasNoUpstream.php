<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

class BranchHasNoUpstream extends GitHandlerException
{
    public $errorBranch;

    public function __construct(string $branch, $code = 0, Throwable $previous = null)
    {
        $this->errorBranch = $branch;

        parent::__construct($this->prepareMessage(), $code, $previous);
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
