<?php

namespace Checkout;

class Checkout
{
    private $catalog;
    private $items = [];

    public function __construct(Catalog $catalog)
    {
        $this->catalog = $catalog;
    }

    public function scan($itemName)
    {
        $item = $this->catalog->find($itemName);

        if (array_key_exists($item->name, $this->items)) {
            $this->items[$item->name]++;
        } else {
            $this->items[$item->name] = 1;
        }
    }

    public function total()
    {
        return array_reduce(array_keys($this->items), function($total, $itemName) {
            $item = $this->catalog->find($itemName);
            return $total += $item->total($this->items[$itemName]);
        }, 0);
    }
}
