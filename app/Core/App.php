<?php


namespace Jman\Core;


class App
{

    /**
     * Returns a site base url
     * @return string
     */
    public static function getSiteURL(): string
    {
        $request = new AppRequest();
        return $request->getScheme() . '://' . $request->getHost();
    }

    /**
     * @param string $path
     * @param array $params
     * @return string
     */
    public static function createURL($path = '/', $params = [])
    {
        if (empty($params)) {
            return self::getSiteURL() . $path;
        } else {
            $query = http_build_query($params);
            return self::getSiteURL() . $path . '?' . $query;
        }
    }


    public static function updateURL($param = [])
    {

        $currentURL = App::getSiteURL() . $_SERVER['REDIRECT_URL'];


        if (empty($_SERVER['QUERY_STRING'])) {

            $query = http_build_query($param);
            return $currentURL . '?' . $query;

        } else {

            $queryString = $_SERVER['QUERY_STRING'];

            parse_str($queryString, $pparam);

            $allParams = array_merge($pparam, $param);

            $query = http_build_query($allParams);
            return $currentURL . '?' . $query;
        }
    }

    public static function redirect($path = '/', $params = [])
    {

        if (empty($params)) {
            header('Location:' . $path);
        } else {
            $query = http_build_query($params);
            header('Location:' . $path . '?' . $query);
        }


    }

    /**
     * @param $value
     * @return string
     */
    public static function toCurrencyString($value)
    {
        return sprintf("Rs. %s", number_format($value, 2));
    }

}