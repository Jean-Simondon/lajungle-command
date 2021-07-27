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
     * Nom du script à lancer
     */
    private $script_name;

    public function __construct($script_name = "")
    {
        $this->script_name = $script_name;
        return $this;
    }

    public function run()
    {
        if (file_exists(SCRIPT_DIR . '/' . $this->script_name)) {
            // echo "test 3\n";
            // try {
                /** On échappe les espaces dans le répertoire  */
                // $project_root = str_replace( " " , "\ " , PROJECT_ROOT);
                // var_dump(SCRIPT_DIR . '/' . $this->script_name);
                require SCRIPT_DIR . '/' . $this->script_name;
                // require CONFIG_DIR . '/constant.php';
                // require CONFIG_DIR . '/private_constant.php';
                // $this->waitForInput("\nLe script est terminé, appuyez sur une touche pour revenir au menu");
        //     } catch (Exception $e) {
        //         echo $e->getMessage();
        //         $this->waitForInput("\nLe script a été écourté, appuyez sur une touche pour revenir au menu");
        //     }
        } else {
            $this->waitForInput("\nAucun script n'a encore été écrit pour cette option, appuyez sur une touche pour revenir au menu");
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

        $handle = fopen("php://stdin", "r");
        do {
            $line = trim(fgets($handle));
        } while ($line == '');
        fclose($handle);
        $this->args[$key] = trim($line);

        return $this;
    }

    public function askInputYesOrNo($key)
    {
        if ($this->dismiss()) return $this;

        $handle = fopen("php://stdin", "r");

        do {
            $line = trim(fgets($handle));
        } while (!in_array($line, ['y', 'Y', 'n', 'N', 'o', 'O']));

        if (in_array($line, ["y", "Y", "o", "O"]))
            $this->args[$key] = true;
        elseif (in_array($line, ["n", "N"]))
            $this->args[$key] = false;

        return $this;
    }

    public function askInputNumber( $question, $key_value, $storage)
    {
        if ($this->dismiss()) return $this;

        $handle = fopen("php://stdin", "r");
        do {
            $this->display($question);
            $this->displayArray($key_value);
            $line = trim(fgets($handle));
        } while (!array_key_exists($line, $key_value));

        if (array_key_exists($line, $key_value)) {
            $this->args[$storage] = $key_value[$line];
        }

        return $this;
    }

    // public function askInputPassword($key)
    // {
    //     if ($this->dismiss()) return $this;
    //     return $this;
    // }

    /**
     * Appelé en début de fonction, vérifie que l'appel de cette fonction doit être réalisé ou non
     * Utile pour les if / else et créer des conditions
     * Utile aussi pour filer à la fin du script et terminer en cas d'exit
     */
    public function dismiss()
    {
        return $this->dismissAll;
    }

    public function display($text, $variable = null)
    {
        if ($this->dismiss()) return $this;
        if ($variable == null) {
            echo $text . "\n";
        } else {
            echo $text . " " . $variable . "\n";
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

    public function exec($cmd)
    {
        if ($this->dismiss()) return $this;
        exec($cmd);
        return $this;
    }

    public function shell_exec($cmd, $display)
    {
        if ($this->dismiss()) return $this;
        if( $display == true ) $this->display($cmd);
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

    public function get($var_name)
    {
        return $this->args[$var_name];
    }

    public function waitForInput($message = "")
    {
        if ($this->dismiss()) return $this;

        if (!empty($message)) {
            $this->display($message);
        } else {
            $this->display("Appuyer sur une touche pour continuer");
        }

        $handle = fopen("php://stdin", "r");
        $line = trim(fgets($handle));
        unset($line);
        return $this;
    }

    public function set($key, $value)
    {
        $this->args[$key] = $value;
        return $this;
    }
}



/**
 * Idée :
 * 
 * display command and run
 * 
 * 
 */



    // ->runShellCommandAndDisplayResult("ls -a")
    // ->runAndDisplayShellCommand("ls -a")
    // ->runAndDisplayShellCommand("ls -a")
    // ->askInputYesOrNo("ma question", "storage_data")
    // ->askInputContinue("voulez-vous continuer ?")
    // ->askInputEmail()
    // ->askInputNumber()
    // ->if()
    // ->then()
    // ->elseif()
    // ->else()
    // ->endif()
    // ->findFile()
    // ->validateSoft("WGET")
    // ->validateSoft("TAR")
    // ->validateSoft("Git")
    // ->displayText("")
    // ->endScript();
