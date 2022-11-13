//функция для регистрации
function signUp(){
    let formData = $('#formRegist').serialize(); //получаем данные с формы и преобразуем в строку
    $.ajax({
        type: 'POST',
        url: 'registration.php',
        data: formData,
        success: function (data){
            $('.exception').html(data); //передаем с данные с файла обработчика (registration.php) и отображаем
        },
        error: function(xhr, str){
            alert("Возникла ошибка: "+ xhr.responseCode);
        }
    })
}

//функция для авторизации
function signIn(){
    let formData2 = $('#formAuth').serialize(); //получаем данные с формы и преобразуем в строку
    $.ajax({
        type: 'POST',
        url: 'authorization.php',
        data: formData2,
        success: function (data){
            $('.exception').html(data); //передаем с данные с файла обработчика (registration.php) и отображаем

            //в случае если ошибок не возникло, то скрываем форму и отображаем приветствие пользователя
            if (!$('.exception').children().is('#error')){
                $('#form').remove();
                $('.hello_user').html(data);
            }
        },
        error: function(xhr, str){
            alert("Возникла ошибка: "+ xhr.responseCode);
        }
    })
}