<?php

namespace ArtARTs36\GitHandler\Concerns;

trait SwitchFolder
{
    protected $folder;

    public function seeToRoot(): self
    {
        $this->folder = $this->context->getRootDir();

        return $this;
    }

    public function seeToFolder(string $folder): self
    {
        $this->folder = $this->context->getRootDir() . DIRECTORY_SEPARATOR . $folder;

        return $this;
    }
}
