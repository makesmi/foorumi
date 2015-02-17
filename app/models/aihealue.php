<?php

class Aihealue extends BaseModel{
    public $id, $nimi, $selitys;
    
    public function __construct($parametrit = null) {
        parent::__construct($parametrit);
    }
    
    public function ketjuja(){
        $rivit = DB::query('SELECT COUNT(*) FROM Viestiketju WHERE alue=:alueid',
                array('alueid' => $this->id));
        return $rivit[0][0];
    }
    
    public function viesteja(){
        $rivit = DB::query('SELECT COUNT(*) FROM Viesti WHERE ketju in '
                . '(SELECT id FROM Viestiketju WHERE alue=:alueid)',
                array('alueid' => $this->id));
        return $rivit[0][0];
    }
    
    public static function lisaaAlue($nimi, $selitys){
        DB::query('INSERT INTO Aihealue (nimi, selitys) VALUES (:nimi, :selitys)',
                array('nimi' => $nimi, 'selitys' => $selitys));
    }
    
    public static function haeAlueet(){
        $rivit = DB::query('SELECT * FROM Aihealue');
        $alueet = array();
        foreach($rivit as $avain => $rivi){
            $alueet[] = new Aihealue($rivi);
        }
        
        return $alueet;
    }
    
    public static function poistaAlue($id){
        DB::query('DELETE FROM Aihealue WHERE id=:id', array('id' => $id));
    }
}

