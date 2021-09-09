## v0.2.0

[See changes](https://github.com/ArtARTs36/GitHandler/compare/0.1.0...0.2.0)

### Added

* [Git Stash](https://github.com/ArtARTs36/GitHandler/blob/b765c99cea137625a8b7a0de97d6df434cd8d480/src/Git.php#L153)
* [Delete repository Action](https://github.com/ArtARTs36/GitHandler/blob/b765c99cea137625a8b7a0de97d6df434cd8d480/src/Action.php#L66)

---

## v0.2.1

[See changes](https://github.com/ArtARTs36/GitHandler/compare/0.2.0...0.2.1)

### Changed

* [Git clone support target folder](https://github.com/ArtARTs36/GitHandler/blob/200bd4af390018c89478411d23d15e6c2fd60a8e/src/Git.php#L133)

---

## v0.2.2

[See changes](https://github.com/ArtARTs36/GitHandler/compare/0.2.1...0.2.2)

### Added

* [Reinstall: Delete local repository and fetch from origin](https://github.com/ArtARTs36/GitHandler/blob/0.2.2/src/Action.php#L66)
* [Show remote](https://github.com/ArtARTs36/GitHandler/blob/1cb415c78cf0693b4d6a7ebd098212abce57d1c7/src/Git.php#L204)

---

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
