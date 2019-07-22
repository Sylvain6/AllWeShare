<?php

namespace spec\App\Entity;

use App\Entity\Service;
use PhpSpec\ObjectBehavior;

class ServiceSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Service::class);
    }

    public function it_has_an_id_getter()
    {
        $this->getId()->shouldBeNull();
    }

    public function it_has_a_name_setter()
    {
        $this->setName('Service');
    }

    public function it_has_a_name()
    {
        $value = 'Service';
        $this->setName($value);
        $this->getName()->shouldReturn($value);
    }
}