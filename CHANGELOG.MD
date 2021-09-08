## v0.2.0

[See changes](https://github.com/ArtARTs36/GitHandler/compare/0.1.0...0.2.0)

### Added

* [Git Stash](https://github.com/ArtARTs36/GitHandler/blob/b765c99cea137625a8b7a0de97d6df434cd8d480/src/Git.php#L153)
* [Delete repository Action](https://github.com/ArtARTs36/GitHandler/blob/b765c99cea137625a8b7a0de97d6df434cd8d480/src/Action.php#L66)

## v1.1.0

### Added

* Support git submodules (See [Interface](./src/Contracts/Commands/GitSubmoduleCommand.php)):
    * Add Module
    * Determine is exists submodule
    * Get all submodules
    * Remove submodule
    * Sync submodule
    
* Enum [ConfigScope](./src/Enum/ConfigScope.php)

* Config unset

* Git Index :: removeCached

* Config Submodule Subject

* Git Workflow (dump & restore hooks, config)

* GitFileCommand::getContent
