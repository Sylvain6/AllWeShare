<?php

namespace spec\App\Entity;

use App\Entity\Comment;
use PhpSpec\ObjectBehavior;

class CommentSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Comment::class);
    }

    public function it_has_an_id_getter()
    {
        $this->getId()->shouldBeNull();
    }

    public function it_has_a_content_setter()
    {
        $this->setContent('This is the content of a comment');
    }

    public function it_has_a_content()
    {
        $value = 'This is the content of a comment';
        $this->setContent($value);
        $this->getContent()->shouldReturn($value);
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