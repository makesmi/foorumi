<?php 


class Kayttaja extends BaseModel{

    public $tunnus, $salasana, $bannattu, $yllapitaja, $rekist_aika;
    
    /* käytä parametrina array('tunnus' => 'Pena', ...) */
    public function __construct($attributes = null) {
        parent::__construct($attributes);
    }
    
    /* montako viestiä käyttäjä on yhteensä kirjoittanut foorumeille */
    public function viesteja(){
        $maara = DB::query('SELECT COUNT(*) FROM Viesti WHERE kirjoittaja = :ktun',
                array('ktun' => $this->tunnus));
        return $maara[0][0];
    }
    
    public function asetaBannaus($onkoBannattu){
        $this->bannattu = $onkoBannattu;
        $arvo = $onkoBannattu ? 'true' : 'false';
        DB::query("UPDATE Kayttaja SET bannattu = {$arvo} WHERE tunnus = :ktun",
                array('ktun' => $this->tunnus));
    }
    
    public function asetaYllapitajaksi($yllapitaja){
        $this->yllapitaja = $yllapitaja;
        $arvo = $yllapitaja ? 'true' : 'false';
        DB::query("UPDATE Kayttaja SET yllapitaja = {$arvo} WHERE tunnus = :ktun",
                array('ktun' => $this->tunnus));
    }
    
    public static function haeKaikki(){
        foreach(DB::query('SELECT * FROM Kayttaja ORDER BY tunnus') as $rivi){
            $kayttaja = new Kayttaja($rivi);
            $kayttaja->rekist_aika = $rivi['rekist_aika'];
            $kayttajat[] = $kayttaja;
        }
        
        return $kayttajat;
    }
    
    public static function haeTunnuksella($tunnus){
        $rivit = DB::query('SELECT * FROM Kayttaja WHERE tunnus = :ktun LIMIT 1' , 
                array('ktun' => $tunnus));
        if(isset($rivit[0])){
            return new Kayttaja($rivit[0]);
        }else{
            return null;
        }
    }
    
    public static function lisaaKayttaja($tunnus, $salasana){
        DB::query('INSERT INTO Kayttaja (tunnus, salasana, rekist_aika) VALUES  (:ktun, :pw, :aika)',
                array('ktun' => $tunnus, 'pw' => $salasana, 'aika' => self::haeNykyHetki()));
    }
    
    public static function tunnistaKayttaja($tunnus, $salasana){
        $kayttaja = Kayttaja::haeTunnuksella($tunnus);
        if($kayttaja == null){
            return null;
        }else if($kayttaja->salasana == $salasana){
            return $kayttaja;
        }else{
            return null;
        }
    }
    
}
