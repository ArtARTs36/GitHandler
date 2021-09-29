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
     * @return $this
     */
    public function lines(string $filename, int $start, int $end);

    /**
     * @param LogQueryAction|callable $build
     * @return $this
     */
    public function join(callable $build);
}
