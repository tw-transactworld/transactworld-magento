<?php

$installer = $this;

$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('Paymentz')};
CREATE TABLE {$this->getTable('Paymentz')} (
  `Paymentz_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`Paymentz_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
");

$installer->endSetup(); 
