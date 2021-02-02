<?php

namespace App\Service;

class CalculateurImpot
{
    private $bareme = [
        ['seuil' => 10064, 'taux' => 0],
        ['seuil' => 25659, 'taux' => 11],
        ['seuil' => 73369, 'taux' => 30],
        ['seuil' => 157806, 'taux' => 41],
        ['seuil' => 10000000, 'taux' => 45],
    ];

    /**
     * Undocumented function.
     *
     * @param int $revenu
     * @param int $nbPart
     *
     * @return array ['montantImpot' => int, 'impotParTranche' => []]
     */
    public function calcul($revenu, $nbPart): array
    {
        //step 1
        $montant = $revenu / $nbPart;

        //step 2
        //algo bareme
        //montant  - tranche-seuil
        $resultat = ['montantImpot' => 0, 'impotParTranche' => []];
        $seuil = 0;
        $i = 0;
        //     3er 73369   <= 32000 $i = 3
        while ($seuil <= $montant) {
            //73369
            $seuil = $this->bareme[$i]['seuil'];
            //30
            $taux = $this->bareme[$i]['taux'];
            //première tranche
            if (0 === $i) {
                $reslutCalcul = $seuil * $taux;
                $resultat['montantImpot'] += $reslutCalcul;
                $resultat['impotParTranche'][] = $reslutCalcul;
            // array_push($resultat['impotParTranche'], $reslutCalcul);
            }
            // elseif ($montant < $seuil) {
            //     $resultat +=  (($montant - $this->bareme[$i - 1]['seuil']) * $taux) / 100;
            // }
            else {
                $montantCalcul = ($montant < $seuil) ? $montant : $seuil;
                $reslutCalcul = (($montantCalcul - $this->bareme[$i - 1]['seuil'] - 1) * $taux) / 100;
                $resultat['montantImpot'] += $reslutCalcul;
                $resultat['impotParTranche'][] = $reslutCalcul;
            }

            ++$i;
        }

        //step 3
        $resultat['montantImpot'] = (int) floor($resultat['montantImpot'] * $nbPart);

        return $resultat;
    }
}
