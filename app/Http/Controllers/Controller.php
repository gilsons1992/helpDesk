<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public static function zero($valor) {
        return $valor ? Controller::valorFloat($valor) : 0;
    }

    public static function zeroMoeda($valor) {
        return $valor ? Controller::valorMoeda($valor) : 0;
    }

    public static function x(...$var) {

        echo '<pre>';
        foreach($var as $v) {
            print_r($v);
        }
        '</pre>';
    }

    public static function xd(...$var) {
        Controller::x($var);
        die();
    }

    public static function valorMoeda($valor)
    {
        $prefixoMoeda = 'R$';

        $valor = str_replace($prefixoMoeda . ' ', '', $valor);
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);

        return floatval($valor);
    }

    public static function valorFloat($valor)
    {
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);

        return floatval($valor);
    }

    public static function setCookie($obj, $name, $content) {
        $cookieFullName = get_class($obj).$name;
        setcookie($cookieFullName, $content);
    }

    public static function getCookie($obj, $name) {
        $cookieFullName = get_class($obj).$name;
        if (isset($_COOKIE[$cookieFullName])) {
            return $_COOKIE[$cookieFullName];
        }
        return null;
    }

}
