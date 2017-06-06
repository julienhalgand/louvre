<?php
/**
 * Created by PhpStorm.
 * User: JulienHalgand
 * Date: 05/06/2017
 * Time: 20:58
 */

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BillServiceTest extends WebTestCase
{
    private $step1HydratorArray;

    function __construct()
    {
        parent::__construct();
        $this->step1HydratorArray = array(
            'bill_step1[email]' => 'test@gmail.com',
            'bill_step1[ticket_type]' => 'allJourney',
            'bill_step1[number_of_tickets]' => '1',
            'bill_step1[date_of_booking]' => '06/06/2017'
        );
    }

    private function step1Hydrator($form){
        foreach ($this->step1HydratorArray as $key => $value){
            $form[$key] = $value;
        }
    }

    /**
     * Step1 tests
     */
    //Good form just change date before testing
    public function testStep1FrTrue(){
        $client = static::createClient();

        $crawler = $client->request('GET', '/fr/step1');
        //dump($client->getResponse()->getContent());
        $form = $crawler->selectButton('Passer à l\'étape suivante')->form();
        //dump($form);
        $this->step1Hydrator($form);
        $crawler = $client->submit($form);
       dump($crawler);
        $this->assertTrue(
          $client->getResponse()->isRedirect('/fr/step2')
        );
    }
    //Wrong email domain
    public function testStep1FrFalseEmailDomain(){
        $client = static::createClient();

        $crawler = $client->request('GET', '/fr/step1');
        //dump($client->getResponse()->getContent());
        $form = $crawler->selectButton('Passer à l\'étape suivante')->form();
        //dump($form);
        $form['bill_step1[email]'] = 'test@a.com';
        $form['bill_step1[ticket_type]'] = 'allJourney';
        $form['bill_step1[number_of_tickets]'] = '1';
        $form['bill_step1[date_of_booking]'] = '09/07/2017';
        $crawler = $client->submit($form);
        //dump($crawler);
        $this->assertFalse(
            $client->getResponse()->isRedirect('/fr/step2')
        );
    }
    //Wrong ticket_type
    /*public function testStep1FrFalseTicketType(){
        $client = static::createClient();

        $crawler = $client->request('GET', '/fr/step1');
        //dump($client->getResponse()->getContent());
        $form = $crawler->selectButton('Passer à l\'étape suivante')->form();
        //dump($form);
        $form['bill_step1[email]'] = 'test@a.com';
        $form['bill_step1[ticket_type]'] = 'wrongTicketType';
        $form['bill_step1[number_of_tickets]'] = '1';
        $form['bill_step1[date_of_booking]'] = '09/07/2017';
        $crawler = $client->submit($form);
        //dump($crawler);
        $this->assertFalse(
            $client->getResponse()->isRedirect('/fr/step2')
        );
    }*/
    //Wrong number of tickets
    /*public function testStep1FrNegativeNumberOfTickets(){
        $client = static::createClient();

        $crawler = $client->request('GET', '/fr/step1');
        //dump($client->getResponse()->getContent());
        $form = $crawler->selectButton('Passer à l\'étape suivante')->form();
        //dump($form);
        $form['bill_step1[email]'] = 'test@a.com';
        $form['bill_step1[ticket_type]'] = 'allJourney';
        $form['bill_step1[number_of_tickets]'] = '-1';
        $form['bill_step1[date_of_booking]'] = '09/07/2017';
        $crawler = $client->submit($form);
        //dump($crawler);
        $this->assertFalse(
            $client->getResponse()->isRedirect('/fr/step2')
        );
    }
    //Wrong number of tickets
    public function testStep1FrToMuchNumberOfTickets(){
        $client = static::createClient();

        $crawler = $client->request('GET', '/fr/step1');
        //dump($client->getResponse()->getContent());
        $form = $crawler->selectButton('Passer à l\'étape suivante')->form();
        //dump($form);
        $form['bill_step1[email]'] = 'test@a.com';
        $form['bill_step1[ticket_type]'] = 'allJourney';
        $form['bill_step1[number_of_tickets]'] = '1001';
        $form['bill_step1[date_of_booking]'] = '09/07/2017';
        $crawler = $client->submit($form);
        //dump($crawler);
        $this->assertFalse(
            $client->getResponse()->isRedirect('/fr/step2')
        );
    }
    //Wrong date of booking
    public function testStep1FrPastDay(){
        $client = static::createClient();

        $crawler = $client->request('GET', '/fr/step1');
        //dump($client->getResponse()->getContent());
        $form = $crawler->selectButton('Passer à l\'étape suivante')->form();
        //dump($form);
        $form['bill_step1[email]'] = 'test@a.com';
        $form['bill_step1[ticket_type]'] = 'allJourney';
        $form['bill_step1[number_of_tickets]'] = '1';
        $form['bill_step1[date_of_booking]'] = '09/05/2017';
        $crawler = $client->submit($form);
        //dump($crawler);
        $this->assertFalse(
            $client->getResponse()->isRedirect('/fr/step2')
        );
    }
    //Wrong date of booking
    public function testStep1FrToFarDateOfBooking(){
        $client = static::createClient();

        $crawler = $client->request('GET', '/fr/step1');
        //dump($client->getResponse()->getContent());
        $form = $crawler->selectButton('Passer à l\'étape suivante')->form();
        //dump($form);
        $form['bill_step1[email]'] = 'test@a.com';
        $form['bill_step1[ticket_type]'] = 'allJourney';
        $form['bill_step1[number_of_tickets]'] = '1';
        $form['bill_step1[date_of_booking]'] = '09/07/2057';
        $crawler = $client->submit($form);
        //dump($crawler);
        $this->assertFalse(
            $client->getResponse()->isRedirect('/fr/step2')
        );
    }*/
}