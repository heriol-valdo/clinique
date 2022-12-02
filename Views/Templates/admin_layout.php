<?php

use Projet\Model\App;
use Projet\Model\FileHelper;
use Projet\Model\Privilege;
use Projet\Model\Session;
use Projet\Model\StringHelper;

$session = Session::getInstance();
$page = substr(explode('?',$_SERVER["REQUEST_URI"])[0],1);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no"/>
    <link rel="icon" type="image/png" href="<?= FileHelper::url('assets/img/logo.png') ?>" sizes="16x16">
    <link rel="icon" type="image/png" href="<?= FileHelper::url('assets/img/logo.png') ?>" sizes="32x32">

    <title><?= App::getTitle(); ?></title>

    <?php
    App::addStyle("assets/plugins/pace-master/themes/blue/pace-theme-flash.css",true, true);
    App::addStyle("assets/plugins/uniform/css/uniform.default.min.css",true, true);
    App::addStyle("assets/plugins/bootstrap/css/bootstrap.min.css",true, true);
    App::addStyle("assets/plugins/fontawesome/css/font-awesome.css",true, true);
    App::addStyle("assets/plugins/line-icons/simple-line-icons.css",true, true);
    App::addStyle("assets/plugins/offcanvasmenueffects/css/menu_cornerbox.css",true, true);
    App::addStyle("assets/plugins/waves/waves.min.css",true, true);
    App::addStyle("assets/plugins/switchery/switchery.min.css",true, true);
    App::addStyle("assets/plugins/3d-bold-navigation/css/style.css",true, true);
    App::addStyle("assets/plugins/slidepushmenus/css/component.css",true, true);
    App::addStyle("assets/plugins/weather-icons-master/css/weather-icons.min.css",true, true);
    App::addStyle("assets/plugins/toastr/toastr.min.css",true, true);
    App::addStyle('assets/plugins/summernote-master/summernote.css',true);

    App::addStyle("assets/css/waitMe.min.css",true, true);
    App::addStyle("assets/css/modern.min.css",true, true);
    App::addStyle("assets/css/themes/green.css",true, true);
    App::addStyle("assets/css/sweetalert.css",true, true);
    App::addStyle("assets/css/custom.css",true, true);
    App::addStyle("assets/plugins/bootstrap-datepicker/css/datepicker3.css",true, true);
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
    <div class="overlay"></div>
    <div class="menu-wrap">
        <button class="close-button" id="close-button">Close Menu</button>
    </div>
    <form class="search-form" action="#" method="post">
        <div class="input-group">
            <input type="text" name="search" class="form-control search-input" placeholder="Chercher...">
            <span class="input-group-btn">
                <button class="btn btn-default close-search waves-effect waves-button waves-classic" type="button"><i class="fa fa-times"></i></button>
            </span>
        </div>
    </form>
    <main class="page-content content-wrap">
        <div class="navbar">
            <div class="navbar-inner">
                <div class="sidebar-pusher">
                    <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
                <div class="logo-box" style="background: #00008B;">
                    <a href="<?= App::url('home') ?>" class="logo-text" style="color: #FFF;font-size: 20px">
                        <b>SGSH</b>
                    </a>
                </div>
                <div class="search-button">
                    <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a>
                </div>
                <div class="topmenu-outer">
                    <div class="top-menu">
                        <ul class="nav navbar-nav navbar-left">
                            <li>
                                <a href="javascript:void(0);" class="waves-effect waves-button waves-classic sidebar-toggle"><i class="fa fa-bars"></i></a>
                            </li>
                            <li>
                                <a href="#cd-nav" class="waves-effect waves-button waves-classic cd-nav-trigger"><i class="fa fa-diamond"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect waves-button waves-classic toggle-fullscreen"><i class="fa fa-expand"></i></a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                                    <img class="img-circle avatar" src="<?= FileHelper::url($user->photo) ?>" width="40" height="40" alt="">
                                    <span class="user-name"><?= $user->nom; ?><i class="fa fa-angle-down"></i></span>
                                </a>
                                <ul class="dropdown-menu dropdown-list" role="menu">
                                    <li role="presentation"><a href="<?= App::url('password') ?>"><i class="fa fa-lock"></i>Mot de passe</a></li>
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation"><a href="<?= App::url('logout') ?>"><i class="fa fa-sign-out m-r-xs"></i>Déconnexion</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-sidebar sidebar">
            <div class="page-sidebar-inner slimscroll">
                <div class="sidebar-header">
                    <div class="sidebar-profile">
                        <a href="javascript:void(0);" id="profile-menu-link">
                            <div class="sidebar-profile-image">
                                <img src="<?= FileHelper::url('assets/img/logo.png') ?>" class="" >
                            </div>

                        </a>
                    </div>
                </div>
                <ul class="menu accordion-menu">
                    <?php if(Privilege::canView(Privilege::$eshopDashboardView,$user->privilege)){ ?>
                        <li<?= $page=='home'?' class="active"':''; ?>>
                            <a href="<?= App::url('home') ?>" class="waves-effect waves-button">
                                <span class="menu-icon glyphicon glyphicon-home"></span>
                                <p>Tableau de bord</p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if(Privilege::canView(Privilege::$eshopProductView,$user->privilege)||Privilege::canView(Privilege::$eshopProductDealView,$user->privilege)
                        ||Privilege::canView(Privilege::$eshopProductCatView,$user->privilege)||Privilege::canView(Privilege::$eshopProductSubCatView,$user->privilege)){ ?>
                        <li class="droplink<?= $page=='hospitalisations'||$page=='salles'||$page=='patients'?' active open':''; ?>">
                            <a href="javascript:void(0);" class="waves-effect waves-button">
                                <span class="menu-icon icon-bag"></span>
                                <p>Hospitalisation</p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <?php if(Privilege::canView(Privilege::$eshopProductCatView,$user->privilege)){ ?>
                                    <li<?= $page=='hospitalisations'?' class="active"':'hospitalisations'; ?>>
                                        <a href="<?= App::url('hospitalisations') ?>" class="waves-effect waves-button">
                                            listes
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if(Privilege::canView(Privilege::$eshopProductView,$user->privilege)){ ?>
                                    <li<?= $page=='patients'?' class="active"':'patients'; ?>>
                                        <a href="<?= App::url('patients') ?>" class="waves-effect waves-button">
                                            Patients
                                        </a>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if(Privilege::canView(Privilege::$eshopProductDealView,$user->privilege)){ ?>
                                    <li<?= $page=='salles'?' class="active"':'salles'; ?>>
                                        <a href="<?= App::url('salles') ?>" class="waves-effect waves-button">
                                            Salles
                                        </a>
                                    </li>
                                <?php } ?>

                            </ul>
                        </li>
                    <?php } ?>
                    <?php if(Privilege::canView(Privilege::$eshopProjectClientView,$user->privilege)||
                        Privilege::canView(Privilege::$eshopProjectAffileView,$user->privilege)){ ?>
                        <li class="droplink<?= $page=='projets/clients'||$page=='projets/affilies'?' active open':''; ?>">
                            <a href="javascript:void(0);" class="waves-effect waves-button">
                                <span class="menu-icon icon-plus"></span>
                                <p>Pharmacie</p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <?php if(Privilege::canView(Privilege::$eshopProjectAffileView,$user->privilege)){ ?>
                                    <li<?= $page=='projets/affilies'?' class="active"':''; ?>>
                                        <a href="<?= App::url('projets/affilies') ?>" class="waves-effect waves-button">
                                            Liste
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if(Privilege::canView(Privilege::$eshopProjectAffileView,$user->privilege)){ ?>
                                    <li<?= $page=='projets/affilies'?' class="active"':''; ?>>
                                        <a href="<?= App::url('projets/affilies') ?>" class="waves-effect waves-button">
                                            Facture
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if(Privilege::canView(Privilege::$eshopProjectClientView,$user->privilege)){ ?>
                                    <li<?= $page=='projets/clients'?' class="active"':''; ?>>
                                        <a href="<?= App::url('projets/clients') ?>" class="waves-effect waves-button">
                                           Medicaments
                                        </a>
                                    </li>
                                <?php } ?>

                            </ul>
                        </li>
                    <?php } ?>
                    <?php if(Privilege::canView(Privilege::$eshopAdminView,$user->privilege)||Privilege::canView(Privilege::$eshopGestionProfils,$user->privilege)){ ?>
                        <li class="droplink<?= $page=='admins'||$page=='profiles'?' active open':''; ?>">
                            <a href="javascript:void(0);" class="waves-effect waves-button">
                                <span class="menu-icon fa fa-user-secret"></span>
                                <p>Administration</p>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <?php if(Privilege::canView(Privilege::$eshopAdminView,$user->privilege)){ ?>
                                    <li<?= $page=='admins'?' class="active"':''; ?>>
                                        <a href="<?= App::url('admins') ?>" class="waves-effect waves-button">
                                            Administrateurs
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if(Privilege::canView(Privilege::$eshopGestionProfils,$user->privilege)){ ?>
                                    <li<?= $page=='profiles'?' class="active"':''; ?>>
                                        <a href="<?= App::url('profiles') ?>" class="waves-effect waves-button">
                                            Profils d'administration
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="page-inner">
            <div class="page-title">
                <h3><?= App::getNavigation(); ?></h3>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <?= App::getBreadcumb(); ?>
                    </ol>
                </div>
            </div>
            <div id="main-wrapper">
                <?php
                if (isset($_SESSION['success'])) {
                    echo '<div class="alert alert-success alert-dismissible text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><span class="alertJss">' . $session->read('success') . '</span></div>';
                    $session->delete('success');
                }
                if (isset($_SESSION['danger'])) {
                    echo '<div class="alert alert-danger alert-dismissible text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><span class="alertJs">' . $session->read('danger') . '</span></div>';
                    $session->delete('danger');
                }
                echo '<div class="alerter alert alert-success alert-dismissible text-center hide" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><span class="alertJsText">' . $session->read('success') . '</span></div>';
                echo $content;
                ?>
            </div>
            <div class="page-footer">
                <p class="no-s">2020 &copy; Usus Ullamcorper par <a href="mailto:karylfreedomtchouta@gmail.com">Tchouta Karyl & Zeufack Heriol </a>.</p>
            </div>
        </div>
    </main>
    <div class="cd-overlay"></div>

<?php
App::addScript("assets/plugins/jquery/jquery-2.1.4.min.js",true, true);
App::addScript("assets/plugins/jquery-ui/jquery-ui.min.js",true, true);
App::addScript("assets/plugins/pace-master/pace.min.js",true, true);
App::addScript("assets/plugins/jquery-blockui/jquery.blockui.js",true, true);
App::addScript("assets/plugins/bootstrap/js/bootstrap.min.js",true, true);
App::addScript("assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js",true, true);
App::addScript("assets/plugins/switchery/switchery.min.js",true, true);
App::addScript("assets/plugins/uniform/jquery.uniform.min.js",true, true);
App::addScript("assets/plugins/offcanvasmenueffects/js/classie.js",true, true);
App::addScript("assets/plugins/offcanvasmenueffects/js/main.js",true, true);
App::addScript("assets/plugins/waves/waves.min.js",true, true);
App::addScript("assets/plugins/3d-bold-navigation/js/main.js",true, true);
App::addScript("assets/plugins/waypoints/jquery.waypoints.min.js",true, true);
App::addScript("assets/plugins/jquery-counterup/jquery.counterup.min.js",true, true);
App::addScript("assets/js/sweetalert.min.js",true, true);
App::addScript("assets/js/waitMe.min.js",true, true);
App::addScript("assets/plugins/toastr/toastr.min.js",true, true);
App::addScript("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js",true, true);
App::addScript('assets/plugins/summernote-master/summernote.min.js',true);
App::addScript("assets/js/modern.min.js",true, true);
App::addScript("assets/js/inits.js",true, true);
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
