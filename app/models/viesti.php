<?php

class Viesti extends BaseModel{
    public $id, $ketju, $kirjoittaja, $sisältö, $aika, $muokkausaika;
    
    public function __construct($parametrit = null) {
        parent::__construct($parametrit);
    }
    
    /* hakee halutun viestiketjun viestit kirjoittamisjärjestyksessä */
    public static function haeViestit($ketjuid){
        
    }
    
    /* parametreiksi tulee ketjun id ja kirjoittajan tunnus */
    /* palauttaa luodun viestin id:n */
    public static function lisaaViesti($ketjuid, $kirjoittaja, $sisalto){
        $rivit = DB::query('INSERT INTO Viesti (ketju, kirjoittaja, sisalto, aika) VALUES '
                . '(:ketju, :kirjoittaja, :sisalto, :aika) RETURNING id',
                array('ketju' => $ketjuid, 'kirjoittaja' => $kirjoittaja,
                    'sisalto' => $sisalto, 'aika' => self::haeNykyHetki()));
        
        return $rivit[0];
    }
}
