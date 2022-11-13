<?php
//получаем с формы, проверяем валидность
if (!empty($_POST['login']) && !empty($_POST['password'])) {

    $login = $_POST['login'];
    $password = $_POST['password'];

    $xml = simplexml_load_file('db_user.xml'); //чтение файла xml
    $objJsonDocument = json_encode($xml); //перевод в json
    $arr = json_decode($objJsonDocument, TRUE); //декодируем json для получения массива данных

    /* данный цикл возможно костыльный, но это первое что пришло в голову,
    чтобы вычислить индекс нужного элемента и дальнейшей работы с ним */
    for ($i = 0; $i < count($arr['user']); $i++) {
        if ($arr['user'][$i]['login'] == $login) {
            $index = $i;
        }
    }

    //если в нашей БД была найдена запись с таким логином и индекс получен, то начинаем сверку паролей
    if (!empty($index)) {
        $salt = $arr['user'][$index]['salt']; //получаем соль пользователя из БД
        $saltedPassword = md5($salt.$password); //шифруем пароль введенный с формы с солью из БД

        //и сравниваем полученное значение с паролем в БД
        if ($arr['user'][$index]['password'] == $saltedPassword) {
            //при совпадении открываем сессию, записываем показатель авторизации и логин пользователя
            session_start();
            $_SESSION['auth'] = true;
            $_SESSION['login'] = $arr['user'][$index]['login'];

            //подключаем файл с функцией генерации соли
            include_once('functions.php');
            $key = Salt(); //генерируем соль
            //записываем в куки login и key
            setcookie('login', $arr['user'][$index]['login'], time() + 60 * 60 * 24 * 30);
            setcookie('key', $key, time() + 60 * 60 * 24 * 30);
            //записываем в файл и сохраняем
            $xml->user[$index]->cookie = $key;

            $xml->saveXML('db_user.xml');
            echo '<h2>Hello, '.$arr['user'][$index]['name'].'</h2>'; //выводим приветствие
        } else {
            echo "<label id='error' class='text-danger'>Неверный пароль.</label>";
        }
    } else {
        echo "<label id='error' class='text-danger'>Такого логина не существует.</label>";
    }

} else {
    echo "<label id='error' class='text-danger'>Заполните ВСЕ поля.</label>";
}
