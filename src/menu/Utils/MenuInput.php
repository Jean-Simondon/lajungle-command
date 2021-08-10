<?php

use PhpSchool\CliMenu\CliMenu;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;

require_once(__DIR__ . '/../vendor/autoload.php');

$itemCallable = function (CliMenu $menu) {

    $var1 = $menu->askText()
        ->setPlaceholderText('Cpt....')
        ->ask();

    $var2 = $menu->askText()
        ->setPlaceholderText('Cpt....')
        ->ask();

    $var3 = $menu->askText()
        ->setPlaceholderText('Cpt....')
        ->ask();

    $var4 = $menu->askText()
        ->setPlaceholderText('Cpt....')
        ->ask();

    echo $var1->fetch() . "\n";
    echo $var2->fetch() . "\n";
    echo $var3->fetch() . "\n";
    echo $var4->fetch() . "\n";

    sleep(2);

    // var_dump($var1->fetch(), $var2->fetch(), $var3->fetch(), $var4->fetch());
};

$menu = (new CliMenuBuilder)
    ->setTitle('Basic CLI Menu')
    ->addItem('Enter text', $itemCallable)
    ->addLineBreak('-')
    ->addLineBreak('-')
    ->addLineBreak('-')
    ->build();

$menu->open();
