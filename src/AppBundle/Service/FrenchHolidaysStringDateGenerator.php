<?php

namespace AppBundle\Service;

class FrenchHolidaysStringDateGenerator{

    public function getHolidaysArrayString(){
        return "['".implode("', '",self::getHolidaysString())."']";
    }
    public function getHolidaysString(){
        $year = intval(strftime('%Y'));

        $holidaysString = array(
                // Jours feries fixes
                $year."-01-01",// 1er janvier
                $year."-05-01",// Fete du travail
                $year."-05-08",// Fete nationale
                $year."-07-14",// Victoire des allies
                $year."-08-15",// Assomption
                $year."-11-01",// Toussaint
                $year."-11-11",// Armistice
                $year."-12-25",// Noel

                // Jour feries qui dependent de paques
                date('Y-m-d',self::paques(1)),// Lundi de paques
                date('Y-m-d',self::paques(39)),// Ascension
                date('Y-m-d',self::paques(50)), // Pentecote
        );
        sort($holidaysString);
        return $holidaysString;
    }

    private static function paques($Jourj=0, $annee=NULL){
        $annee=($annee==NULL) ? date("Y") : $annee;

        $G = $annee%19;
        $C = floor($annee/100);
        $C_4 = floor($C/4);
        $E = floor((8*$C + 13)/25);
        $H = (19*$G + $C - $C_4 - $E + 15)%30;

        if($H==29){
            $H=28;
        }
        elseif($H==28 && $G>10){
            $H=27;
        }
        $K = floor($H/28);
        $P = floor(29/($H+1));
        $Q = floor((21-$G)/11);
        $I = ($K*$P*$Q - 1)*$K + $H;
        $B = floor($annee/4) + $annee;
        $J1 = $B + $I + 2 + $C_4 - $C;
        $J2 = $J1%7; //jour de pâques (0=dimanche, 1=lundi....)
        $R = 28 + $I - $J2; // résultat final :)
        $mois = $R>30 ? 4 : 3; // mois (1 = janvier, ... 3 = mars...)
        $Jour = $mois==3 ? $R : $R-31;

        return mktime(0,0,0,$mois,$Jour+$Jourj,$annee);
    }
}