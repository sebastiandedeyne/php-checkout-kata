<?php

namespace spec\Checkout;

use Checkout\Catalog;
use Checkout\Item;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CheckoutSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            new Catalog([
                new Item('A', 50, function($amount, $unitPrice) {
                    return (int) floor($amount / 3) * 130 + ($amount % 3) * $unitPrice;
                }),
                new Item('B', 30, function($amount, $unitPrice) {
                    return (int) floor($amount / 2) * 45 + ($amount % 2) * $unitPrice;
                }),
                new Item('C', 20),
                new Item('D', 15),
                new Item('E', 35, function($amount, $unitPrice) {
                    if ($amount < 2) return $amount * $unitPrice;
                    return (int) round($amount * $unitPrice * 0.9);
                }),
            ])
        );
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType('Checkout\Checkout');
    }

    function it_calculates_the_total_of_a_scanned_item()
    {
        $this->scan('A');
        $this->total()->shouldReturn(50);
    }

    function it_calculates_the_total_of_an_item_that_was_scanned_twice()
    {
        $this->scan('A');
        $this->scan('A');
        $this->total()->shouldReturn(100);
    }

    function it_calculates_the_total_of_different_scanned_items()
    {
        $this->scan('A');
        $this->scan('B');
        $this->total()->shouldReturn(80);
    }

    function it_calculates_the_total_with_special_prices()
    {
        $this->scan('A');
        $this->scan('A');
        $this->scan('A');
        $this->scan('B');
        $this->scan('E');
        $this->scan('E');
        $this->scan('E');
        $this->total()->shouldReturn(130 + 30 + 95);
    }
}
