<?php

namespace spec\App\Entity;

use App\Entity\Bundle;
use PhpSpec\ObjectBehavior;

class BundleSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Bundle::class);
    }

    public function it_has_an_id_getter()
    {
        $this->getId()->shouldBeNull();
    }

    public function it_has_a_name_setter()
    {
        $this->setName('Sylvain');
    }

    public function it_has_a_name()
    {
        $value = 'Sylvain';
        $this->setName($value);
        $this->getName()->shouldReturn($value);
    }
    public function it_has_a_nbr_subscriber_setter()
    {
        $this->setNbrSubscriber(10);
    }

    public function it_has_a_nbr_subscriber()
    {
        $value = 10;
        $this->setNbrSubscriber($value);
        $this->getNbrSubscriber()->shouldReturn($value);
    }
}