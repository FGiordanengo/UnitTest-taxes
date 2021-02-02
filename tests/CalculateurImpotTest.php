<?php

namespace App\Tests;

use App\Service\CalculateurImpot;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\TestContainer;


class CalculateurImpotTest extends TestCase
{
    private $calculateurImpot;

    public function setUp() : void
    {
        $this->calculateurImpot = new CalculateurImpot();
    }

    /**
     * @dataProvider getSampleImpot
     *
     * @return void
     */
    public function testLvl1($revenu, $nbPart, $montantImpot)
    {
        $resultat = $this->calculateurImpot->calcul($revenu, $nbPart);

        $this->assertSame($montantImpot, $resultat['montantImpot']);
    }

    /**
     * @dataProvider getSampleImpotParTranche
     *
     * @param int $revenu
     * @param int $nbPart
     * @param array $montantImpotParTranche
     *
     * @return void
     */
    public function testLvl3($revenu, $nbPart, $montantImpotParTranche)
    {
        $resultat = $this->calculateurImpot->calcul($revenu, $nbPart);

        $this->assertTrue($montantImpotParTranche, $resultat['impotParTranche']);
    }

    public function getSampleImpot()
    {
        return [
            [32000, 1, 3617],
            [55950, 3, 2833],
        ];
    }

    public function getSampleImpotParTranche()
    {
        return [
            [32000, 1, [0,1715.34,1902]],
            [55950, 3, [0,944.35]],
        ];
    }
}
