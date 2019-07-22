<?php

namespace spec\App\Entity;

use App\Entity\Request;
use PhpSpec\ObjectBehavior;

class RequestSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Request::class);
    }

    public function it_has_an_id_getter()
    {
        $this->getId()->shouldBeNull();
    }

    public function it_has_a_status_setter()
    {
        $this->setStatus('init');
    }

    public function it_has_a_status()
    {
        $value = 'init';
        $this->setStatus($value);
        $this->getStatus()->shouldReturn($value);
    }
    public function it_has_a_applicant_setter()
    {
        $this->setApplicant(new \App\Entity\User());
    }

    public function it_has_a_applicant()
    {
        $value = new \App\Entity\User();
        $this->setApplicant($value);
        $this->getApplicant()->shouldReturn($value);
    }
    public function it_has_a_post_setter()
    {
        $this->setPost(new \App\Entity\Post());
    }

    public function it_has_a_post()
    {
        $value = new \App\Entity\Post();
        $this->setPost($value);
        $this->getPost()->shouldReturn($value);
    }
}