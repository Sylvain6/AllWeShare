<?php

namespace spec\App\Entity;

use App\Entity\Post;
use PhpSpec\ObjectBehavior;

class PostSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Post::class);
    }

    public function it_has_an_id_getter()
    {
        $this->getId()->shouldBeNull();
    }

    public function it_has_a_title_setter()
    {
        $this->setTitle('This is a title');
    }

    public function it_has_a_title()
    {
        $value = 'This is a title';
        $this->setTitle($value);
        $this->getTitle()->shouldReturn($value);
    }
    public function it_has_a_description_setter()
    {
        $this->setDescription('This is a description');
    }

    public function it_has_a_description()
    {
        $value = 'This is a description';
        $this->setDescription($value);
        $this->getDescription()->shouldReturn($value);
    }
    public function it_has_a_nb_like_setter()
    {
        $this->setNbLike(10);
    }

    public function it_has_a_nb_like()
    {
        $value = 10;
        $this->setNbLike($value);
        $this->getNbLike()->shouldReturn($value);
    }
    public function it_has_a_comments_setter()
    {
        $this->addComment(new \App\Entity\Comment());
        $this->removeComment(new \App\Entity\Comment());
    }

    public function it_has_a_comments()
    {
        $value = new \App\Entity\Comment();
        $this->addComment($value);
        $this->getComments()->shouldBeAnInstanceOf('Doctrine\Common\Collections\ArrayCollection');
    }
    public function it_has_a_author_setter()
    {
        $this->setAuthor(new \App\Entity\User());
    }

    public function it_has_a_author()
    {
        $value = new \App\Entity\User();
        $this->setAuthor($value);
        $this->getAuthor()->shouldReturn($value);
    }
    public function it_has_a_organization_setter()
    {
        $this->setOrganization(new \App\Entity\Group());
    }

    public function it_has_a_organization()
    {
        $value = new \App\Entity\Group();
        $this->setOrganization($value);
        $this->getOrganization()->shouldReturn($value);
    }
    public function it_has_a_requests_setter()
    {
        $this->addRequest(new \App\Entity\Request());
        $this->removeRequest(new \App\Entity\Request());
    }

    public function it_has_a_requests()
    {
        $value = new \App\Entity\Request();
        $this->addRequest($value);
        $this->getRequests()->shouldBeAnInstanceOf('Doctrine\Common\Collections\ArrayCollection');
    }
    public function it_has_a_created_at_setter()
    {
        $this->setCreatedAt(new \DateTime());
    }

    public function it_has_a_created_at()
    {
        $value = new \DateTime();
        $this->setCreatedAt($value);
        $this->getCreatedAt()->shouldReturn($value);
    }
    public function it_has_a_updated_at_setter()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    public function it_has_a_updated_at()
    {
        $value = new \DateTime();
        $this->setUpdatedAt($value);
        $this->getUpdatedAt()->shouldReturn($value);
    }
}