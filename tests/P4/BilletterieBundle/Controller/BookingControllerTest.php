<?php

// tests/P4/BilletterieBundle/Controller/BookingControllerTest.php
namespace Tests\P4\BilletterieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookingControllerTest extends WebTestCase
{
	protected $router;

    public function testFormPost()
    {
    	$client = static::createClient();

    	$router = $client->getContainer()->get('router');

    	$crawler = $client->request('GET', $router->generate('p4_billetterie_homepage', array('_locale' => 'fr')));

    	$this->assertSame(200, $client->getResponse()->getStatusCode());

    	$boutonFormValider = $crawler->selectButton('Valider');

    	$form = $boutonFormValider->form();
    	// Get the raw values.
		$values = $form->getPhpValues();

		$values['p4_billetteriebundle_booking']['visitors'][0]['lastname'] = 'aa';
		$values['p4_billetteriebundle_booking']['visitors'][0]['firstname'] = 'aa';
		$values['p4_billetteriebundle_booking']['visitors'][0]['dateBirth'] = '1981/03/21';
		$values['p4_billetteriebundle_booking']['visitors'][0]['country'] = 'France';		
		$values['p4_billetteriebundle_booking']['visitors'][0]['discount'] = '0';
		$values['p4_billetteriebundle_booking']['email'] = 'nam7519@gmail.com';
		$values['p4_billetteriebundle_booking']['ticket'] = '1';
		$values['p4_billetteriebundle_booking']['bookingDate'] = '2018/02/28';		

		$crawler = $client->request($form->getMethod(), $form->getUri(), $values, $form->getPhpFiles());

		$this->assertSame(302, $client->getResponse()->getStatusCode());
    }
}