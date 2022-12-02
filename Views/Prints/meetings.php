<?php
/**
 * Created by PhpStorm.
 * User: DIKLA
 * Date: 03/06/2020
 * Time: 05:58
 */
use Projet\Database\users;
use Projet\Model\DateParser;
use Projet\Model\FileHelper;
use Projet\Database\affiliate_user;
use Projet\Database\affiliate_portfolio_profile;
use Projet\Model\StringHelper;


?>
<html>

<head>

    <style>

        /*

        PDF library using PHP have some limitations and all CSS properties may not support. Before Editing this file, Please create a backup, so that You can restore this.

        The location of this file is here- application/lib/invoices/pdf-x2.php

        */

        * {
            margin: 0;
            padding: 0;
        }

        body {
            /*

            Important: Do not Edit Font Name, Unless you are sure. It's required for PDF Rendering Properly

            */

            font: 13px/1.4 dejavusanscondensed;

            /*

            Font Name End

            */
        }

        #page-wrap {
            width: 90%;
            margin: 0 auto;
        }

        table {
            border-collapse: collapse;
        }

        table td, table th {
            border: 1px solid black;
            padding: 4px;
        }

        #customer {
            overflow: hidden;
        }

        #logo {
            text-align: right;
            float: right;
            position: relative;
            border: 1px solid #fff;
            max-width: 540px;
            overflow: hidden;
        }

        #meta {
            margin-top: 1px;
            width: 30%;
        }

        #meta td {
            text-align: left;
        }

        #meta td.meta-head {
            text-align: right;
            background: #eee;
        }

        #meta td textarea {
            width: 100%;
            height: 20px;
            text-align: right;
        }

        #items {
            clear: both;
            width: 100%;
            margin: 10px 0 0 0;
            border: 1px solid black;
        }

        #items th {
            background: #eee;
        }

        #items textarea {
            width: 80px;
            height: 50px;
        }

        #items tr.item-row td {
            vertical-align: top;
        }

        #items td.description {
            width: 300px;
        }

        #items td.item-name {
            width: 175px;
        }

        #items td.description textarea, #items td.item-name textarea {
            width: 100%;
        }

        #items td.total-line {
            border-right: 0;
            text-align: right;
        }

        #items td.total-value {
            border-left: 0;
            padding: 2px;
        }

        #items td.total-value textarea {
            height: 20px;
            background: none;
        }

        #items td.balance {
            background: #eee;
        }

        #items td.blank {
            border: 0;
        }

        #terms {
            text-align: left;
            margin: 10px 0 0 0;
        }

        #terms h5 {
            text-transform: uppercase;
            font: 13px <?php echo $config['pdf_font']; ?>;
            letter-spacing: 10px;
            border-bottom: 1px solid black;
            padding: 0 0 8px 0;
            margin: 0 0 8px 0;
        }

        #terms textarea {
            width: 100%;
            text-align: center;
        }
        .footer{
            margin: 1px;
            font-size: 9px;
            text-align: center;
        }
        td.noBorder{
            border: 0 solid #ffffff;
        }
        @page {
            footer: footer;
        }

    </style>

</head>
<body style="font-family:dejavusanscondensed">
<htmlpagefooter name="footer">
    <div class="" style="text-align: center; border-top: 2px dotted #ddd">
        <p class="footer">353 Rue St Jacques, St Jean Sur Richelieu, Canada</p>
        <p class="footer" style="margin-bottom: 10px">BP. : J3B 2L5 • Tél. : 51 42 29 01 59 • E-mail : contact@plumers.net • Web : https://www.plumers.net</p>
    </div>
</htmlpagefooter>
<sethtmlpagefooter name="footer" page="all" value="on" />

<div id="page-wrap">
    <table width="100%">
        <tr>
            <td style="border: 0;" width="50%">
                <b>Généré le <?= DateParser::DateShort(DATE_COURANTE,1); ?></b>
            </td>
            <td style="border: 0;text-align: right" width="50%">
                <div id="logo">
                    <img id="image" src="<?= FileHelper::url('assets/img/logo.png') ?>" style="height: 100px" alt="logo"/>
                </div>
            </td>
        </tr>
    </table>
    <div style="clear:both; margin-bottom: 0"></div>
    <table width="100%">
        <tr>
            <td style="border: 0;  text-align: left" width="100%" align="center">
                <span style="font-size: 18px; color: #2f4f4f"><u><b>LISTE DES RENDEZ-VOUS (<?= count($meetings); ?>)</b></u></span>
            </td>
        </tr>
    </table>
    <div id="customer" style="margin-top: 10px;margin-bottom: 10px">
        <table style="width: 45%" align="right">
            <?= $headerTab; ?>
        </table>
    </div>
    <table id="items">
        <tr>
            <th class="">Date</th>
            <th class="">Client</th>
            <th class="">Affilié</th>
            <th class="">Function</th>
            <th class="">Mode</th>
            <th class="">Statut</th>
            <th class="">Demandé le</th>
        </tr>
        <?php
        foreach ($meetings as $meeting) {
            $client = users::find($meeting->customer_id);
            $affilie = affiliate_user::byId($meeting->affiliate_id);
            $affilie_profile = affiliate_portfolio_profile::find($meeting->affiliate_id);
            echo
                '<tr>
                    <td class="">'.DateParser::DateShort($meeting->date.' '.$meeting->time,1).'</td>
                    <td class="text-info">'.$client->username.'</td>
                    <td class="text-primary">'.$affilie->username.'</td>
                    <td class="">'.$affilie_profile->category.'</td>
                    <td class="">'.StringHelper::$tabRdv[$meeting->mode_of_meeting].'</td>
                    <td class="">'.StringHelper::$tabEtatPrime[$meeting->status].'</td>
                    <td class="">'.DateParser::DateShort($meeting->created_date,1).'</td>
                </tr>
                ';
    }
        ?>
    </table>
</div>

</body>

</html> é