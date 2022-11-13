<?php
/*
    в качестве проверки работы сессии и куки будет взята стартовая страница index.php,
    в зависимости от них будет загружаться либо страница приветствия либо отправлять на форму авторизации
*/

//проверяем по сессии авторизацию пользователя (для авторизованного [auth] = true)
if (empty($_SESSION['auth']) or $_SESSION['auth'] == false) {

    //проверяем на пустоту наши куки
    if (!empty($_COOKIE['login']) and !empty($_COOKIE['key'])) {
        //запишим полученные данные в переменные
        $login = $_COOKIE['login'];
        $key = $_COOKIE['key'];

        $xml = $xml = simplexml_load_file('db_user.xml');

        foreach ($xml as $user) {
            if ($user->login == $login && $user->cookie == $key) {
                $result = $user;
            }
        }

        //Если пара логин-куки была найдена и БД вернула результат
        if (!empty($result)) {
            //открываем сессию
            session_start();

            //записываем в сессию, что пользователь авторизован
            $_SESSION['auth'] = true;

            //а также его логин
            $_SESSION['login'] = strval($result->login);

            echo '<h2>Hello, '.strval($result->name).'</h2>'; //выводим приветствие
        }
    }else {
        header('Location: formAuthorization.php'); //перенаправляем на форму авторизации
    }
}


