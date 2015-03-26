<?php

namespace Checkout;

use Checkout\Exceptions\ItemNotInCatalogException;

class Catalog
{
    private $items = [];

    public function __construct(array $items)
    {
        $this->items = array_reduce($items, function($array, $item) {
            $array[$item->name()] = $item;
            return $array;
        }, []);
    }

    public function find($name)
    {
        if ( ! isset($this->items[$name])) {
            throw new ItemNotInCatalogException;
        }

        return $this->items[$name];
    }
}
