<?php

namespace drupol\phpermutations\Iterators;

use drupol\phpermutations\Iterators;

/**
 * Class Product.
 */
class Product extends Iterators
{
    /**
     * The iterators.
     *
     * @var \Iterator[]
     */
    protected $iterators = [];

    /**
     * Product constructor.
     *
     * @param array $datasetArray
     *                            The array of dataset
     */
    public function __construct(array $datasetArray)
    {
        parent::__construct($datasetArray);

        foreach ($datasetArray as $dataset) {
            $this->iterators[] = new \ArrayIterator($dataset);
        }

        $this->key = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        $product = 1;

        foreach ($this->getDataset() as $dataset) {
            $product *= \count($dataset);
        }

        return $product;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        $tuple = [];

        foreach ($this->iterators as $iterator) {
            $tuple[] = $iterator->current();
        }

        return $tuple;
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        foreach (\array_reverse($this->iterators) as $key => $iterator) {
            $iterator->next();
            if ($iterator->valid()) {
                $count_iterators = \count($this->iterators);
                foreach ($this->iterators as $key2 => $iterator2) {
                    if ($count_iterators - $key2 <= $key) {
                        $iterator2->rewind();
                    }
                }

                break;
            }
        }

        ++$this->key;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        foreach ($this->iterators as $iterator) {
            $iterator->rewind();
        }

        $this->key = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        $isUnlessOneValid = false;

        foreach ($this->iterators as $iterator) {
            if ($iterator->valid()) {
                $isUnlessOneValid = true;
            }
        }

        return $isUnlessOneValid;
    }
}
