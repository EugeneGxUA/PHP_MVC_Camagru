<?php


class SiteController
{
    public function actionIndex()
    {
        require_once (ROOT.'/views/main.php');

        return True;
    }

}