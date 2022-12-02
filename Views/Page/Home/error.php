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
    <div class="col-md-4 center">
        <h1 class="text-xxl text-primary text-center">404</h1>
        <div class="details text-center">
            <h3>Oups ! Quelque chose ne va pas</h3>
            <p>Nous ne pouvons pas trouver ce que vous demandez. Retour à <a href="<?= App::url(''); ?>">la page d'accueil</a></p>
        </div>
        <form class="input-group" method="post" action="#">
            <input type="text" class="form-control" placeholder="Chercher quelque chose ici...">
            <span class="input-group-btn">
                <button class="btn btn-default"><i class="fa fa-search"></i></button>
            </span>
        </form>
    </div>
</div>