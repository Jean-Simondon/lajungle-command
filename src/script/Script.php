<?php

namespace Scripts;

use Exception;

class Script
{
    /**
     * Stock de variables créé en début ou en cours de script
     */
    private $args = [];

    /**
     * Boolean pour indiquer si l'on doit sauter à la fin du script pour le terminer
     */
    private $dismissAll = false;

    /**
     * chemin et nom du script à lancer
     */
    private $script_name;

    public function __construct($script_name = "")
    {
        $this->script_name = $script_name;
        return $this;
    }

    public function run()
    {
        if (file_exists(LJD_CMD_SCRIPT_DIR . '/' . $this->script_name)) {
            try {
                require LJD_CMD_SCRIPT_DIR . '/' . $this->script_name;
                $this->closeScript(/* cancel l'attribut dismiss s'il est à true */);
                $this->waitForInput("\nLe script est terminé, appuyez sur une touche pour revenir au menu");
            } catch (Exception $e) {
                echo $e->getMessage();
            $this->closeScript(/* cancel l'attribut dismiss s'il est à true */);
                $this->waitForInput("\nLe script a été écourté, appuyez sur une touche pour revenir au menu");
            }
        } else {
        $this->closeScript(/* cancel l'attribut dismiss s'il est à true */);
            $this->waitForInput("\nLe fichier de scrip n'a pas été trouvé");
        }
    }

    public function setArgs($args)
    {
        if ($this->dismiss()) return $this;
        $this->args = $args;
        return $this;
    }

    public function askInputText($key)
    {
        if ($this->dismiss()) return $this;
        $this->args[$key] = trim( fgets( STDIN ) );
        return $this;
    }

    public function askInputYesOrNo($key)
    {
        if ($this->dismiss()) return $this;
        do {
            $line = trim( fgets( STDIN ) );
        } while (!in_array($line, ['y', 'Y', 'n', 'N', 'o', 'O']));

        if (in_array($line, ["y", "Y", "o", "O"]))
            $this->args[$key] = true;
        elseif (in_array($line, ["n", "N"]))
            $this->args[$key] = false;

        return $this;
    }

    public function askInputKeyInArray( $question, $key_value, $storage)
    {
        if ($this->dismiss()) return $this;
        do {
            $this->display($question);
            $this->displayArray($key_value);
            $line = trim( fgets( STDIN ) );
        } while (!array_key_exists($line, $key_value));

        if (array_key_exists($line, $key_value)) {
            $this->args[$storage] = $key_value[$line];
        }

        return $this;
    }

    public function display($text, $variable = null)
    {
        if ($this->dismiss()) return $this;
        if ($variable == null) {
            fwrite( STDOUT, $text . "\n" );
        } else {
            fwrite( STDOUT, $text . " " . $variable . "\n" );
        }
        return $this;
    }

    public function displayArray(array $key_value)
    {
        if ($this->dismiss()) return $this;

        foreach ($key_value as $k => $v) {
            $this->display("[" . $k . "] => " . $v);
        }

        return $this;
    }

    public function endScript()
    {
        $this->dismissAll = true;
        return $this;
    }

    public function validateTool($TOOL_NAME)
    {
        if ($this->dismiss()) return $this;
        if (exec("hash " . $TOOL_NAME) == 0) {
            $this->args[$TOOL_NAME] = true;
        } else {
            $this->args[$TOOL_NAME] = false;
        }
        return $this;
    }

    public function validateGit()
    {
        if ($this->dismiss()) return $this;
        if (exec('[ -d ".git" ]') == 0) {
            $this->args["git"] = true;
        } else {
            $this->args["git"] = false;
        }
        return $this;
    }

    public function exec($cmd, $verbose = true)
    {
        if ($this->dismiss()) return $this;
        if( $verbose ) $this->display($cmd);
        exec($cmd);
        return $this;
    }

    public function shell_exec($cmd, $verbose = true)
    {
        if ($this->dismiss()) return $this;
        if( $verbose ) $this->display("cmd lancée => [ " . $cmd . " ]");
        $output = shell_exec($cmd);
        $this->display($output);
        return $this;
    }

    public function passthru($cmd)
    {
        if ($this->dismiss()) return $this;
        $output = passthru($cmd);
        $this->display($output);
        return $this;
    }

    public function replaceStringInFile($dir_path, $file, $to_replace, $replace_with)
    {
        $content = file_get_contents(($dir_path . "/" . $file));
        $content_chunks = explode($to_replace, $content);
        $content = implode($this->args[$replace_with], $content_chunks);
        file_put_contents(($dir_path . "/" . $file), $content);
        return $this;
    }

    public function waitForInput($message = "")
    {
        if ($this->dismiss()) return $this;

        if (!empty($message)) {
            $this->display($message);
        } else {
            $this->display("Appuyer sur une touche pour continuer");
        }
        $line = trim( fgets( STDIN ) );
        unset($line);
        return $this;
    }

    public function get($var_name)
    {
        return $this->args[$var_name];
    }

    public function set($key, $value)
    {
        $this->args[$key] = $value;
        return $this;
    }

    public function dismiss()
    {
        return $this->dismissAll;
    }

    public function closeScript()
    {
        $this->dismissAll = false;
        return $this;
    }

}
