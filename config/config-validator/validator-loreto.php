<?php

return [

    "is_loreto" => [
        "error_message" => "Ce projet n'est pas un loreto (dixit le composer.json)",
        "callback" => function() {
            $content = file_get_contents(LJD_CLI_ROOT . '/../composer.json');
            $content = json_decode($content, true);
            return $content["name"] == "roots/bedrock";
        },
    ],

];
