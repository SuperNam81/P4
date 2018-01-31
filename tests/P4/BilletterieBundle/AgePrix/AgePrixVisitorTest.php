<?php

// tests/P4/BilletterieBundle/AgePrix/AgePrixVisitorTest.php
namespace Tests\P4\BilletterieBundle\AgePrix;

use PHPUnit\Framework\TestCase;
use P4\BilletterieBundle\AgePrix\AgePrixVisitor;

class AgePrixVisitorTest extends TestCase
{
	/**
     * @dataProvider agesForAgeCalcul
     */
    public function testAgeCalcul($dateBirth, $expectedAge)
    {
    	$age = new AgePrixVisitor(0, 8, 16, 12, 10);
    	$this->assertSame($expectedAge, $age->ageCalcul($dateBirth));
    }

    public function agesForAgeCalcul()
    {
        return [
            [new \DateTime('2008/01/28'), 10],
            [new \DateTime('2003/01/28'), 15],
            [new \DateTime('1998/01/28'), 20]
        ];
    }

    public function testPrixCalcul()
    {
    	$prix = new AgePrixVisitor(0, 8, 16, 12, 10);
    	$age = 65;
    	$discount = 0;
    	$bookingDate = '07/02/2018';
    	$ticket = 1;
    	$result = $prix->prixCalcul($age, $discount, $bookingDate, $ticket);
    	$this->assertSame(12, $result);
    }    
}