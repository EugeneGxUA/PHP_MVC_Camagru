<?php

/**
 * Created by PhpStorm.
 * User: egaragul
 * Date: 5/12/17
 * Time: 18:39
 */

include_once ROOT . '/models/Model_main.php';
class MainController
{
    public function actionPhoto_load()
    {
        if (Model_main::do_load($_POST['photo'], $_POST['frame']) == TRUE)
        {
            $load_ok = TRUE;
        }

        include_once ROOT.'/views/main.php';

        return True;
    }

    public function actionPhotoroom()
    {

        include_once ROOT.'/views/body/photo_room.php';

        return True;
    }

    public function actionLike()
    {
        if (Model_main::like($_POST['photo']) == TRUE)
        {
            return TRUE;
        }
        //include_once ROOT.'/views/main.php';

        return True;
    }

    public function actionTake_like()
    {
        Model_main::take_like($_POST['photo']);

        return (TRUE);
    }

    public function actionSaveComment()
    {
        Model_main::save_comment($_POST['comment'], $_POST['photo_src']);

        return (TRUE);
    }
}