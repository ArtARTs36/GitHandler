<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use ArtARTs36\Str\Str;

class DevelopmentCommandsTableBuilder
{
    protected $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function build(): string
    {
        $view = '';

        foreach ($this->buildMap() as $command => $description) {
            $view .= "|  ". $command . '    |    ' . $description . "\n";
        }

        return rtrim($view);
    }

    /**
     * @return array<string, string>
     */
    protected function buildMap(): array
    {
        $scripts = $this->getScripts();

        $table = [];

        foreach ($scripts as $name => $commands) {
            $table['composer '. $name] = Str::make(reset($commands))
                ->delete(['echo '])
                ->deleteFirstSymbol()
                ->deleteLastSymbol()
                ->trim();
        }

        return $table;
    }

    protected function getScripts(): array
    {
        $composer = file_get_contents($this->projectDir . DIRECTORY_SEPARATOR . 'composer.json');
        $composer = json_decode($composer, true);

        return $composer['scripts'];
    }
}
