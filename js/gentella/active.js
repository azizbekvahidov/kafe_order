
// $(document).ready(function(){
var progress = 0;

/* construct manually */
var interval = setInterval(function () {
    if(progress <= 100) {
        var randNum = getRndInteger(progress, progress + 20);
        progress = randNum;
        loadBarProgress(progress);
    }
    else{

        clearInterval(interval);
        $(location).attr("href","/site/index");
    }
},2000);
function getRndInteger(min, max) {
    return Math.floor(Math.random() * (max - min) ) + min;
}

function loadBarProgress(progress) {
    var bar1 = new ldBar("#loadBar");
    /* ldBar stored in the element */
    var bar2 = document.getElementById('loadBar').ldBar;
    bar1.set(progress);
}

function sendData(postdata) {
    $.ajax({
        url: 'http://license.mostbyte.uz/api/saveData',
        type: 'POST',
        data: postdata,
        success: function(data){
            data = parseInt(data);
            if(data !== 0) {
                postdata.licenseId = data;
                console.log(postdata);
                $.ajax({
                    url: 'saveActive',
                    type: 'POST',
                    data: postdata,
                    success: function (data) {

                    }
                });
            }
            else {
                setTimeout(function () {
                    clearInterval(interval);
                    $("#loadBar").addClass('d-none');
                    $("#error").removeClass('d-none');
                    $("#error h1").html("Неверный ключ активации");
                    $("#error h2").html("Пожалуйста обратитесь администратору по номеру +998935193171 <br> и получите верный ключ. <br> Повторите попытку перейдя<a href='/configure/index'>  на страницу регистрации</a>");
                },12000);
            }
        },
        error: function (request,error) {
            setTimeout(function () {
                clearInterval(interval);
                $("#loadBar").addClass('d-none');
                $("#error").removeClass('d-none');
                $("#error h1").html("Сервер не отвечает");
                $("#error h2").html("Не удалось подключтьится к серверу, проверьте соединение !!! <br> Пожалуйста обратитесь администратору по номеру +998935193171 <br> Повторите попытку перейдя <a href='/configure/index'>на страницу регистрации</a>");
            },10000);
            console.log(error);
        }
    });
}


// });