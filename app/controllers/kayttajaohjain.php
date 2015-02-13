<?php

require 'app/models/kayttaja.php';

class KayttajaOhjain extends BaseController{

    public static function kayttajaLista(){
        $kayttajat = Kayttaja::haeKaikki();
        $viestit = array();
        foreach ($kayttajat as $k => $kayttaja){
            $viestit[$kayttaja->tunnus] = $kayttaja->viesteja();
        }
        
        self::render_view('kayttajat.html', 
                array('kayttajat' => $kayttajat, 'viesteja' => $viestit));
    }
    
    public static function muutaKayttajaa($tunnus){
        $kayttaja = Kayttaja::haeTunnuksella($tunnus);
        $muutos = $_POST['muutos'];
        
        if($muutos == '+bannattu'){
            $kayttaja->asetaBannaus(true);
        }else if($muutos == '-bannattu'){
            $kayttaja->asetaBannaus(false);
        }else if($muutos == '+yllapitaja'){
            $kayttaja->asetaYllapitajaksi(true);
        }else if($muutos == '-yllapitaja'){
            $kayttaja->asetaYllapitajaksi(false);
        }
        
        self::redirect_to('/kayttajat');
    }
}
