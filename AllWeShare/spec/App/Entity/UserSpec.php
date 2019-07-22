<?php

namespace spec\App\Entity;

use App\Entity\User;
use PhpSpec\ObjectBehavior;

class UserSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(User::class);
    }

    public function it_has_an_id_getter()
    {
        $this->getId()->shouldBeNull();
    }

    public function it_has_a_id_setter()
    {
        $this->setId(10);
    }

    public function it_has_a_id()
    {
        $value = 10;
        $this->setId($value);
        $this->getId()->shouldReturn($value);
    }
    public function it_has_a_firstname_setter()
    {
        $this->setFirstname('Sylvain');
    }

    public function it_has_a_firstname()
    {
        $value = 'Sylvain';
        $this->setFirstname($value);
        $this->getFirstname()->shouldReturn($value);
    }
    public function it_has_a_lastname_setter()
    {
        $this->setLastname('Coutrot');
    }

    public function it_has_a_lastname()
    {
        $value = 'Coutrot';
        $this->setLastname($value);
        $this->getLastname()->shouldReturn($value);
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
    public function it_has_a_address_setter()
    {
        $this->setAddress('12 rue dinde');
    }

    public function it_has_a_address()
    {
        $value = '12 rue dinde';
        $this->setAddress($value);
        $this->getAddress()->shouldReturn($value);
    }
    public function it_has_a_city_setter()
    {
        $this->setCity('Paname');
    }

    public function it_has_a_city()
    {
        $value = 'Paname';
        $this->setCity($value);
        $this->getCity()->shouldReturn($value);
    }
    public function it_has_a_posts_setter()
    {
        $this->addPost(new \App\Entity\Post());
        $this->removePost(new \App\Entity\Post());
    }

    public function it_has_a_posts()
    {
        $value = new \App\Entity\Post();
        $this->addPost($value);
        $this->getPosts()->shouldBeAnInstanceOf('Doctrine\Common\Collections\ArrayCollection');
    }
    public function it_has_a_tochangepassword_setter()
    {
        $this->setTochangepassword('azertyuioqsfgdhtgfd');
    }

    public function it_has_a_tochangepassword()
    {
        $value = 'azertyuioqsfgdhtgfd';
        $this->setTochangepassword($value);
        $this->getTochangepassword()->shouldReturn($value);
    }
    public function it_has_a_comments_setter()
    {
        $comment = new \App\Entity\Comment();
        $this->addComment($comment);
    }

    public function it_has_a_comments()
    {
        $value = new \App\Entity\Comment();
        $this->addComment($value);
        $this->getComments()->shouldBeAnInstanceOf('Doctrine\Common\Collections\ArrayCollection');
    }
    public function it_has_a_is_active_setter()
    {
        $this->setIsActive(false);
    }

    public function it_has_a_is_active()
    {
        $value = false;
        $this->setIsActive($value);
        $this->getIsActive()->shouldReturn($value);
    }
    public function it_has_a_token_setter()
    {
        $this->setToken('POIUYH13JK2OIU34YRHU8IJE9IU8ZHUFGD');
    }

    public function it_has_a_token()
    {
        $value = 'POIUYH13JK2OIU34YRHU8IJE9IU8ZHUFGD';
        $this->setToken($value);
        $this->getToken()->shouldReturn($value);
    }
    public function it_has_a_groups_setter()
    {
        $this->addGroup(new \App\Entity\Group());
        $this->removeGroup(new \App\Entity\Group());
    }

    public function it_has_a_groups()
    {
        $value = new \App\Entity\Group();
        $this->addGroup($value);
        $this->getGroups()->shouldBeAnInstanceOf('Doctrine\Common\Collections\ArrayCollection');
    }
}