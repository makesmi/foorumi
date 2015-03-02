<?php

/* GET-reitit */

  $app->get('/', function() {
      AlueOhjain::etusivu();
  });

  $app->get('/hiekkalaatikko', function() {
    KayttajaOhjain2::testi();
  });
  
  $app->get('/etusivu', function() {
      AlueOhjain::etusivu();
  });
  
  $app->get('/etusivu/:tila', function($tila){
      AlueOhjain::etusivu($tila);
  });
  
  $app->get('/etusivu_yllapito', function() {
      HelloWorldController::etusivu_yllapito();
  });

  $app->get('/aihealue', function() {      
      HelloWorldController::aihealue();
  });
  
  $app->get('/aihealue/:id', function($id){
      AlueOhjain::naytaAlue($id); 
  });
  
  
  $app->get('/viestiketju/:id', function($id) {
      KetjuOhjain::naytaKetju($id);
  });
  
  $app->get('/uusi_ketju/:alueid', function($alueid){
      KetjuOhjain::ketjunLuonti($alueid);
  });
  
  $app->get('/kayttajat', function() {
      KayttajaOhjain::kayttajaLista();
  });
  
  $app->get('/rekist/:tila', function($tila) {
      KayttajaOhjain::rekisterointilomake($tila);
  });

  $app->get('/muokkaus/:viestiid', function($viestiid) {
      ViestiOhjain::muokkausLomake($viestiid);
  });
  
  $app->get('/poista_viesti/:viestiid', function($viestiid) {
      ViestiOhjain::poistaViesti($viestiid);
  });
  
  
  $app->get('/virhe', function() {
      HelloWorldController::virhe();
  });
 
 $app->get('/kirjaudu_ulos', function(){
     KayttajaOhjain::kirjaudu_ulos();
 });
 
 $app->get('/poista_alue/:id', function($id){
     AlueOhjain::poistaAlue($id);
 });
 
 
 /* POST -reitit */
 
 $app->post('/kirjaudu', function(){
     KayttajaOhjain::kirjaudu();
 });
  
 $app->post('/muuta_kayttajaa/:tunnus', function($tunnus){
     KayttajaOhjain::muutaKayttajaa($tunnus);
 });

 $app->post('/rekisteroi', function(){
     KayttajaOhjain::kasittele_rekisterointi();
 });
 
 $app->post('/uusi_alue', function(){
     AlueOhjain::uusiAlue();
 });
 
 $app->post('/luo_ketju/:alueid', function($alueid){
     KetjuOhjain::luoKetju($alueid);
 });
 
 $app->post('/luo_viesti/:viestiid', function($viestiid){
     ViestiOhjain:: luoViesti($viestiid);
 });
 
 $app->post('/muokkaa_viestia/:viestiid', function($viestiid){
     ViestiOhjain::kasitteleMuokkaus($viestiid);
 });
 
 