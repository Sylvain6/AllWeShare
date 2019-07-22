<?php

namespace spec\App\Entity;

use App\Entity\ProfilePicture;
use PhpSpec\ObjectBehavior;

class ProfilePictureSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ProfilePicture::class);
    }

    public function it_has_an_id_getter()
    {
        $this->getId()->shouldBeNull();
    }

}