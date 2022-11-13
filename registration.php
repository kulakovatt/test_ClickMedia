<?php
/*
    Насчет защиты от инъекций, в целом я обычно применяю, если работа с MySQL БД,
    то экранирование строк через mysqli_real_escape_string, также можно сделать подготовленные выражения
    через mysqli_prepare. Методов решения данной проблемы на самом деле множество.
    Конкретно для работы с xml все что могу предложить, это запретить символы тегов в полях формы <,/,>.
    С помощью regex ^[^</>]$
*/

//получаем данные с формы, проверяем на валидность
if ((!empty($_POST['login']) && preg_match('/^[^<>\/]*$/', $_POST['login']))
    && (!empty($_POST['password']) && preg_match('/^[^<>\/]*$/', $_POST['password']))
    && (!empty($_POST['confirm_password']) && preg_match('/^[^<>\/]*$/', $_POST['confirm_password']))
    && (!empty($_POST['email']) && preg_match('/^[^<>\/]*$/', $_POST['email']))
    && (!empty($_POST['name']) && preg_match('/^[^<>\/]*$/', $_POST['name']))) {

    $login = $_POST['login'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $name = $_POST['name'];

    $flag = 'good'; //переменная в качестве флага, как показатель успешного выполнения или с ошибками

    $xml = simplexml_load_file('db_user.xml'); //чтение xml файла

    //проверяем уникальность полей login и email
    foreach ($xml as $user) {
        if ($user->login == $login) {
            //выдаем ошибку
            $flag = 'error';
            echo "<label id='error' class='text-danger'>Данный логин уже занят.</label>";
        } elseif ($user->email == $email) {
            //выдаем ошибку
            $flag = 'error';
            echo "<label id='error' class='text-danger'>Данный email уже зарегистрирован.</label>";
        }
    }
    //проверяем совпадение пароля
    if ($password == $confirm_password) {
        include_once('functions.php');
        $salt = Salt(); //генерируем соль
        $saltedPassword = md5($salt.$password); //зашифрованный пароль

        //если ошибок нет, то создаем запись в xml файле
        if ($flag == 'good'){
            $newUser = $xml->addChild('user');
            $newUser->addChild('login', $login);
            $newUser->addChild('password', $saltedPassword);
            $newUser->addChild('email', $email);
            $newUser->addChild('name', $name);
            $newUser->addChild('salt', $salt);
            $newUser->addChild('cookie', '');

            $xml->saveXML('db_user.xml'); //записываем в файл и сохраняем

        }

    } else {
        echo "<label id='error' class='text-danger'>Пароли не совпадают.</label>";
    }

} else {
    echo "<label id='error' class='text-danger'>Заполните ВСЕ поля корректно.</label>";
}