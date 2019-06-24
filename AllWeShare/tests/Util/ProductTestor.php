<?php

namespace App\Util;

use PHPUnit\Framework\TestCase;

class ProductTestor extends TestCase
{
    protected $product;
    protected $user;

    /** @test */
    public function is_valid()
    {
        $this->user = new UserTest("sylvain.coutrot@hotmail.fr","sylvain","coutrot",14);
        $this->product = new ProductTest("Fais-le-signe", $this->user);
        $this->assertEquals(true, $this->product->isValid());
    }

    /** @test */
    public function user_is_valid()
    {
        $this->user = new UserTest("sylvain.coutrot@hotmail.fr","sylvain","coutrot",11);
        $this->product = new ProductTest("Fais-le-signe", $this->user);
        $this->assertEquals(false, $this->product->isValid());
    }

    /** @test */
    public function name_blank()
    {
        $this->user = new UserTest("sylvain.coutrot@hotmail.fr","sylvain","coutrot",14);
        $this->product = new ProductTest("", $this->user);
        $this->assertEquals(false, $this->product->isValid());
    }

}