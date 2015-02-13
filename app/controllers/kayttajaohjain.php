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
