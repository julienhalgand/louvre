<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Bill;


class ValidationController extends Controller
{
    public function validateStep1Action(Bill $bill)
    {
        $dateNow = new \DateTime();
        $hourNow = $dateNow->format('d');
        $dateNow->setTime(0,0,0);
        //Si dateofbooking est supérieur à la date du jour et ne dépasse pas un an après la date du jour
        //die(dump($dateNow,$bill->getDateOfBooking()));
        if ($dateNow <= $bill->getDateOfBooking()){
            //Test si avant 14h
            if($hourNow > 14){
                //Test si pas demi-journée
                if($bill->getTicketType() == "halfJourney"){
                    $this->context->buildViolation($constraint->message)
                    ->setParameter('{{string}}', $value)
                    ->addViolation();
                }
            }
        }
    }

    public function validateStep2Action()
    {

    }

    public function validateStep3Action()
    {

    }

    public function getHolidaysHolidaysUnixTimestamp()
    {
        $year = intval(strftime('%Y'));
        $easterDate = easter_date($year);
        $easterDay = date('j', $easterDate);
        $easterMonth = date('n', $easterDate);
        $easterYear = date('Y', $easterDate);

        $holidaysUnixTimestamp = array(
                // Jours feries fixes
                mktime(0, 0, 0, 1, 1, $year),// 1er janvier
                mktime(0, 0, 0, 5, 1, $year),// Fete du travail
                mktime(0, 0, 0, 5, 8, $year),// Victoire des allies
                mktime(0, 0, 0, 7, 14, $year),// Fete nationale
                mktime(0, 0, 0, 8, 15, $year),// Assomption
                mktime(0, 0, 0, 11, 1, $year),// Toussaint
                mktime(0, 0, 0, 11, 11, $year),// Armistice
                mktime(0, 0, 0, 12, 25, $year),// Noel

                // Jour feries qui dependent de paques
                mktime(0, 0, 0, $easterMonth, $easterDay + 1, $easterYear),// Lundi de paques
                mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear),// Ascension
                mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear), // Pentecote
        );
        sort($holidaysUnixTimestamp);
        return $holidaysUnixTimestamp;
    }
    public function getHolidaysString()
    {
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
    private static function paques($Jourj=0, $annee=NULL)
    {
        $annee=($annee==NULL) ? date("Y") : $annee;

        $G = $annee%19;
        $C = floor($annee/100);
        $C_4 = floor($C/4);
        $E = floor((8*$C + 13)/25);
        $H = (19*$G + $C - $C_4 - $E + 15)%30;

        if($H==29)
        {
            $H=28;
        }
        elseif($H==28 && $G>10)
        {
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