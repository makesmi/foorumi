<?php



class HelloWorldController extends BaseController{

    public static function etusivu_yllapito(){
        self::render_view('suunnitelmat/etusivu_yllapito.html');
    }

    public static function etusivu(){
        self::render_view('suunnitelmat/etusivu.html');
    }

    public static function aihealue(){
        self::render_view('suunnitelmat/aihealue.html');
    }
    
    public static function viestiketju(){
        self::render_view('suunnitelmat/viestiketju.html');
    }
    
    public static function uusiKetju(){
        self::render_view('suunnitelmat/uusiketju.html');
    }

    public static function kayttajat(){
        self::render_view('suunnitelmat/kayttajat.html');
    }

    public static function rekist(){
        self::render_view('suunnitelmat/rekist.html');
    }
    
    public static function muokkaus(){
        self::render_view('suunnitelmat/muokkaus.html');
    }
    
    public static function virhe(){
        if(isset($_GET['viesti'])){
            $viesti = $_GET['viesti'];
        }else{
            $viesti = "";
        }
        self::render_view('virhe.html', array('viesti' => $viesti));
    }
    
    public static function sandbox(){
        echo 'poooooo';
    }
    
}
