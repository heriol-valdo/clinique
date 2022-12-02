<?php

use Projet\Model\App;
$auth = App::getDBAuth();
App::setTitle("Se connecter");
?>
<div id="bg-overlay"></div>
<div class="cls-content">
    <div class="cls-content-sm panel">
        <div class="panel-body">
            <div class="mar-ver pad-btm">
                <h3 class="h4 mar-no">Aaron Chavez</h3>
                <span class="text-muted">Administrator</span>
            </div>
            <div class="pad-btm mar-btm">
                <img alt="Profile Picture" class="img-lg img-circle img-border-light" src="Public/img/profile-photos/1.png">
            </div>
            <p>Please enter your password to unlock the screen!</p>
            <form action="#" id="lockForm" method="post">
                <div class="form-group">
                    <input class="form-control" id="password" placeholder="Password" type="password">
                </div>
                <div class="form-group text-right">
                    <button class="btn btn-block btn-success" id="sendBtn" type="submit">Login In</button>
                </div>
            </form>
            <div class="pad-ver">
                <a href="/" class="btn-link mar-rgt">Sign in using different account</a>
            </div>
        </div>
    </div>
</div>