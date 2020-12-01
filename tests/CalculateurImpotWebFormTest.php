<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CalculateurImpotWebFormTest extends WebTestCase
{

    /**
     * @dataProvider getData
     *
     * @return void
     */
    public function testSomething($revenu, $nbPart, $impot)
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('form[save]')->form();
        $form['form[revenu]'] = $revenu;
        $form['form[nbPart]'] = $nbPart;

        $crawler = $client->submit($form);
//        $montant = (int) $crawler->filter('#montantImpot')->text();

        $this->assertSame($impot, (int) $crawler->filter('#montantImpot')->text());
    }

    public function getData()
    {
        return [
            [32000,1,3617]
        ];
    }
}
