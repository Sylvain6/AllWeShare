<?php

namespace spec\App\Entity;

use App\Entity\Role;
use PhpSpec\ObjectBehavior;

class RoleSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Role::class);
    }

    public function it_has_an_id_getter()
    {
        $this->getId()->shouldBeNull();
    }

    public function it_has_a_rolename_setter()
    {
        $this->setRolename('USER');
    }

    public function it_has_a_rolename()
    {
        $value = 'USER';
        $this->setRolename($value);
        $this->getRolename()->shouldReturn($value);
    }
}