<?php
/**
 * Created by PhpStorm.
 * User: Ndjeunou
 * Date: 29/10/2016
 * Time: 12:39
 */
return
    [

        ""=>'\Projet\Controller\Page\AuthController#login',
        "ajax/log"=>'\Projet\Controller\Page\HomeController#log',
        "error"=>'\Projet\Controller\Error\HomeController#error',
        "error_db"=>'\Projet\Controller\Error\HomeController#error_db',
        "unauthorize"=>'\Projet\Controller\Error\HomeController#unauthorize',
        "expired"=>'\Projet\Controller\Error\HomeController#expired',
        "logout"=>'\Projet\Controller\Page\HomeController#logout',

        "users/pdf"=>'\Projet\Controller\Admin\StatsController#users',
        "users/excell"=>'\Projet\Controller\Admin\StatsController#usersExcell',

        "home"=>'\Projet\Controller\Admin\HomeController#index',
        "home/charts"=>'\Projet\Controller\Admin\HomeController#charts',
        "home/loader"=>'\Projet\Controller\Admin\HomeController#load',
        "loader"=>'\Projet\Controller\Admin\HomeController#loader',
        "password"=>'\Projet\Controller\Admin\HomeController#password',
        "password/change"=>'\Projet\Controller\Admin\HomeController#changePassword',

        "admins"=>'\Projet\Controller\Admin\AdminsController#index',
        "admins/save"=>'\Projet\Controller\Admin\AdminsController#save',
        "admins/activate"=>'\Projet\Controller\Admin\AdminsController#delete',
        "admins/reset"=>'\Projet\Controller\Admin\AdminsController#reset',
        "admins/setPhoto"=>'\Projet\Controller\Admin\AdminsController#setPhoto',



        "profiles" => '\Projet\Controller\Admin\ProfileController#index',
        "profiles/delete" => '\Projet\Controller\Admin\ProfileController#delete',
        "profiles/save" => '\Projet\Controller\Admin\ProfileController#save',


        "salles"=>'\Projet\Controller\Hospitalisation\SalleController#index',
        "salle/save"=>'\Projet\Controller\Hospitalisation\SalleController#save',
        "salle/delete"=>'\Projet\Controller\Hospitalisation\SalleController#delete',
        "salle/pdf"=>'\Projet\Controller\Admin\StatsController#salles',
        "salle/excell"=>'\Projet\Controller\Admin\StatsController#sallesExcell',

        "patients"=>'\Projet\Controller\Hospitalisation\PatientController#index',
        "patient/save"=>'\Projet\Controller\Hospitalisation\PatientController#save',
        "patient/delete"=>'\Projet\Controller\Hospitalisation\PatientController#delete',
        "patient/pdf"=>'\Projet\Controller\Admin\StatsController#patients',
        "patient/excell"=>'\Projet\Controller\Admin\StatsController#patientsExcell',

        "hospitalisations"=>'\Projet\Controller\Hospitalisation\HospitalisationController#index',
        "hospitalisation/save"=>'\Projet\Controller\Hospitalisation\HospitalisationController#save',
        "hospitalisation/delete"=>'\Projet\Controller\Hospitalisation\HospitalisationController#delete',
        "hospitalisation/setetat"=>'\Projet\Controller\Hospitalisation\HospitalisationController#setetat',
    ];
