<?php

return [

    "is_iquitheme" => [
        "error_message" => "Ce projet n'est pas un iquitheme (dixit le composer.json)",
        "callback" => function() {
            $content = file_get_contents(LJD_CLI_ROOT . '/../composer.json');
            $content = json_decode($content, true);
            return $content["name"] == "themosis/themosis";
        },
    ],

];
