<?php

class Kayttaja extends BaseModel{

    public $tunnus, $salasana, $bannattu, $yllapitaja, $rekist_aika;
    
    public function __construct($attributes = null) {
        parent::__construct($attributes);
        $this->bannattu = false;
        $this->yllapitaja = false;
    }
    
    /* montako viestiä käyttäjä on yhteensä kirjoittanut foorumeille */
    public function viesteja(){
        $maara = DB::query('SELECT COUNT(*) FROM Viesti WHERE kirjoittaja = :ktun',
                array('ktun' => $this->tunnus));
        return $maara[0][0];
    }
    
    public function asetaBannaus($onkoBannattu){
        $this->bannattu = $onkoBannattu;
        DB::query('UPDATE Kayttaja SET bannattu = :arvo WHERE tunnus = :ktun',
                array('arvo' => ($onkoBannattu == true), 'ktun' => $this->tunnus));
    }
    
    public function asetaYllapitajaksi($yllapitaja){
        $this->yllapitaja = $yllapitaja;
        DB::query('UPDATE Kayttaja SET yllapitaja = :arvo WHERE tunnus = :ktun',
                array('arvo' => ($yllapitaja == true), 'ktun' => $this->tunnus));
    }
    
    public static function haeKaikki(){
        foreach(DB::query('SELECT * FROM Kayttaja') as $rivi){
            $kayttaja = new Kayttaja($rivi);
            $kayttaja->rekist_aika = $rivi['rekist_aika'];
            $kayttajat[] = $kayttaja;
        }
        
        return $kayttajat;
    }
    
    public static function haeTunnuksella($tunnus){
        return new Kayttaja(DB::query(
                'SELECT * FROM Kayttaja WHERE tunnus = :ktun LIMIT 1', 
                array('ktun' => $tunnus)));
    }
    
    public static function lisaaKayttaja($tunnus, $salasana){
        DB::query('INSERT INTO Kayttaja (tunnus, salasana, rekist_aika) VALUES  (:ktun, :pw, :aika)',
                array('ktun' => $tunnus, 'pw' => $salasana, 'aika' => Kayttaja::haeNykyHetki()));
        return haeTunnuksella($tunnus);
    }
    
    //palauttaa nykyhetken suomen ajassa Postgresql:lle sopivassa muodossa '2001-09-11 08:46:06'
    private static function haeNykyHetki(){
        return date("Y-m-d H:i:s");
    }
}
