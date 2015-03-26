<?php

namespace spec\Checkout;

use Checkout\Item;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CatalogSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([new Item('A', 50), new Item('B', 30)]);
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType('Checkout\Catalog');
    }

    function it_can_find_an_item_by_name()
    {
        $this->shouldThrow('Checkout\Exceptions\ItemNotInCatalogException')->duringFind('C');
        $this->find('A')->shouldReturnAnInstanceOf('Checkout\Item');
    }
}
