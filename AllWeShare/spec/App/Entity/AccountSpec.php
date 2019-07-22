<?php

namespace spec\App\Entity;

use App\Entity\Account;
use PhpSpec\ObjectBehavior;

class AccountSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Account::class);
    }

    public function it_has_an_id_getter()
    {
        $this->getId()->shouldBeNull();
    }

    public function it_has_a_email_setter()
    {
        $this->setEmail('sylvain.coutrot@hotmail.fr');
    }

    public function it_has_a_email()
    {
        $value = 'sylvain.coutrot@hotmail.fr';
        $this->setEmail($value);
        $this->getEmail()->shouldReturn($value);
    }
    public function it_has_a_pwd_setter()
    {
        $this->setPwd('azertyuiop');
    }

    public function it_has_a_pwd()
    {
        $value = 'azertyuiop';
        $this->setPwd($value);
        $this->getPwd()->shouldReturn($value);
    }
}