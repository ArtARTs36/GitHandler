<?php

namespace ArtARTs36\GitHandler;

/**
 * Class Action
 * @package ArtARTs36\GitHandler
 */
class Action
{
    /**
     * @var Git
     */
    protected $git;

    /**
     * Action constructor.
     * @param Git $git
     */
    public function __construct(Git $git)
    {
        $this->git = $git;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function createFolder(string $name): self
    {
        $path = $this->git->getDir() . DIRECTORY_SEPARATOR . $name;
        if (!file_exists($path)) {
            mkdir($path);
        }

        return $this;
    }
}
