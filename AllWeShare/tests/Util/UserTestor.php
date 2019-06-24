<?php

namespace App\Util;

use PHPUnit\Framework\TestCase;

class UserTestor extends TestCase
{
    protected $user;

    /** @test */
    public function is_valid()
    {
        $this->user = new UserTest("sylvain.coutrot@hotmail.fr","sylvain","coutrot",14);
        $this->assertEquals(true, $this->user->isValid());
    }

    /** @test */
    public function email_is_not_valid()
    {
        $this->user = new UserTest("sylvain.coutrot@hotmail","sylvain","coutrot",14);
        $this->assertEquals(false, $this->user->isValid());
    }

    /** @test */
    public function age_less_than_thirteen()
    {
        $this->user = new UserTest("sylvain.coutrot@hotmail.fr","sylvain","coutrot",11);
        $this->assertEquals(false, $this->user->isValid());
    }

    /** @test */
    public function firstname_blank()
    {
        $this->user = new UserTest("sylvain.coutrot@hotmail.fr","","coutrot",14);
        $this->assertEquals(false, $this->user->isValid());
    }

    /** @test */
    public function lastname_blank()
    {
        $this->user = new UserTest("sylvain.coutrot@hotmail.fr","sylvain","",14);
        $this->assertEquals(false, $this->user->isValid());
    }

    /** @test */
    public function email_blank()
    {
        $this->user = new UserTest("","sylvain","coutrot",14);
        $this->assertEquals(false, $this->user->isValid());
    }

}