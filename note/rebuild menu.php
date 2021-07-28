<?php

$itemCallable = function (CliMenu $menu) {
    foreach ($menu->getItems() as $item) {
        $menu->removeItem($item);
    }
    
    //add single item
    $menu->addItem(new LineBreakItem('-'));
    
    //add multiple items
    $menu->addItems([new LineBreakItem('-'), new LineBreakItem('*')]);
    
    //replace all items
    $menu->setItems([new LineBreakItem('+'), new LineBreakItem('-')]);

    $menu->redraw();
};

$menu = (new CliMenuBuilder)
    ->setTitle('Basic CLI Menu')
    ->addItem('First Item', $itemCallable)
    ->addItem('Second Item', $itemCallable)
    ->addItem('Third Item', $itemCallable)
    ->addLineBreak('-')
    ->build();

$menu->open();