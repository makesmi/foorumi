<?php

class Viestiketju extends BaseModel{
    public $id, $otsikko, $alue;
    
    public function __construct($parametrit = null) {
        parent::__construct($parametrit);
    }
    
    
    /* palautaa luodun ketjun id:n */
    public static function lisaaKetju($aihealueid, $otsikko){
        $rivit = DB::query('INSERT INTO Viestiketju () values (:alue, :otsikko) RETURNING id',
                array('alue' => $aihealueid, 'otsikko' => $otsikko));
        
        return new $rivit[0][0];
    }
    
    public static function haeKetjut($aihealue){
        $rivit = DB::query('SELECT * FROM Viestiketju WHERE alue = :alue',
                array('alue' => $aihealue->id));
        $ketjut = array();
        foreach($rivit as $avain => $rivi){
            $ketjut[] = new Viestiketju($rivi);
        }
        
        return $ketjut;
    }
    
    public static function haeTunnuksella($id){
        $rivit = DB::query('SELECT * FROM Viestiketju WHERE id=:ketjuid',
                array('ketjuid' => $id));
        if(isset($rivit[0])){
            return new Viestiketju($rivit[0]);
        }else{
            return null;
        }
    }
    
    public function viesteja(){
        $rivit = DB::query('SELECT COUNT(*) FROM Viesti WHERE ketju=:ketjuid',
                array('ketjuid' => $this->id));
        return $rivit[0][0];
    }
    
    public function aloittajanTunnus(){
        $rivit = DB::query('SELECT kirjoittaja FROM Viesti WHERE ketju=:ketjuid '
                . 'ORDER BY id LIMIT 1',
                array('ketjuid' => $this->id));
        
        return $rivit[0][0];
    }

}
