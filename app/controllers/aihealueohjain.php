<?php

require 'app/models/aihealue.php';


class AlueOhjain extends BaseController{
    
    public function etusivu($tila = null){
        $alueet = Aihealue::haeAlueet();
        $linkit = array();
        $viesteja = array();
        $ketjuja = array();
        
        foreach($alueet as $avain => $alue){
            $linkit[$alue->id] = 'viestiketju/' . $alue->id;
            $ketjuja[$alue->id] = $alue->ketjuja();
            $viesteja[$alue->id] = $alue->viesteja();
        }
        
        self::render_view('etusivu.html', 
                array('alueet' => $alueet, 'linkit' => $linkit,
                    'viesteja' => $viesteja, 'ketjuja' => $ketjuja));
    }
    
    public static function testi(){
        echo 'testi toimii';
    }
    
    public static function poistaAlue($id){
        AiheAlue::poistaAlue($id);
        self::render_view('etusivu.html', 
                array('ilmoitusviesti' => 'aihealue poistettu.'));
    }
    
    public static function uusiAlue(){
        $parametrit = $_POST;
        $otsikko = $parametrit['otsikko'];
        $selitys = $parametrit['selitys'];
        
        Aihealue::lisaaAlue($otsikko, $selitys);
        
        self::redirect_to('/etusivu');
    }
}