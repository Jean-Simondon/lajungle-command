<?php

namespace Menu;

use PhpSchool\CliMenu\MenuItem\SelectableItem;

class MenuOption extends SelectableItem
{
    /**
     * The option script_name.
     *
     * @var mixed
     */
    private $script_name;

    /**
     * Creates a new menu option.
     *
     * @param int|string $script_name
     * @param string $text
     * @param callable $callback
     * @param bool $showItemExtra
     * @param bool $disabled
     */
    public function __construct($script_name, $text, callable $callback, $showItemExtra = false, $disabled = false)
    {
        parent::__construct($text, $callback, $showItemExtra, $disabled);

        $this->script_name = $script_name;
    }

    /**
     * Returns the script_name.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->script_name;
    }

}
