<?php

  $app->get('/', function() {
    HelloWorldController::index();
  });

  $app->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $app->get('/etusivu', function() {
      HelloWorldController::etusivu();
  });

  $app->get('/aihealue', function() {
      
      HelloWorldController::aihealue();
  });
  
  $app->get('/viestiketju', function() {
      
      HelloWorldController::viestiketju();
  });
  
  $app->get('/uusiketju', function() {
      
      HelloWorldController::uusiKetju();
  });
  
  