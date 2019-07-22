<?php

namespace spec\App\Entity;

use App\Entity\TransactionType;
use PhpSpec\ObjectBehavior;

class TransactionTypeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(TransactionType::class);
    }

    public function it_has_an_id_getter()
    {
        $this->getId()->shouldBeNull();
    }

    public function it_has_a_name_setter()
    {
        $this->setName('Transac');
    }

    public function it_has_a_name()
    {
        $value = 'Transac';
        $this->setName($value);
        $this->getName()->shouldReturn($value);
    }
}