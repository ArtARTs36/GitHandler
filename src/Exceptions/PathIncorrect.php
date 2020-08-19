<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

/**
 * Class PathIncorrect
 * @package ArtARTs36\GitHandler\Exceptions
 */
class PathIncorrect extends \LogicException
{
    /**
     * PathIncorrect constructor.
     * @param $path
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($path, $code = 0, Throwable $previous = null)
    {
        $message = "Path {$path} incorrect!";

        parent::__construct($message, $code, $previous);
    }
}
