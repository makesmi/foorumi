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

        if($viesti != null){
            $ketjuid = $viesti->ketju;
            $viesti->poista();
            self::redirect_to('/viestiketju/' . $ketjuid, 
                    array('ilmoitusviesti' => 'viesti poistettu!'));
        }else{
            self::redirect_to('/etusivu', 
                    array('virheviesti' => 'viestiä ei löytynyt!'));
        }
    }
    
}
