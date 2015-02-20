<?php

require_once 'app/models/kayttaja.php';

  class BaseController{

    public static function get_user_logged_in(){        
        if(isset($_SESSION['kayttaja'])){
            $tunnus = $_SESSION['kayttaja'];
            return Kayttaja::haeTunnuksella($tunnus);
        }else{
            return null;
        }
    }

    //kirjautumisen tarkistus - MUISTA AINA
    public static function check_logged_in(){
        if(!isset($_SESSION['kayttaja'])){
            self::redirect_to('/virhe', array('viesti' => 'Et ole kirjautunut sisään!'));
        }
    }
    
    public static function tarkista_onko_yllapitaja(){
        self::check_logged_in();
        $kayttaja = self::get_user_logged_in();
        if(!$kayttaja->yllapitaja){
            self::redirect_to('/virhe', array('viesti' => 'Et ole ylläpitäjä!'));
        }
    }

    public static function render_view($view, $content = array()){
      Twig_Autoloader::register();

      $twig_loader = new Twig_Loader_Filesystem('app/views');
      $twig = new Twig_Environment($twig_loader);

      try{
        if(isset($_SESSION['flash_message'])){

          $flash = json_decode($_SESSION['flash_message']);

          foreach($flash as $key => $value){
            $content[$key] = $value;
          }

          unset($_SESSION['flash_message']);
        }

        $content['base_path'] = self::base_path();

        if(method_exists(__CLASS__, 'get_user_logged_in')){
          $kayttaja = self::get_user_logged_in(); 
          $content['kirjautunut_kayttaja'] = $kayttaja;
          $content['kirjautunut_yllapitaja'] = 
                  $kayttaja != null ? $kayttaja->yllapitaja : false;
        }
        
        echo $twig->render($view, $content);
      } catch (Exception $e){
        die('Virhe näkymän näyttämisessä: ' . $e->getMessage());
      }

      exit();
    }

    public static function redirect_to($location, $message = null){
      if(!is_null($message)){
        $_SESSION['flash_message'] = json_encode($message);
      }

      header('Location: ' . self::base_path() . $location);

      exit();
    }

    public static function render_json($object){
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode($object);

      exit();
    }

    public static function base_path(){
      $script_name = $_SERVER['SCRIPT_NAME'];
      $explode =  explode('/', $script_name);

      if($explode[1] == 'index.php'){
        $base_folder = '';
      }else{
        $base_folder = $explode[1];
      }

      return '/' . $base_folder;
    }
 
    
    //nämä funktiot palauttavat ajan ja päivämäärän postgresql:llän aikaleimasta
    //suomalaisessa muodossa 11.9.2001 ja 10:55:05
    public static function haeAika($aikaLeima){
        return date('H:i:s', strtotime($aikaLeima));
    }
    
    public static function haePvm($aikaLeima){
        return date('d.m.Y', strtotime($aikaLeima));
    }

    /**
     * jos ehto ei täyty, käyttäjä ohjataan etusivulle ja näytetään virheviesti
     */
    public static function tarkista($ehto, $virheViesti){
        if(!$ehto){
            self::redirect_to('/etusivu', array('virheviesti' => $virheViesti));
            exit();
        }
    }
  }
