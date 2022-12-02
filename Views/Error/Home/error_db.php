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
        <h1 class="text-center"><i class="fa fa-server fa-5x"></i></h1>
        <h1 class="text-xxl text-primary text-center">501</h1>
        <div class="text-center">
            <h3>Oups ! Erreur de manipulation de données.</h3>
            <p class="text-md">Une erreur s'est produite au niveau du serveur !</p>
            <?php
            if(DEBUG_MODE==1&&!empty($message)){
                echo '<div class="alert alert-warning">'.$message.'</div>';
            }else{
                echo '<p class="text-md">Si cela persiste bien vouloir contacter l\'administrateur <a href="mailto:karylfreedomtchouta@gmail.com">contact@UsusUllamcorper</a>.</p>';
            }
            ?>
        </div>
        <p class="text-center text-sm" style="margin-top: 50px">2020 &copy; Usus Ullamcorper par <a href="mailto:karylfreedomtchouta@gmail.com">Tchouta Karyl & Zeufack Heriol</a></p>
    </div>
</div>