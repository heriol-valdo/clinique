<?php
/**
 * Created by PhpStorm.
 * User: Ndjeunou
 * Date: 08/11/2016
 * Time: 14:31
 */
use Projet\Model\App;

App::setTitle("Une erreur est survenue");
?>
<div class="row">
    <div class="col-md-10 center" style="margin-top: 120px">
        <h1 class="text-center"><i class="fa fa-undo fa-5x"></i></h1>
        <h1 class="text-xxl text-primary text-center">404</h1>
        <div class="text-center">
            <h3>Oups ! Quelque chose ne va pas.</h3>
            <p class="text-md">Nous ne pouvons pas trouver ce que vous demandez !</p>
            <p class="text-md">Retour à <a href="<?= App::url(''); ?>">l'accueil</a>.</p>
        </div>
        <p class="text-center text-sm" style="margin-top: 50px">2020 &copy; Plumers par <a href="mailto:ndjeunousteve@yahoo.fr">Ndjeunou Steve</a></p>
    </div>
</div>