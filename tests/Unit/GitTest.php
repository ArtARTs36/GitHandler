<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\GitHandler\Exceptions\NothingToCommit;
use ArtARTs36\GitHandler\Exceptions\PathAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;

final class GitTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Git::checkout
     */
    public function testCheckout(): void
    {
        $response = $this->mockGit("Already on 'master'")
            ->checkout('master');

        self::assertTrue($response);

        //

        self::expectException(BranchNotFound::class);

        $this->mockGit("pathspec 'random' did not match any")
            ->checkout('random');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::pull
     */
    public function testPull(): void
    {
        $git = $this->mockGit('Already up to date');

        self::assertTrue($git->pull());

        //

        $git = $this->mockGit("Receiving objects: 100% \n Resolving deltas: 100%");

        self::assertTrue($git->pull());

        //

        $git = $this->mockGit("Receiving objects: 100% \n Resolving deltas: 100%");

        self::assertTrue($git->pull('master'));

        //

        self::expectException(UnexpectedException::class);

        $this->mockGit('')->pull();
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::status
     */
    public function testStatus(): void
    {
        $expected = $shellResult = 'On branch master

No commits yet

Changes to be committed:
';

        $git = $this->mockGit($shellResult);

        //

        self::assertEquals($expected, $git->status());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::add
     */
    public function testAdd(): void
    {
        $git = $this->mockGit('');

        self::assertTrue($git->add('README.MD'));

        //

        $git = $this->mockGit(null);

        self::assertTrue($git->add('README.MD', true));

        //

        self::expectException(FileNotFound::class);

        $git = $this->mockGit("pathspec 'random.file' did not match any files");

        $git->add('random.file');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::add
     */
    public function testAddOnUndefinedResult(): void
    {
        $git = $this->mockGit('undefined');

        self::expectException(UnexpectedException::class);

        $git->add('doc.txt');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::clone
     */
    public function testClone(): void
    {
        $folder = 'project';
        $dir = '/var/web/'. $folder;
        $url = 'http://url.git';

        //

        $git = $this->mockGit("Cloning into '{$folder}' ...", $dir);

        self::assertTrue($git->clone($url));

        //

        self::expectException(PathAlreadyExists::class);

        $this->mockGit("fatal: destination path '{$folder}' already exists " .
            "and is not an empty directory.", $dir)->clone($url);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::clone
     */
    public function testCloneUndefinedError(): void
    {
        $git = $this->mockGit(null);

        self::expectException(UnexpectedException::class);

        $git->clone('');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::clone
     */
    public function testCloneBranch(): void
    {
        $folder = 'project';
        $dir = '/var/web/'. $folder;
        $url = 'http://url.git';
        $branch = 'dev';

        $git = $this->mockGit("Cloning into '{$folder}' ...", $dir);

        self::assertTrue($git->clone($url, $branch));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::showRemote
     */
    public function testShowRemote(): void
    {
        $git = $this->mockGit('* remote origin
  Fetch URL: https://github.com/ArtARTs36/GitHandler.git
  Push  URL: https://github.com/ArtARTs36/GitHandler.git
  HEAD branch: master
  Remote branch:
    master tracked
  Local branch configured for \'git pull\':
    master merges with remote master
  Local ref configured for \'git push\':
    master pushes to master (up to date)
');

        $expected = [
            'fetch' => 'https://github.com/ArtARTs36/GitHandler.git',
            'push' => 'https://github.com/ArtARTs36/GitHandler.git',
        ];

        self::assertEquals($expected, $git->showRemote()->toArray());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::version
     */
    public function testVersion(): void
    {
        $git = $this->mockGit('git version 2.24.3 (Apple Git-128)
');

        self::assertEquals('git version 2.24.3 (Apple Git-128)', $git->version());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::getInfoPath
     * @covers \ArtARTs36\GitHandler\Git::getPathByOption
     */
    public function testGetInfoPath(): void
    {
        $git = $this->mockGit('/Applications/Xcode.app/Contents/Developer/usr/share/info
');

        self::assertEquals('/Applications/Xcode.app/Contents/Developer/usr/share/info', $git->getInfoPath());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::getHtmlPath
     * @covers \ArtARTs36\GitHandler\Git::getPathByOption
     */
    public function testGetHtmPath(): void
    {
        $git = $this->mockGit('/Applications/Xcode.app/Contents/Developer/usr/share/doc/git-doc
');

        self::assertEquals('/Applications/Xcode.app/Contents/Developer/usr/share/doc/git-doc', $git->getHtmlPath());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::getManPath
     * @covers \ArtARTs36\GitHandler\Git::getPathByOption
     */
    public function testManPath(): void
    {
        $git = $this->mockGit('/Applications/Xcode.app/Contents/Developer/usr/share/man
');

        self::assertEquals('/Applications/Xcode.app/Contents/Developer/usr/share/man', $git->getManPath());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::getDir
     */
    public function testGetDir(): void
    {
        $git = $this->mockGit('', $dir = '/path/to/dir');

        self::assertEquals($dir, $git->getDir());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::getPathByOption
     */
    public function testGetPathByOptionOnNullResult(): void
    {
        self::expectException(UnexpectedException::class);

        $this->callMethodFromObject($this->mockGit(null), 'getPathByOption', 't');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::getPathByOption
     */
    public function testGetPathByOptionOnEmptyResult(): void
    {
        self::expectException(UnexpectedException::class);

        $this->callMethodFromObject($this->mockGit(''), 'getPathByOption', 't');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::commit
     */
    public function testCommitOnNullCommand(): void
    {
        self::expectException(UnexpectedException::class);

        $this->mockGit(null)->commit('');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::commit
     */
    public function testCommitOnEmptyCommand(): void
    {
        self::expectException(UnexpectedException::class);

        $this->mockGit('')->commit('');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::commit
     */
    public function testCommitOnNothingToCommit(): void
    {
        self::expectException(NothingToCommit::class);

        $this->mockGit('nothing to commit')->commit('');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::commit
     */
    public function testCommitOnFileChanged(): void
    {
        self::assertTrue($this->mockGit('file changed')->commit('', true));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::help
     */
    public function testHelp(): void
    {
        $git = $this->mockGit($expected = 'help description');

        self::assertEquals($expected, $git->help());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::help
     */
    public function testHelpOnNullCommand(): void
    {
        self::expectException(UnexpectedException::class);

        $this->mockGit(null)->help();
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::help
     */
    public function testHelpOnEmptyCommand(): void
    {
        self::expectException(UnexpectedException::class);

        $this->mockGit('')->help();
    }
}
