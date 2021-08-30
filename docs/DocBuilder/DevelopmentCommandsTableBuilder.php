<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use ArtARTs36\Str\Str;
use ArtARTs36\Str\Tab;

class DevelopmentCommandsTableBuilder
{
    protected $project;

    public function __construct(Project $projectDir)
    {
        $this->project = $projectDir;
    }

    public function build(): string
    {
        $view = '';

        $commands = $this->buildMap();
        $commandNames = Tab::addSpaces(array_keys($commands));
        $commandDescriptions = array_values($commands);

        foreach ($commandDescriptions as $index => $description) {
            $view .= "|  ". $commandNames[$index] . '    |    ' . $description . "\n";
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
        $composer = file_get_contents($this->project->getRootDir() . DIRECTORY_SEPARATOR . 'composer.json');
        $composer = json_decode($composer, true);

        return $composer['scripts'];
    }
}
