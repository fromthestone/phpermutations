<?php

namespace drupol\phpermutations\Iterators;

use drupol\phpermutations\Iterators;

/**
 * Class Combinations.
 */
class Combinations extends Iterators
{
    /**
     * The values.
     *
     * @var array
     */
    protected $c = [];

    /**
     * Combinations constructor.
     *
     * @param array    $dataset
     *                          The dataset
     * @param null|int $length
     *                          The length
     */
    public function __construct(array $dataset = [], $length = null)
    {
        parent::__construct(\array_values($dataset), $length);
        $this->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        $i = 0;

        for ($this->rewind(); $this->valid(); $this->next()) {
            ++$i;
        }

        return $i;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        $r = [];

        for ($i = 0; $i < $this->length; ++$i) {
            $r[] = $this->dataset[$this->c[$i]];
        }

        return $r;
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        if ($this->nextHelper()) {
            ++$this->key;
        } else {
            $this->key = -1;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->c = \range(0, $this->length);
        $this->key = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return 0 <= $this->key;
    }

    /**
     * Custom next() callback.
     *
     * @return bool
     *              Return true or false
     */
    protected function nextHelper()
    {
        $i = $this->length - 1;
        while (0 <= $i && $this->datasetCount - $this->length + $i === $this->c[$i]) {
            --$i;
        }

        if (0 > $i) {
            return false;
        }

        ++$this->c[$i];
        while ($this->length - 1 > $i++) {
            $this->c[$i] = $this->c[$i - 1] + 1;
        }

        return true;
    }
}
