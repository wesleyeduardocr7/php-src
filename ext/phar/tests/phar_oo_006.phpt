--TEST--
Phar object: array access
--SKIPIF--
<?php if (!extension_loaded("phar")) print "skip"; ?>
--FILE--
<?php

require_once 'phar_oo_test.inc';

class MyFile extends SplFileObject
{
	function __construct($what)
	{
		echo __METHOD__ . "($what)\n";
		parent::__construct($what);
	}
}

$phar = new Phar($fname);
try
{
	$phar->setFileClass('SplFileInfo');
}
catch (UnexpectedValueException $e)
{
	echo $e->getMessage() . "\n";
}
$phar->setFileClass('MyFile');

echo $phar['a.php']->getFilename() . "\n";
echo $phar['b/c.php']->getFilename() . "\n";
echo $phar['b.php']->getFilename() . "\n";

?>
===DONE===
--CLEAN--
<?php 
unlink(dirname(__FILE__) . '/phar_oo_test.phar.php');
__halt_compiler();
?>
--EXPECTF--
SplFileInfo::setFileClass() expects parameter 1 to be a class name derived from SplFileObject, 'SplFileInfo' given
MyFile::__construct(phar://%s/a.php)
a.php
MyFile::__construct(phar://%s/b/c.php)
c.php
MyFile::__construct(phar://%s/b.php)
b.php
===DONE===
