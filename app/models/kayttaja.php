<?php

class Kayttaja extends BaseModel{

    public $tunnus, $salasana, $bannattu, $yllapitaja, $rekist_aika;
    
    public function __construct($attributes = null) {
        parent::__construct($attributes);
    }
    
    public static function haeKaikki(){
        foreach(DB::query('SELECT * FROM Kayttaja') as $rivi){
            $kayttajat[] = new Kayttaja($rivi);
        }
        
        return $kayttajat;
    }
    
    public static function haeTunnuksella($tunnus){
        return new Kayttaja(DB::query(
                'SELECT * FROM Kayttaja WHERE tunnus = :ktun LIMIT 1'
                , array('ktun' => $tunnus)));
    }
}

