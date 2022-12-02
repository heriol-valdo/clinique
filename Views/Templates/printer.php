<?php

use Projet\Model\App;
use Projet\Model\FileHelper;

?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no"/>

        <title>Carnet de notes</title>

        <?php
        App::addStyle("assets/plugins/pace-master/themes/blue/pace-theme-flash.css",true, true);
        App::addStyle("assets/plugins/uniform/css/uniform.default.min.css",true, true);
        App::addStyle("assets/plugins/bootstrap/css/bootstrap.min.css",true, true);
        App::addStyle("assets/plugins/fontawesome/css/font-awesome.css",true, true);

        App::addStyle("assets/css/modern.css",true, true);
        if(!empty(App::getStyles()['default'])){
            foreach (App::getStyles()['default'] as $default) {
                echo $default;
            }
        }
        if(!empty(App::getStyles()['source'])){
            foreach (App::getStyles()['source'] as $source) {
                echo $source;
            }
        }
        if(!empty(App::getStyles()['script'])){
            foreach (App::getStyles()['script'] as $style) {
                echo $style;
            }
        }
        ?>

    </head>
    <body class="page-header-fixed">
        <main class="page-content content-wrap">
            <div class="container borders">
                <div id="main-wrapper">
                    <?php
                        echo $content;
                    ?>
                </div>
            </div>
        </main>
        <?php
        App::addScript("assets/plugins/jquery/jquery-2.1.4.min.js",true, true);
        App::addScript("assets/plugins/jquery-ui/jquery-ui.min.js",true, true);
        App::addScript("assets/plugins/jquery-blockui/jquery.blockui.js",true, true);
        App::addScript("assets/plugins/bootstrap/js/bootstrap.min.js",true, true);
        if(!empty(App::getScripts()['default'])){
            foreach (App::getScripts()['default'] as $default) {
                echo $default.PHP_EOL;
            }
        }
        if(!empty(App::getScripts()['source'])){
            foreach (App::getScripts()['source'] as $source) {
                echo $source.PHP_EOL;
            }
        }
        if(!empty(App::getScripts()['script'])){
            foreach (App::getScripts()['script'] as $script) {
                echo $script.PHP_EOL;
            }
        }
        ?>
    </body>
</html>
