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

    	$crawler = $client->request('GET', $router->generate('p4_billetterie_homepage'));

    	$this->assertSame(200, $client->getResponse()->getStatusCode());


    	$buttonCrawlerNode = $crawler->selectButton('Valider');

    	$form = $buttonCrawlerNode->form();
    	// Get the raw values.
		$values = $form->getPhpValues();

		$values['p4_billetteriebundle_booking']['visitors'][0]['name'] = 'Simpson';
		$values['p4_billetteriebundle_booking']['email'] = 'nam7519@gmail.com';

		$crawler = $client->request($form->getMethod(), $form->getUri(), $values,
    	$form->getPhpFiles());

		$this->assertSame(302, $client->getResponse()->getStatusCode());


		// // set some values
		// $form['name'] = 'Simpson';
		// $form['lastname'] = 'Bart';
		// $form['dateBirth'] = '21/04/1985';
		// $form['country'] = 'France';
		// $form['email'] = 'nam7519@gmail.com';
		// $form['ticket'] = false;
		// $form['bookingDate'] = '07/02/2018';
		// $form['email'] = 'nam7519@gmail.com';

    }
}