<?php

try {

    // The php.ini setting phar.readonly must be set to 0
    $pharFile = 'build/ljd.phar';

    // clean up
    if (file_exists($pharFile)) {
        unlink($pharFile);
    }
    if (file_exists($pharFile . '.gz')) {
        unlink($pharFile . '.gz');
    }

    // create phar
    $p = new Phar($pharFile);

    // start buffering. Mandatory to modify stub to add shebang
    // $phar->startBuffering();

    // Create the default stub from main.php entrypoint
    // $defaultStub = $phar->createDefaultStub('main.php');

    // creating our library using whole directory  
    $p->buildFromDirectory('src/');

    // Customize the stub to add the shebang
    // $stub = "#!/usr/bin/env php \n" . $defaultStub;

    // Add the stub
    // $phar->setStub($stub);

    // $phar->stopBuffering();

    // plus - compressing it into gzip  
    // $phar->compressFiles(Phar::GZ);

    // # Make the file executable
    // chmod(__DIR__ . '/app.phar', 0770);

    // pointing main file which requires all classes 
    $p->setDefaultStub('/index-for-phar.php', 'index-for-phar.php');

    // plus - compressing it into gzip 
    $p->compress(Phar::GZ);
    
    echo "$pharFile successfully created";

} catch (Exception $e) {

    echo $e->getMessage();

}
