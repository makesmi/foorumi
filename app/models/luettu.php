<?php


class ViimeinenLuettu extends BaseModel{
    
    /**
     * asettaa ketjun viimeisen viestin luetuksi käyttäjälle
     */
    public static function asetaLuetuksi($kayttajatunnus, $ketjuid){
        DB::query('DELETE * FROM Luettu WHERE kayttaja=:kayttaja AND '
                . 'viesti in (SELECT id FROM Viesti WHERE ketju=:ketju)',
                array('kayttaja' => $kayttajatunnus, 'ketju' => $ketjuid));
        
        $rivit = DB::query('SELECT id FROM Viesti WHERE ketju=:ketju ORDER BY id DESC LIMIT 1',
                array('ketju' => $ketjuid));
        if(isset($rivit[0])){
            $viimeinenViesti = $rivit[0][0];
        }
        
        DB::query('INSERT INTO Luettu (kayttaja, viesti) VALUES (:kayttaja, :viesti)',
                array('kayttaja' => $kayttajatunnus, 'viesti' => $viimeinenViesti));
    }
    
    public static function lukemattomiaKetjussa($kayttajatunnus, $ketjuid){
        $rivit = DB::query('SELECT COUNT(*) FROM Viesti WHERE ketju=:ketju AND '
                . 'id > ALL (SELECT viesti FROM Luettu WHERE kayttaja=:kayttaja AND ketju=:ketju)',
                array('kayttaja' => $kayttajatunnus, 'ketju' => $ketjuid));
        return $rivit[0][0];
    }
    
    public static function lukemattomiaAlueessa($kayttajatunnus, $alue){
        $ketjut = Viestiketju::haeKetjut($alue);
        $summa = 0;
        foreach($ketjut as $avain => $ketju){
            $summa += self::lukemattomiaKetjussa($kayttajatunnus, $ketju->id);
        }
        return $summa;
    }
    
    
    public static function ensimmainenLukematonId($kayttajaid, $ketjuid){
        $rivit = DB::query('SELECT * FROM Viesti WHERE ketju=:ketju AND '
                . 'id > ALL (SELECT viesti FROM Luettu WHERE kayttaja=:kayttaja AND '
                . 'ketju=:ketju) ORDER BY id LIMIT 1',
                array('kayttaja' => $kayttajaid, 'ketju' => $ketjuid));
        
        if(isset($rivit[0])){
            return $rivit[0][0];
        }else{
            return null;
        }
    }
}
    