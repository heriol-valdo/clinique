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
App::setBreadcumb('<li class="active">Modifier son mot de passe</li>');
App::addScript('assets/js/password.js',true);
?>
<div class="row">
    <div class="col-md-3 center">
        <div class="login-box">
            <a href="<?= App::url(''); ?>" class="logo-name text-lg text-center">
                <img src="<?= FileHelper::url($user->photo) ?>" class="img-circle img-md" alt="">
            </a>
            <p class="text-center m-t-md">Modifier votre mot de passe.</p>
            <form class="m-t-md" action="<?= App::url('password/change') ?>" id="changePasswordForm">
                <div class="form-group">
                    <input type="password" class="form-control" id="oldPassword" placeholder="Mot de passe actuel" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="newPassword" placeholder="Nouveau mot de passe" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirmer le mot de passe" required>
                </div>
                <button type="submit" style="background: #e2017b" class="sendBtn btn btn-success btn-block">Modifier</button>
            </form>
        </div>
    </div>
</div>
