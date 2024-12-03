<?php

namespace App\Helpers;


class SuraClassifier
{

    private $earlyMecca = [
        93, 94, 95, 97, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 111, 81, 82, 84, 85, 86, 87, 88,
        89, 90, 91, 92, 96, 53, 74, 75, 77, 78, 79, 80, 51, 52, 55, 56, 68, 69, 70, 73, 83,
    ];

    private $earlyMiddleMecca = [1, 54, 37, 15, 50, 20, 26, 71, 44, 76, 38, 19];

    private $lateMiddleMecca = [17, 43, 36, 25, 23, 114, 27, 72, 67, 21, 18];
    private $middleMecca = [
    ];

    private $lateMecca = [
        32, 41, 45, 16, 30, 11, 14, 12, 40, 28, 39, 29, 31, 42, 10, 34, 35, 7, 46, 6, 13, 112, 113,
    ];

    private $medina = [
        2, 98, 64, 62, 8, 47, 3, 61, 57, 4, 65, 59, 33, 63, 24, 58, 22, 48, 66, 60, 110, 49, 9, 5,
    ];

    public function classifySura($sura)
    {
        if (in_array($sura, $this->earlyMecca)) {
            return 'early-mecca';
        }
        if (in_array($sura, $this->earlyMiddleMecca)) {
            return 'early-middle-mecca';
        }
        if (in_array($sura, $this->lateMiddleMecca)) {
            return 'late-middle-mecca';
        }
        if (in_array($sura, $this->lateMecca)) {
            return 'late-mecca';
        }
        if (in_array($sura, $this->medina)) {
            return 'medina';
        }
        throw new \Exception("Sura not recognized.");
    }

    public function commentaryCitationKey($period)
    {
        switch ($period) {
            case ('early-mecca'):
                return 'citation_kommentar_fruehmekkanisch';
            case ('early-middle-mecca'):
                return 'citation_kommentar_fruehmittelmekkanisch';
            case ('late-middle-mecca'):
                return 'citation_kommentar_spaetmittelmekkanisch';
            case ('late-mecca'):
                return 'citation_kommentar_spaetmekkanisch';
            default:
                return 'citation_kommentar_allgemein';
        }
    }
}
