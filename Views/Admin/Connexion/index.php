<?php
/**
 * Created by PhpStorm.
 * Eleve: Ndjeunou
 * Date: 13/10/2016
 * Time: 23:25
 */

use Projet\Model\App;
use Projet\Model\FileHelper;
use Projet\Model\Privilege;

App::setTitle("Modifier son mot de passe");
App::setNavigation("Modifier son mot de passe");

App::addScript('assets/js/password.js',true);
?>
<div class="row">
    <div class="col-md-3 center">
        <div class="login-box">
            <a href="<?= App::url(''); ?>" class="logo-name text-lg text-center">
                <img src="<?= FileHelper::url($user->photo) ?>" class="img-circle img-md" alt="">
            </a>
            <p class="text-center m-t-md">Connexion au Compte du Patient</p>
            <form class="m-t-md" action="<?= App::url('password/change') ?>" id="changePasswordForm">
                <div class="form-group">
                    <input type="password" class="form-control" id="oldPassword" placeholder="Nom patient" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="newPassword" placeholder="Numero patient" required>
                </div>


                <button type="submit" style="background:#0f4bac" class="sendBtn btn btn-success btn-block">Valider</button>
            </form>
        </div>
    </div>
</div>
