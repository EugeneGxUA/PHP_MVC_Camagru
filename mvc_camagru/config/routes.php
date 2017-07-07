<?php
/**
 * Created by PhpStorm.
 * User: egaragul
 * Date: 5/5/17
 * Time: 20:03
 */

return array
(
    'mvc_camagru/autorization/activation/login-([a-zA-Z]+)/act-([a-zA-Z0-9]+)' => 'autorization/activation/$1/$2', //actionActivation в AutorizationController
    'mvc_camagru/autorization/change_pass/login-([a-zA-Z]+)/act-([a-zA-Z0-9]+)' => 'autorization/change_pass/$1/$2', //actionChange_pass в AutorizationController


    'mvc_camagru/autorization_login' => 'autorization/login', //actionLogin в AutorizationController
    'mvc_camagru/autorization_logout' => 'autorization/logout', //actionLogout в AutorizationController
    'mvc_camagru/autorization_signup' => 'autorization/signup', //actionSignUp в AutorizationController

    'mvc_camagru/forgot_pass' => 'autorization/forgot_pass', //actionForgot_pass в AutorizationController
    'mvc_camagru/autorization/do_change_pass' => 'autorization/do_change_pass', //actionChange_pass в AutorizationController
    'mvc_camagru/autorization_modify' => 'autorization/modify', //actionSignUp в AutorizationController
    'mvc_camagru/load_photo' => 'main/photo_load', //actionPhotoload в SiteController
    'mvc_camagru/gallery' => 'main/gallery', //actionIndex в SiteController
    'mvc_camagru/photo_room' => 'main/photoroom',
    'mvc_camagru/photo_like' => 'main/like',
    'mvc_camagru/for_likes' => 'main/take_like',
    'mvc_camagru/comment' => 'main/saveComment',

    'mvc_camagru' => 'site/index', //actionIndex в SiteController

);