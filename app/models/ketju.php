<?php

class Viestiketju extends BaseModel{
    public $id, $otsikko, $alue;
    
    
    public function __construct($parametrit = null) {
        parent::__construct($parametrit);
    }
    
    public static function lisaaKetju($aihealue, $otsikko){
        $rivit = DB::query('INSERT INTO Viestiketju () values (:alue, :otsikko) RETURNING id',
                array('alue' => $aihealue, 'otsikko' => $otsikko));
        
        return $rivit[0][0];
    }
    
    public function haeKetjut($aihealue){
        $rivit = DB::query('SELECT * FROM Viestiketju WHERE alue = :alue',
                array('alue' => $aihealue->id));
        $ketjut = array();
        foreach($rivit as $avain => $rivi){
            $ketjut[] = new Viestiketju($rivi);
        }
        
        return $ketjut;
    }

}
