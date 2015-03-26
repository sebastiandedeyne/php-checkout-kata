<?php

namespace spec\Checkout;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ItemSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('A', 50);
        $this->shouldHaveType('Checkout\Item');
    }

    function it_has_a_name()
    {
        $this->beConstructedWith('A', 50);
        $this->name()->shouldReturn('A');
    }

    function it_has_a_unit_price()
    {
        $this->beConstructedWith('A', 50);
        $this->price()->shouldReturn(50);
    }

    function it_can_calculate_a_simple_total()
    {
        $this->beConstructedWith('A', 50);
        $this->total(2)->shouldReturn(100);
    }

    function it_can_calculate_a_complex_total()
    {
        $this->beConstructedWith('A', 50, function($amount, $unitPrice) {
            return (int) floor($amount / 3) * 130 + ($amount % 3) * $unitPrice;
        });
        
        $this->total(4)->shouldReturn(180);
    }
}
