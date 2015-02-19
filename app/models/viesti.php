<?php

class Viesti extends BaseModel{
    public $id, $ketju, $kirjoittaja, $sisalto, $aika, $muokkausaika;
    
    public function __construct($parametrit = null) {
        parent::__construct($parametrit);
    }
    
    /* hakee halutun viestiketjun viestit kirjoittamisjärjestyksessä */
    public static function haeViestit($ketjuid){
        $rivit = DB::query('SELECT * FROM Viesti WHERE ketju=:ketjuid ORDER BY id', 
                array('ketjuid' => $ketjuid));
        
        $viestit = array();
        
        foreach($rivit as $avain => $rivi){
            $viestit[] = new Viesti($rivi);
        }
        
        return $viestit;
    }
    
    public function muutaSisaltoa($uusiSisalto){
        $this->sisalto = $uusiSisalto;
        DB::query('UPDATE Viesti SET sisalto=:sisalto, muokkausaika=:aika WHERE id=:viestiid',
                array('sisalto' => $uusiSisalto, 'aika' => self::haeNykyHetki(), 
                    'viestiid' => $this->id));
    }
    
    public function poista(){
        DB::query('DELETE FROM Viesti WHERE id=:viestiid', 
                array('viestiid' => $this->id));
    }
    
    public static function haeTunnuksella($viestiid){
        $rivit = DB::query('SELECT * FROM Viesti WHERE id=:id',
                array('id' => $viestiid));
        if(isset($rivit[0])){
            return new Viesti($rivit[0]);
        }else{
            return null;
        }
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
