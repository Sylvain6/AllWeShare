<?php

namespace App\Util;

use PHPUnit\Framework\TestCase;

class ExchangeTestor extends TestCase
{
    protected $exchange;
    protected $user;
    protected $receiver;
    protected $product;
    protected $owner;
    protected $date_beg;
    protected $date_end;
    protected $emailSender;
    protected $DBConnection;

    /** @test */
    public function exchange_saved(){
        $this->user = new UserTest("sylvain.coutrot@hotmail.fr","sylvain","coutrot",14);
        $this->receiver = new UserTest("sylvin.coutrot@hotmail.fr","sylvin","cotrot",18);
        $this->product = new ProductTest("Fais-le-signe", $this->user);
        $this->owner = $this->product->getOwner();
        $this->date_beg = new \DateTime('2019-01-01T15:03:01.012345Z');
        $this->date_end = new \DateTime('2019-02-01T15:03:01.012345Z');
        $this->DBConnection = new DBConnectionTest();
        $this->emailSender = new EmailSenderTest();
        $this->exchange = new ExchangeTest($this->receiver, $this->product, $this->date_beg, $this->date_end, $this->emailSender, $this->DBConnection);

        $this->assertEquals(true, $this->exchange->save());
    }

    /** @test */
    public function date_false(){
        $this->user = new UserTest("sylvain.coutrot@hotmail.fr","sylvain","coutrot",14);
        $this->receiver = new UserTest("sylvin.coutrot@hotmail.fr","sylvin","cotrot",18);
        $this->product = new ProductTest("Fais-le-signe", $this->user);
        $this->owner = $this->product->getOwner();
        $this->date_beg = new \DateTime('2019-02-01T15:03:01.012345Z');
        $this->date_end = new \DateTime('2019-01-01T15:03:01.012345Z');
        $this->DBConnection = new DBConnectionTest();
        $this->emailSender = new EmailSenderTest();
        $this->exchange = new ExchangeTest($this->receiver, $this->product, $this->date_beg, $this->date_end, $this->emailSender, $this->DBConnection);

        $this->assertEquals(false, $this->exchange->save());
    }

    /** @test */
    public function user_not_valid_with_email(){
        $this->user = new UserTest("sylvain.coutrot@hotmail","sylvain","coutrot",14);
        $this->receiver = new UserTest("sylvin.coutrot@hotmail.fr","sylvin","cotrot",18);
        $this->product = new ProductTest("Fais-le-signe", $this->user);
        $this->owner = $this->product->getOwner();
        $this->date_beg = new \DateTime('2019-01-01T15:03:01.012345Z');
        $this->date_end = new \DateTime('2019-02-01T15:03:01.012345Z');
        $this->DBConnection = new DBConnectionTest();
        $this->emailSender = new EmailSenderTest();
        $this->exchange = new ExchangeTest($this->receiver, $this->product, $this->date_beg, $this->date_end, $this->emailSender, $this->DBConnection);

        $this->assertEquals(false, $this->exchange->save());
    }

    /** @test */
    public function user_not_valid_with_firstname(){
        $this->user = new UserTest("sylvain.coutrot@hotmail",6,"coutrot",14);
        $this->receiver = new UserTest("sylvin.coutrot@hotmail.fr","sylvin","cotrot",18);
        $this->product = new ProductTest("Fais-le-signe", $this->user);
        $this->owner = $this->product->getOwner();
        $this->date_beg = new \DateTime('2019-01-01T15:03:01.012345Z');
        $this->date_end = new \DateTime('2019-02-01T15:03:01.012345Z');
        $this->DBConnection = new DBConnectionTest();
        $this->emailSender = new EmailSenderTest();
        $this->exchange = new ExchangeTest($this->receiver, $this->product, $this->date_beg, $this->date_end, $this->emailSender, $this->DBConnection);

        $this->assertEquals(false, $this->exchange->save());
    }

    /** @test */
    public function user_not_valid_with_lastname(){
        $this->user = new UserTest("sylvain.coutrot@hotmail","sylvain",6,14);
        $this->receiver = new UserTest("sylvin.coutrot@hotmail.fr","sylvin","cotrot",18);
        $this->product = new ProductTest("Fais-le-signe", $this->user);
        $this->owner = $this->product->getOwner();
        $this->date_beg = new \DateTime('2019-01-01T15:03:01.012345Z');
        $this->date_end = new \DateTime('2019-02-01T15:03:01.012345Z');
        $this->DBConnection = new DBConnectionTest();
        $this->emailSender = new EmailSenderTest();
        $this->exchange = new ExchangeTest($this->receiver, $this->product, $this->date_beg, $this->date_end, $this->emailSender, $this->DBConnection);

        $this->assertEquals(false, $this->exchange->save());
    }

