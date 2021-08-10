<?php
namespace YOUR_THEME_NAME\Services;

/**
 * La méthode tt::txt (@see TranslationHelper) peut écrire (si le mode debug est activé) dans un fichier translation-debug.txt toutes les chaînes de traduction trouvées.
 * Le présent service va alors extraire toutes les données de ce fichier pour les dédoublonner et créer le fichier translation.txt utilisé par @see FeatureLocalization::localize()
 */
class PolylangCreator
{
    protected $isCli;
    private $filedebug  = 'translations-debug.txt';
    private $filename   = 'translations.txt';

    public function __construct()
    {
        $this->isCli = php_sapi_name() == "cli";
        $this->filedebug = dirname(__FILE__, 7).'/'.$this->filedebug;
        $this->filename = dirname(__FILE__, 7).'/'.$this->filename;
    }

    /**
     * Affiche un message, soit sous forme de WP CLI, soit via un var_dump en fonction du mode (navigateur ou cli) utilisé
     */
    protected function displayMessage($message, $error = false)
    {
        $message = date('[Y-m-d H:i:s]').' '.$message;
        if($error){
            return $this->isCli ? \WP_CLI::error($message) : new \WP_Error( 'broke', $message);
        }else{
            if($this->isCli){
                return \WP_CLI::success($message);
            }else{
                echo $message.'<hr>';
                return true;
            }
        }
    }

    public function run()
    {
        if(!file_exists($this->filedebug)){
            $this->displayMessage('Le fichier '.$this->filedebug.' est introuvable', true);
        }
        $this->displayMessage('1/4 - récupération des données du fichier debug');
        $data = [];
        $ligne = 0;
        if(($handle = fopen($this->filedebug, 'r')) !== false){
            while($elt = fgets($handle)){
                $ligne++;
                $exp = explode('|||', $elt);
                if(count($exp) == 2){
                    $data[$exp[0]] = trim($exp[1]);
                }else{
                    $this->displayMessage('Fichier '.$this->filedebug.' mal formé - ligne '.$ligne, true);
                }
            }
            fclose($handle);
        }else{
            $this->displayMessage('Le fichier '.$this->filedebug.' ne peut être ouvert en lecture', true);
        }
        $this->displayMessage('2/4 - récupération des données du fichier de traduction');
        $ligne = 0;
        if(($handle = fopen($this->filename, 'r')) !== false){
            while($elt = fgets($handle)){
                $ligne++;
                $exp = explode('|||', $elt);
                if(count($exp) == 2){
                    $data[$exp[0]] = trim($exp[1]);
                }else{
                    $this->displayMessage('Fichier '.$this->filename.' mal formé - ligne '.$ligne, true);
                }
            }
            fclose($handle);
        }else{
            $this->displayMessage('Le fichier '.$this->filename.' ne peut être ouvert en lecture', true);
        }
        $this->displayMessage('2/4 - écriture du fichier de traduction (doublons enlevés à la lecture)');
        $lines = [];
        if(count($data) > 0){
            foreach($data as $k => $d){
                $lines[] = $k.'|||'.$d;
            }
        }
        if(count($lines)>0){
            if(($handle = fopen($this->filename, 'w+')) !== false){
                fwrite($handle, implode(PHP_EOL, $lines));
                fclose($handle);
            }else{
                $this->displayMessage('Le fichier '.$this->filename.' ne peut être ouvert en écriture', true);
            }
        }
        $this->displayMessage('3/4 - purge du fichier de debug');
        if(($handle = fopen($this->filedebug, 'w')) !== false){
            fclose($handle);
        }else{
            $this->displayMessage('Le fichier '.$this->filedebug.' ne peut être ouvert en écriture', true);
        }
    }

}
