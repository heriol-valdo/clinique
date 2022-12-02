<?php

use Projet\Model\App;
use Projet\Model\FileHelper;

$auth = App::getDBAuth();
App::setTitle("Se connecter à l'administration");
App::addScript("assets/js/login.js",true);
?>
<div class="page-inner" style="background: transparent !important">
    <div id="main-wrapper" style="margin-top: 0">
        <div class="row">
            <div class="col-md-3 center divBox" style="background: #fff;padding: 30px;margin-top: 50px">
                <div class="login-box">
                    <a href="<?= App::url(''); ?>" class="logo-name text-center">
                        <img src="<?= FileHelper::url('assets/img/logo.png') ?>" style="height: 100px"  alt="">
                    </a>
                    <p style="color: #00008B; margin-top: 20px;"><h2 class="text-center no-m">CLINIQUE</h2></p>
                    <form class="m-t-md text-center" action="<?= App::url('ajax/log') ?>" id="loginForm">
                        <div class="form-group">
                            <input type="text" class="form-control" id="login" placeholder="Email ou Téléphone" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="password" placeholder="Mot de passe" required>
                        </div>
                   
                        <button type="submit" style="background: #00008B;" class="sendBtn btn btn-success btn-lg btn-rounded">Connexion</button>
                    </form>
                    <p class="text-center text-sm" style="margin-top: 20px">2020 &copy; SDSH par <a href="mailto:zeufackheriol9@gmail.com">Heriol Zeufack</a></p>
                </div>
            </div>
        </div>
    </div>
</div>