    /** @test */
    public function receiver_not_valid_with_email(){
        $this->user = new UserTest("sylvain.coutrot@hotmail.fr","sylvain","coutrot",14);
        $this->receiver = new UserTest("sylvin.coutrot@hotmail","sylvain","cotrot",18);
        $this->product = new ProductTest("Fais-le-signe", $this->user);
        $this->owner = $this->product->getOwner();
        $this->date_beg = new \DateTime('2019-01-01T15:03:01.012345Z');
        $this->date_end = new \DateTime('2019-02-01T15:03:01.012345Z');
        $this->DBConnection = new DBConnectionTest();
        $this->emailSender = new EmailSenderTest();
        $this->exchange = new ExchangeTest($this->receiver, $this->product, $this->date_beg, $this->date_end, $this->emailSender, $this->DBConnection);

        $this->assertEquals(false, $this->exchange->save());
    }

    /** @test */
    public function receiver_not_valid_with_firstname(){
        $this->user = new UserTest("sylvain.coutrot@hotmail.fr","sylvain","coutrot",14);
        $this->receiver = new UserTest("sylvin.coutrot@hotmail.fr",6,"cotrot",18);
        $this->product = new ProductTest("Fais-le-signe", $this->user);
        $this->owner = $this->product->getOwner();
        $this->date_beg = new \DateTime('2019-01-01T15:03:01.012345Z');
        $this->date_end = new \DateTime('2019-02-01T15:03:01.012345Z');
        $this->DBConnection = new DBConnectionTest();
        $this->emailSender = new EmailSenderTest();
        $this->exchange = new ExchangeTest($this->receiver, $this->product, $this->date_beg, $this->date_end, $this->emailSender, $this->DBConnection);

        $this->assertEquals(false, $this->exchange->save());
    }

    /** @test */
    public function receiver_not_valid_with_lastname(){
        $this->user = new UserTest("sylvain.coutrot@hotmail.fr","sylvain","coutrot",14);
        $this->receiver = new UserTest("sylvin.coutrot@hotmail.fr","sylvain",6,18);
        $this->product = new ProductTest("Fais-le-signe", $this->user);
        $this->owner = $this->product->getOwner();
        $this->date_beg = new \DateTime('2019-01-01T15:03:01.012345Z');
        $this->date_end = new \DateTime('2019-02-01T15:03:01.012345Z');
        $this->DBConnection = new DBConnectionTest();
        $this->emailSender = new EmailSenderTest();
        $this->exchange = new ExchangeTest($this->receiver, $this->product, $this->date_beg, $this->date_end, $this->emailSender, $this->DBConnection);

        $this->assertEquals(false, $this->exchange->save());
    }


    /** @test */
    public function product_not_valid_bc_user_not_valid(){
        $this->user = new UserTest("sylvain.coutrot@hotmail","sylvain","coutrot",14);
        $this->receiver = new UserTest("sylvin.coutrot@hotmail.fr","sylvin","cotrot",18);
        $this->product = new ProductTest("c le produit", $this->user);
        $this->owner = $this->product->getOwner();
        $this->date_beg = new \DateTime('2019-01-01T15:03:01.012345Z');
        $this->date_end = new \DateTime('2019-02-01T15:03:01.012345Z');
        $this->DBConnection = new DBConnectionTest();
        $this->emailSender = new EmailSenderTest();
        $this->exchange = new ExchangeTest($this->receiver, $this->product, $this->date_beg, $this->date_end, $this->emailSender, $this->DBConnection);

        $this->assertEquals(false, $this->exchange->save());
    }

    /** @test */
    public function product_not_valid_bc_name_not_valid(){
        $this->user = new UserTest("sylvain.coutrot@hotmail","sylvain","coutrot",14);
        $this->receiver = new UserTest("sylvin.coutrot@hotmail.fr","sylvin","cotrot",18);
        $this->product = new ProductTest(6, $this->user);
        $this->owner = $this->product->getOwner();
        $this->date_beg = new \DateTime('2019-01-01T15:03:01.012345Z');
        $this->date_end = new \DateTime('2019-02-01T15:03:01.012345Z');
        $this->DBConnection = new DBConnectionTest();
        $this->emailSender = new EmailSenderTest();
        $this->exchange = new ExchangeTest($this->receiver, $this->product, $this->date_beg, $this->date_end, $this->emailSender, $this->DBConnection);

        $this->assertEquals(false, $this->exchange->save());
    }

    /**
    * @test
    * @expectedException Exception
    */
    public function receiver_minor(){
            $this->user = new UserTest("sylvain.coutrot@hotmail.fr","sylvain","coutrot",14);
            $this->receiver = new UserTest("sylvin.coutrot@hotmail.fr","sylvin","cotrot",12);
            $this->product = new ProductTest("Fais-le-signe", $this->user);
            $this->owner = $this->product->getOwner();
            $this->date_beg = new \DateTime('2019-01-01T15:03:01.012345Z');
            $this->date_end = new \DateTime('2019-02-01T15:03:01.012345Z');
            $this->DBConnection = new DBConnectionTest();
            $this->emailSender = new EmailSenderTest();
            $this->exchange = new ExchangeTest($this->receiver, $this->product, $this->date_beg, $this->date_end, $this->emailSender, $this->DBConnection);
            
            $this->assertEquals(true, $this->exchange->save());
    }

}