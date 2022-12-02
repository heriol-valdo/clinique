<?php
/**
 * Created by PhpStorm.
 * User: Ndjeunou
 * Date: 07/02/2017
 * Time: 21:12
 */

namespace Projet\Model;


class MenuHelper{
    
    public static function getSideBar(){
        $menu = '
        
            <aside class="sidebar marBot">
                <h5 class="heading-primary marNo">Espace</h5>
                <ul class="nav nav-list narrow">
                    <li class="active"><a href="<?= App::url(App::getDBAuth()->getPseudo()) ?>">Tableau de bord</a></li>
                    <li><a href="<?= App::url(App::getDBAuth()->getPseudo().\'/profil\') ?>">Profil</a></li>
                    <li><a href="<?= App::url(App::getDBAuth()->getPseudo().\'/profil/public\') ?>">Profil public</a></li>
                    <li><a href="<?= App::url(App::getDBAuth()->getPseudo().\'/preferences\') ?>">Mes préférences</a></li>
                </ul>
            </aside>
            <aside class="sidebar marBot">
                <h5 class="heading-primary marNo">Activité</h5>
                <ul class="nav nav-list narrow">
                    <li><a href="<?= App::url(App::getDBAuth()->getPseudo().\'/annonces\') ?>">Mes annonces</a></li>
                    <li><a href="<?= App::url(App::getDBAuth()->getPseudo().\'/reservations\') ?>">Reservations</a></li>
                    <li><a href="<?= App::url(App::getDBAuth()->getPseudo().\'/messages\') ?>">Messages</a></li>
                </ul>
            </aside>
            <aside class="sidebar marBot">
                <h5 class="heading-primary marNo">Outils</h5>
                <ul class="nav nav-list narrow">
                    <li><a href="<?= App::url(App::getDBAuth()->getPseudo().\'/avis\') ?>">Alertes</a></li>
                    <li><a href="<?= App::url(App::getDBAuth()->getPseudo().\'/avis\') ?>">Véhicules</a></li>
                    <li><a href="<?= App::url(App::getDBAuth()->getPseudo().\'/avis\') ?>">Avis</a></li>
                </ul>
            </aside>
        
        ';
        
        return $menu;
    }

}