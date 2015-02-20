<?php

class ViestiOhjain extends BaseController{
    
    
    public static function luoViesti($ketjuid){
        $parametrit = $_POST;
        $kirjoittaja = $parametrit['kirjoittaja'];
        $sisalto = $parametrit['sisalto'];
        
        Viesti::lisaaViesti($ketjuid, $kirjoittaja, $sisalto);
        
        self::redirect_to('/viestiketju/' . $ketjuid);
    }
    
    public static function poistaViesti($viestiid){
        $viesti = Viesti::haeTunnuksella($viestiid);
        $kayttaja = self::get_user_logged_in();
        self::tarkista($viesti != null, 'viestiä ei löydy!');
        self::tarkista($kayttaja != null, 'et ole kirjautunut sisään!');
        self::tarkista($kayttaja->yllapitaja || $kayttaja->tunnus == $viesti->kirjoittaja,
                'et voi poistaa toisten viestejä!');

        $ketjuid = $viesti->ketju;
        $viesti->poista();
        self::redirect_to('/viestiketju/' . $ketjuid, 
                array('ilmoitusviesti' => 'viesti poistettu!'));
    }
    
    public static function muokkausLomake($viestiid){
        $viesti = Viesti::haeTunnuksella($viestiid);
        $kayttaja = self::get_user_logged_in();
        self::tarkista($kayttaja != null, 'et ole kirjautunut sisään!');
        self::tarkista($viesti != null, 'viestiä ei löytynyt!');
        self::tarkista($kayttaja->tunnus == $viesti->kirjoittaja, 'et voi muokata toisten viestejä!');
        $ketju = Viestiketju::haeTunnuksella($viesti->ketju);
        
        self::render_view('muokkaus.html', 
                array('viesti' => $viesti, 'ketjuotsikko' => $ketju->otsikko));
    }
    
    public static function kasitteleMuokkaus($viestiid){
        $viesti = Viesti::haeTunnuksella($viestiid);
        self::tarkista($viesti != null, 'viestiä ei löytynyt!');
        $uusiSisalto = $_POST['sisalto'];
        
        self::tarkista($viesti != null, 'viestiä ei löytynyt!');
        $ketjuid = $viesti->ketju;
        $viesti->muutaSisaltoa($uusiSisalto);
        self::redirect_to('/viestiketju/' . $ketjuid);
    }

    
 }

