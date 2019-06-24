<?php

namespace App\Util;

class ExchangeTest
{
    private $receiver;

    private $product;

    private $date_beg;

    private $date_end;

    private $emailSender;

    private $DBConnection;

    public function __construct(UserTest $receiver, ProductTest $product, \DateTime $date_beg, \DateTime $date_end, $emailSender, $DBConnection)
    {
        $this->receiver = $receiver;
        $this->product = $product;
        $this->date_beg = $date_beg;
        $this->date_end = $date_end;
        $this->emailSender = $emailSender;
        $this->DBConnection = $DBConnection;
    }

    public function save() {
        if($this->receiver->getAge() < 18){
            return $this->emailSender->sendEmail($this->receiver, 'bonjour');
        }
        return $this->receiver->isValid()
            && $this->product->getOwner()->isValid()
            && $this->date_beg < $this->date_end
            && $this->emailSender instanceof EmailSenderTest
            && $this->DBConnection instanceof DBConnectionTest;
    }
}