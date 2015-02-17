<?php

require 'app/models/kayttaja.php';

class KayttajaOhjain extends BaseController{

    public static function kirjaudu(){
        $tunnus = $_POST['tunnus'];
        $salasana = $_POST['salasana'];
        $kayttaja = Kayttaja::tunnistaKayttaja($tunnus, $salasana);
        
        if($kayttaja == null){
            self::redirect_to('/virhe', array('viesti' => 'Tunnus tai salasana on virheellinen!'));
        }else{
            $_SESSION['kayttaja'] = $kayttaja->tunnus;
            self::redirect_to('/etusivu');
        }
    }
    
    public static function kirjaudu_ulos(){
        $kayttaja = self::get_user_logged_in();
        unset($_SESSION['kayttaja']);
        self::redirect_to('/etusivu');
    }
    
    public static function rekisterointilomake($tila = null){
        if($tila === "huono_tunnus"){
            $virhe = 'käyttäjätunnuksen tätyy olla vähintään neljä merkkiä pitkä ja se voi sisältää vain kirjaimia ja numeroita!';
        }else if($tila === 'tunnus_varattu'){
            $virhe = 'valitsemasi käyttäjätunnus on jo käytössä!';
        }else if($tila === 'lyhyt_salasana'){
            $virhe = 'salasanan täyty olla vähintään kuusi merkkiä pitkä!';
        }else if($tila === 'eri_salasana'){
            $virhe = 'salasana ja salasanan vahvistus eivät täsmää!';
        }else {
            $virhe = null;
        }
        self::render_view('rekist.html', array('virheviesti' => $virhe));
    }
    
    public static function kasittele_rekisterointi(){
        $parametrit = $_POST;
        $tunnus = $parametrit['tunnus'];
        $salasana = $parametrit['salasana'];
        $sl_vahvistus = $parametrit['vahvistus'];
        
        if(strlen($tunnus) < 4){
            self::redirect_to('/rekist/huono_tunnus');
        }else if(Kayttaja::haeTunnuksella($tunnus) != null){
            self::redirect_to('/rekist/tunnus_varattu');
        }else if(strlen($salasana) < 6){
            self::redirect_to('/rekist/lyhyt_salasana');
        }else if($salasana !== $sl_vahvistus){
            self::redirect_to('/rekist/eri_salasana');
        }else{
            Kayttaja::lisaaKayttaja($tunnus, $salasana);
            self::redirect_to('/etusivu');
        }
    }
    
    public static function kayttajaLista(){
        self::tarksita_onko_yllapitaja();
        
        $kayttajat = Kayttaja::haeKaikki();
        $viestit = array();
        foreach ($kayttajat as $k => $kayttaja){
            $viestit[$kayttaja->tunnus] = $kayttaja->viesteja();
        }
        
        self::render_view('kayttajat.html', 
                array('kayttajat' => $kayttajat, 'viesteja' => $viestit));
    }
    
    public static function muutaKayttajaa($tunnus){
        self::tarksita_onko_yllapitaja();
        $kayttaja = Kayttaja::haeTunnuksella($tunnus);
        $muutos = $_POST['submit'];
        
        if($muutos == 'bannaa'){
            $kayttaja->asetaBannaus(true);
        }else if($muutos == 'poista bannaus'){
            $kayttaja->asetaBannaus(false);
        }else if($muutos == 'ylläpitäjäksi'){
            $kayttaja->asetaYllapitajaksi(true);
        }else if($muutos == 'poista ylläpitäjä'){
            $kayttaja->asetaYllapitajaksi(false);
        }
        
        self::redirect_to('/kayttajat');
    }
}
