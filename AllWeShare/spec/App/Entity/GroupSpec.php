<?php

namespace spec\App\Entity;

use App\Entity\Group;
use PhpSpec\ObjectBehavior;

class GroupSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Group::class);
    }

    public function it_has_an_id_getter()
    {
        $this->getId()->shouldBeNull();
    }

    public function it_has_a_place_setter()
    {
        $this->setPlace(10);
    }

    public function it_has_a_place()
    {
        $value = 10;
        $this->setPlace($value);
        $this->getPlace()->shouldReturn($value);
    }
    public function it_has_a_username_setter()
    {
        $this->setUsername('TwentySeal');
    }

    public function it_has_a_username()
    {
        $value = 'TwentySeal';
        $this->setUsername($value);
        $this->getUsername()->shouldReturn($value);
    }
    public function it_has_a_password_setter()
    {
        $this->setPassword('azertyuiop');
    }

    public function it_has_a_password()
    {
        $value = 'azertyuiop';
        $this->setPassword($value);
        $this->getPassword()->shouldReturn($value);
    }
    public function it_has_a_owner_setter()
    {
        $this->setOwner(new \App\Entity\User());
    }

    public function it_has_a_owner()
    {
        $value = new \App\Entity\User();
        $this->setOwner($value);
        $this->getOwner()->shouldReturn($value);
    }
    public function it_has_a_name_setter()
    {
        $this->setName('GroupYes');
    }

    public function it_has_a_name()
    {
        $value = 'GroupYes';
        $this->setName($value);
        $this->getName()->shouldReturn($value);
    }
    public function it_has_a_users_setter()
    {
        $this->addUser(new \App\Entity\User());
        $this->removeUser(new \App\Entity\User());
    }

    public function it_has_a_users()
    {
        $value = new \App\Entity\User();
        $this->addUser($value);
        $this->getUsers()->shouldBeAnInstanceOf('Doctrine\Common\Collections\ArrayCollection');
    }
}