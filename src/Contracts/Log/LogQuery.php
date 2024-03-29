<?php

namespace ArtARTs36\GitHandler\Contracts\Log;

interface LogQuery
{
    /**
     * @return $this
     */
    public function offset(int $offset);

    /**
     * @return $this
     */
    public function limit(int $limit);

    /**
     * @return $this
     */
    public function before(\DateTimeInterface $date);

    /**
     * @return $this
     */
    public function after(\DateTimeInterface $date);

    /**
     * @return $this
     */
    public function file(string $filename);

    /**
     * @return $this
     */
    public function author(string $author);

    /**
     * @return $this
     */
    public function grep(string $pattern);

    /**
     * @param LogQueryAction|callable $build
     * @return $this
     */
    public function union(callable $build);

    /**
     * @return $this
     */
    public function diff(string $src, string $dest);
}
