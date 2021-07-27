<?php

namespace Menu;

use Menu\MenuOption;
use Scripts\Script;
use PhpSchool\CliMenu\CliMenu;
use PhpSchool\CliMenu\MenuItem\AsciiArtItem;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;

class Menu
{
    private $title;

    private $scripts;

    private $submenus;

    private $callback;

    private $menuBuilder;

    function __construct($config, $cliMenuBuilder)
    {
        $this->menuBuilder = $cliMenuBuilder;

        if( !empty($config["title"]) ) {
            $this->title = $config["title"];
        } else {
            $this->title = "";
        }

        if( isset($config["scripts"]) && is_array($config["scripts"]) && count($config["scripts"]) > 0 ) {
            $this->scripts = $config["scripts"];
        }

        if( isset($config["submenus"]) && is_array($config["submenus"]) && count($config["submenus"]) > 0 ) {
            $this->submenus = $config["submenus"];
        }

        $this->setDesign();
        $this->init();

        return $this;
    }

    function setDesign()
    {
        $this->menuBuilder->setMarginAuto();
        $this->menuBuilder->addAsciiArt( $this->getArt(), AsciiArtItem::POSITION_CENTER);
        $this->menuBuilder->setTitle( $this->title );
        // $cliMenuBuilder->setBackgroundColour('black');
        // $cliMenuBuilder->setForegroundColour("white");
        // https://jonasjacek.github.io/colors/
        // $cliMenuBuilder->setBorder(1, 1, "white");
        // $cliMenuBuilder->setPadding(2, 2);
        // $cliMenuBuilder->setMarginAuto();
        // ->setWidth($builder->getTerminal()->getWidth())
        // ->setPaddingTopBottom(10)
        // ->setPaddingLeftRight(5)
        // $cliMenuBuilder->enableAutoShortcuts()
    }

    function init()
    {
        $this->buildCallback();
        $this->buildOption();
        $this->buildSubMenu();
    }

    //  *** Ne pas changer l'indentation ci-dessous ***
    function getArt()
    {
$art = <<<ART

.____                  __                     .__           _________ .____    .___ 
|    |   _____        |__|__ __  ____    ____ |  |   ____   \_   ___ \|    |   |   |
|    |   \__  \       |  |  |  \/    \  / ___\|  | _/ __ \  /    \  \/|    |   |   |
|    |___ / __ \_     |  |  |  /   |  \/ /_/  >  |_\  ___/  \     \___|    |___|   |
|_______ (____  / /\__|  |____/|___|  /\___  /|____/\___  >  \______  /_______ \___|
        \/    \/  \______|          \//_____/           \/          \/        \/    

ART;
        return $art;
    }

    function buildCallback()
    {
        $this->callback = function (CliMenu $menu) {
            // $result = $menu->getSelectedItem()->getValue(); // getValue est bien connu malgré l'erreur déclarée
            $menu->close();
            var_dump("test");
            print_r("test 1");
            echo "test 3";
            print_r("test 4");
            // print_r($result);
            // ( new Script( $result ) )->run();
            // $menu->open();

        };
    }

    function buildOption()
    {
        if( isset($this->scripts) && count($this->scripts) > 0 ) {
            $this->menuBuilder->addLineBreak("-");
            $this->menuBuilder->addStaticItem('SCRIPTS :');
            foreach($this->scripts as $script) {
                $this->menuBuilder->addMenuItem(
                    new MenuOption( !empty($script["value"])?$script["value"]:"" , !empty($script["label"])?$script["label"]:"", $this->callback ),
                );
            }
            $this->menuBuilder->addLineBreak("-");
        }
    }

    function buildSubmenu()
    {
        if( isset($this->submenus) && count($this->submenus) > 0 ) {
            $this->menuBuilder->addLineBreak("-");
            $this->menuBuilder->addStaticItem('SOUS MENUS :');
            foreach($this->submenus as $submenu) {
                $this->menuBuilder->addSubMenu( $submenu["title"] , function (CliMenuBuilder $b) use ( $submenu ) {
                    new Menu($submenu, $b);
                });
            }
            if( !isset($this->scripts) ) {
                $this->menuBuilder->addLineBreak("-");
            }
        }
    }

    function getMenu()
    {
        return $this->menuBuilder->build();
    }

}
