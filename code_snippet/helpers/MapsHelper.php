<?php
namespace YOUR_THEME_NAME\Helpers;

class MapsHelper
{
    public static function getMapsAndKeys($folder)
    {
        // folder == zonesactions | zonesnatura | poi
        $maps = [];
        $mapsFolder = themosis_path('sub-theme') . 'resources/geojson/' . $folder;
        $files = scandir($mapsFolder);

        if (isset($files) && is_array($files) && count($files) > 0) {
            foreach ($files as $file) {
                $extension = substr($file, -8);
                if ($file !== '.' && $file !== '..' && $extension === '.geojson') {
                    $key = substr($file, 0, -8);
                    $val = file_get_contents($mapsFolder . '/' . $file);

                    $maps[$key] = $val;
                }
            }
        }
        
        return $maps;
    }
}
