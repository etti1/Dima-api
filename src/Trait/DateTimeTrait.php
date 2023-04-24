<?php

namespace App\Trait;

use Doctrine\ORM\Mapping as ORM;

trait DateTimeTrait
{
    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private \DateTime $dateTime;

    public function __construct()
    {
        $this->dateTime = new \DateTime('now');
    }

    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

}