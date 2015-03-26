<?php

namespace Checkout;

class Item
{
    public function __construct($name, $unitPrice, $calculator = null)
    {
        $this->name = $name;
        $this->unitPrice = $unitPrice;

        if ( ! is_null($calculator)) {
            $this->calculator = $calculator;
        } else {
            $this->calculator = function($amount, $unitPrice) {
                return $amount * $unitPrice;
            };
        }
    }

    public function name()
    {
        return $this->name;
    }

    public function price()
    {
        return $this->unitPrice;
    }

    public function total($amount)
    {
        return call_user_func($this->calculator, $amount, $this->unitPrice);
    }
}
