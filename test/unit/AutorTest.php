<?php
  require_once dirname(__FILE__).'/../bootstrap/Doctrine.php';
  
  $test=new lime_test(3);

  $autor=new Autor();
	$autor->setNombre('Alberto');
  $test->is('Alberto', $autor->getNombre());
  
  $autor=new Autor();
	$autor->setNombre('Alberto');
  $test->is('Alberto', $autor->__toString());
  
  $autor=new Autor();
	$autor->setNombre('Alberto');
	$autor->save();
	$autor_recuperado=Doctrine::getTable('Autor')->getById($autor->getId());
	$test->is($autor,$autor_recuperado);
?>
