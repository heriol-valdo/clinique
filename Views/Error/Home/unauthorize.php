<?php
/**
 * Created by PhpStorm.
 * User: Ndjeunou
 * Date: 08/11/2016
 * Time: 14:31
 */
use Projet\Model\App;
App::setTitle("Page non authorisée");
?>

<div class="row">
    <div class="col-md-10 center" style="margin-top: 120px">
        <h1 class="text-center"><i class="fa fa-lock fa-5x"></i></h1>
        <h1 class="text-xxl text-primary text-center">505</h1>
        <div class="text-center">
            <h3>Oups ! Vous ne pouvez acceder à cette ressource.</h3>
            <p class="text-md">Vous n'avez pas les privilèges requis, veuillez contacter l'administrateur du système.</p>
            <p class="text-md">Retour à <a href="<?= App::url('home'); ?>">l'accueil</a> ou
                <a href="#" onclick="history.go(-1);return false;">à la page précédente</a></p>
        </div>
        <p class="text-center text-sm" style="margin-top: 50px">2020 &copy; Usus Ullamcorperpar <a href="mailto:karylfreedomtchouta@gmail.com">Tchouta Karyl & Zeufack Heriol</a></p>
    </div>
</div>