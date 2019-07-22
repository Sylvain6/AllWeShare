<?php

namespace spec\App\Entity;

use App\Entity\Notifications;
use PhpSpec\ObjectBehavior;

class NotificationsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Notifications::class);
    }

    public function it_has_an_id_getter()
    {
        $this->getId()->shouldBeNull();
    }

    public function it_has_a_id_sender_setter()
    {
        $this->setIdSender(10);
    }

    public function it_has_a_id_sender()
    {
        $value = 10;
        $this->setIdSender($value);
        $this->getIdSender()->shouldReturn($value);
    }
    public function it_has_a_id_receiver_setter()
    {
        $this->setIdReceiver(10);
    }

    public function it_has_a_id_receiver()
    {
        $value = 10;
        $this->setIdReceiver($value);
        $this->getIdReceiver()->shouldReturn($value);
    }
    public function it_has_a_content_setter()
    {
        $this->setContent('You received a notification');
    }

    public function it_has_a_content()
    {
        $value = 'You received a notification';
        $this->setContent($value);
        $this->getContent()->shouldReturn($value);
    }
    public function it_has_a_is_seen_setter()
    {
        $this->setIsSeen(false);
    }

    public function it_has_a_is_seen()
    {
        $value = false;
        $this->setIsSeen($value);
        $this->getIsSeen()->shouldReturn($value);
    }
    public function it_has_a_id_post_setter()
    {
        $this->setIdPost(10);
    }

    public function it_has_a_id_post()
    {
        $value = 10;
        $this->setIdPost($value);
        $this->getIdPost()->shouldReturn($value);
    }
}