<?php

/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<div id="loginDiv">
    <div id="logo" ><?=Yii::app()->config->get("name") ?>
    </div>
    <div class="main-container page-login">
        <div class="content-wrapper">

            <div class="inputs">
                <div class="input empty"><input disabled="" type="password" /></div>

                <div class="justify-dummy"></div>
            </div>

            <div class="buttons">
                <button class="digit num1">1</button>
                <button class="digit num2">2</button>
                <button class="digit num3">3</button>
                <button class="digit num4">4</button>
                <button class="digit num5">5</button>
                <button class="digit num6">6</button>
                <button class="digit num7">7</button>
                <button class="digit num8">8</button>
                <button class="digit num9">9</button>

                <button class="clear">Удалить</button>
                <button class="digit num0">0</button>
                <button class="backspace"><i class="fa fa-chevron-left"></i></button>

                <div class="justify-dummy"></div>
            </div>
        </div>
    </div>

    <script>
        var userData;
        var expId;
        var tables;
        var people;
        var shifted = false;
        $(document).ready(function(){

            document.onkeyup = function (e) {
                e = e || window.event;

                console.log(shifted);
                if(shifted === false) {
                    if (e.keyCode === 16) {
                        shifted = true;
                    }
                    if (e.keyCode === 96) {
                        $(".num0.digit").click();
                    }
                    if (e.keyCode === 97) {
                        $(".num1.digit").click();
                    }
                    if (e.keyCode === 98) {
                        $(".num2.digit").click();
                    }
                    if (e.keyCode === 99) {
                        $(".num3.digit").click();
                    }
                    if (e.keyCode === 100) {
                        $(".num4.digit").click();
                    }
                    if (e.keyCode === 101) {
                        $(".num5.digit").click();
                    }
                    if (e.keyCode === 102) {
                        $(".num6.digit").click();
                    }
                    if (e.keyCode === 103) {
                        $(".num7.digit").click();
                    }
                    if (e.keyCode === 104) {
                        $(".num8.digit").click();
                    }
                    if (e.keyCode === 105) {
                        $(".num9.digit").click();
                    }
                    if (e.keyCode === 48) {
                        $(".num0.digit").click();
                    }
                    if (e.keyCode === 49) {
                        $(".num1.digit").click();
                    }
                    if (e.keyCode === 50) {
                        $(".num2.digit").click();
                    }
                    if (e.keyCode === 51) {
                        $(".num3.digit").click();
                    }
                    if (e.keyCode === 52) {
                        $(".num4.digit").click();
                    }
                    if (e.keyCode === 53) {
                        $(".num5.digit").click();
                    }
                    if (e.keyCode === 54) {
                        $(".num6.digit").click();
                    }
                    if (e.keyCode === 55) {
                        $(".num7.digit").click();
                    }
                    if (e.keyCode === 56) {
                        $(".num8.digit").click();
                    }
                    if (e.keyCode === 57) {
                        $(".num9.digit").click();
                    }
                }
                else{
                    shifted = false;
                }
                // if (e.keyCode === 13) {
                //     $("#submitBtn").click();
                // }

                // Отменяем действие браузера
                return false;
            };
            $('.digit').click(function(){
                var emptyVal = $('.empty input').val();
                if($('.empty input').val().length != 4){
                    $('.empty input').val(emptyVal+$(this).text());
                }
            });
            setInterval(function(){
                if($('.empty input').val().length == 4){
                    $('.tableBtn').removeClass('actived disabled');
                    $.ajax({
                        type: "POST",
                        url: "<?php echo Yii::app()->createUrl('expense/login'); ?>",
                        data: 'pass='+$('.empty input').val(),
                        success: function(data){
                            if(data != 'false'){
                                userData = JSON.parse(data);
                                $('.empty input').val('');
                                $('#loginDiv').css('display','none');
                                $('#tablesDiv').css('display','block');
                                $('.logout').text(userData.name);
                                if(userData.check_percent == 0){
                                        $(".self").removeClass("hide");
                                        $(".zal").addClass("hide");
                                }
                                else{
                                    $(".zal").removeClass("hide");
                                    $(".self").addClass("hide");
                                }
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo Yii::app()->createUrl('expense/tables'); ?>",
                                    success: function(data){
                                        data = JSON.parse(data);
                                        $.each(data, function(i, b) {

                                            if(b.employee_id == userData.employee_id){
                                                var tableClass = ".table-"+ b.table;
                                                $(tableClass).addClass('actived');
                                            }
                                            else{
                                                var tableClass = ".table-"+ b.table;
                                                //$(tableClass).addClass('disabled');
                                            }
                                        });
                                    }
                                });
                            }
                            else{
                                setTimeout(function() { $('.page-login > div').attr('class','content-wrapper') }, 500);
                                $('.page-login > div').attr('class','content-wrapper shake');
                                $('.empty input').val('');
                            }

                        }
                    });
                }
            },1000)

            $('.backspace').click(function(){
                var str = $('.empty input').val();
                str = str.slice(0,-1);
                $('.empty input').val(str);
            });
            $('.clear').click(function(){
                $('.empty input').val('');
            })
        });
    </script>
</div>
<style>
    #dropdown-wrap .modal-content{
        max-height: 200px;
        overflow-y: scroll;
    }
    #dropdown-wrap .modal-content ul{
        padding: 0;
    }
    #dropdown-wrap .modal-content li{
        list-style: none;
        height: 44px;
        cursor: pointer;
        border-bottom: 1px solid #ccc;
        padding: 11px 0px 11px 20px;
        vertical-align: middle;
    }
    #dropdown-wrap .modal-content li.list-title{
        list-style: none;
        font-size: 15px;
        font-weight: bold;
    }
    #dropdown-wrap .modal-content li:hover{
        background: #ececec;
    }
</style>

<div id="tablesDiv">
    <div class="col-md-12">
        <div class="tables">
            <div class="zal">
                <div class="col-md-2" style="position: absolute; top: -35%; right: -3%;">
                    <a class="costsBtn"  data-toggle="modal" data-target="#costs" href="#">
                        Расходы
                    </a>
                </div>
        <? $cnt = 1;
            foreach ($table as $val) { ?>
                <div class="col-md-2">
                    <a class="tableBtn table-<?= $val['table_num'] ?>" data-toggle="modal"
                       data-target=".bs-example-modal-sm" href="#">
                        <?= $val['table_num'] ?>
                    </a>
                </div>
                <? $cnt++;
            }
            ?>
            </div>
            <div class="self hide">
                <div class="col-md-2">
                    <a class="tableBtn table-0" data-toggle="modal"
                       data-target=".bs-example-modal-sm" href="#">
                        <?=0?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script>
        function checkTables(tables,newOrder){

            if(newOrder == null){
                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->createUrl('expense/checkTable'); ?>",
                    data: 'table='+tables+"&user="+userData.employee_id,
                    success: function(data) {
                      var htmlText = '<ul>';
                            data = JSON.parse(data);
                            if(data.people){
                              htmlText += '<li class="list-title">Кол-во гостей</li>';
                              $.each(data.people, function(i, b) {
                                htmlText += '<li data-count="'+b+'" data-type="people" class="ordering">'+b+'</li>';
                              });
                            }
                            if(data.expense){
                              $.each(data.expense, function(i, b) {
                                var times = b.order_date.split(' ');
                                 htmlText += '<li data-count="'+b.expense_id+'" data-type="expense" class="ordering">'+b.pCount+' &nbsp; &nbsp; &nbsp; '+times[1]+'</li>';
                              });
                              htmlText += '<li class="newOrder">Новый заказ</li>';
                            }
                        htmlText += "</ul>";
                        $('#dropdown-wrap .modal-content').html(htmlText);
                    }
                });
            }
            else{
              $.ajax({
                  type: "POST",
                  url: "<?php echo Yii::app()->createUrl('expense/checkTable'); ?>",
                  data: 'table='+tables+"&user="+userData.employee_id+"&newOrder=0",
                  success: function(data) {
                    var htmlText = '<ul>'
                          data = JSON.parse(data);
                            htmlText += '<li class="list-title">Кол-во гостей</li>'
                            $.each(data.people, function(i, b) {
                              htmlText += '<li data-count="'+b+'" data-type="people" class="ordering">'+b+'</li>';
                            });

                      htmlText += "</ul>";
                      $('#dropdown-wrap .modal-content').html(htmlText);
                  }
              });
            }
        }
        $(document).ready(function(){
            $(document).on('click','.tableBtn',function(){
                tables = parseInt($(this).text());
                $('#tableNum span').text(tables);
                checkTables(tables);

            });
            $(document).on('click','.ordering', function(){
                var dataType = $(this).attr('data-type');
                var dataCount = $(this).attr('data-count');
                if(dataType == 'people'){
                    people = dataCount  ;
                    $("#dropdown-wrap").modal('hide');
                    $.ajax({
                        type: "POST",
                        url: "<?php echo Yii::app()->createUrl('expense/orders'); ?>",
                        data: 'table='+tables+"&user="+userData.employee_id,
                        success: function(data) {
                            $("#dataTable").html(data);
                        }
                    });

                    $('#tablesDiv').css('display','none');
                    $('#createDiv').css('display','block');
                }
                if(dataType == 'expense'){
                      expenses = dataCount  ;
                      $("#dropdown-wrap").modal('hide');
                      $.ajax({
                          type: "POST",
                          url: "<?php echo Yii::app()->createUrl('expense/orders'); ?>",
                          data: 'expense='+expenses+"&user="+userData.employee_id,
                          success: function(data) {
                              $("#dataTable").html(data);
                          }
                      });

                      $('#tablesDiv').css('display','none');
                      $('#createDiv').css('display','block');
                }
                setTimeout('getSum()', 1000);

            });
            $(document).on('click','.newOrder', function(){
                checkTables(tables,'newOrder');
            });
        });
//        function putOrder(data){
//            data = JSON.parse(data);
//            var summ = 0;
//            var htmlText ='<thead> \
//                                  <tr>\
//                                  <th id="all" class=" col-sm-1"><a class="btn all">Все</a></th>\
//                                      <th id="ordName" class="col-sm-6">Наименование';
//            if(data.status != false){
//                expId = data.model.expense_id;
//                htmlText += '<input style="display:none" name="action" id="action" value="update">';
//            }else{
//                expId = 0;
//                htmlText += '<input style="display:none" name="action" id="action" value="create">';
//            }
//            alert(expId);
//            htmlText += '</th>\
//                                        <th id="ordPrice" class="col-sm-2">Цена</th>\
//                                        <th id="ordCount" class="col-sm-3">Кол-во</th>\
//                                    </tr>\
//                                </thead>\
//                                <tbody id="order">';
//            if(data.status != false){
//                if(data.order != null){
//                    console.log("putList")
//                    $.each(data.order, function(i, b) {
//                        var prices;
//                        getPrice(b.just_id,data.model.mType,b.type,data.model.order_date);
//                        htmlText += '<tr class="dish_'+b.just_id+'">\
//                                                    <td>\
//                                                        <a type="button" class="removed btn">\
//                                                            <i class="fa fa-times"></i>\
//                                                        </a>\
//                                                        <input style="display:none" name="id[]" value="dish_'+b.just_id+'">\
//                                                    </td>\
//                                                    <td>'+b.name+'</td>\
//                                                    <td class="dishPrice_'+b.just_id+'">'+ prices+'</td>\
//                                                    <td class="cnt">\
//                                                        <input name="count[]" style="display:none" value="'+b.count+'">\
//                                                        <a type="button" class="pluss btn">\
//                                                            <i class="fa fa-plus"></i>\
//                                                        </a>\
//                                                        <span>'+b.count+'</span>\
//                                                        <a type="button" class="minus btn">\
//                                                            <i class="fa fa-minus"></i>\
//                                                        </a>\
//                                                    </td>\
//                                                </tr>';
//                    });
//                }
//
//                if(data.order2 != null){
//                    $.each(data.order2, function(i, b) {
//                        var prices = getPrice(b.just_id,data.model.mType,b.type,data.model.order_date);
//                        htmlText += '<tr class="stuff_'+b.just_id+'">\
//                                                <td>\
//                                                    <a type="button" class="removed btn">\
//                                                        <i class="fa fa-times"></i>\
//                                                    </a>\
//                                                    <input style="display:none" name="id[]" value="stuff_'+b.just_id+'">\
//                                                </td>\
//                                                <td>'+b.name+'</td>\
//                                                <td class="stuffPrice_'+b.just_id+'">'+ prices+'</td>\
//                                                <td class="cnt">\
//                                                <input name="count[]" style="display:none" value="'+b.count+'">\
//                                                    <a type="button" class="pluss btn">\
//                                                        <i class="fa fa-plus"></i>\
//                                                    </a>\
//                                                    <span>'+b.count+'</span>\
//                                                    <a type="button" class="minus btn">\
//                                                        <i class="fa fa-minus"></i>\
//                                                    </a>\
//                                                </td>\
//                                            </tr>';
//                    });
//                }
//
//                if(data.order3 != null){
//                    $.each(data.order3, function(i, b) {
//                        var prices = getPrice(b.just_id,data.model.mType,b.type,data.model.order_date);
//                        htmlText += '<tr class="product_'+b.just_id+'">\
//                                                <td>\
//                                                    <a type="button" class="removed btn">\
//                                                        <i class="fa fa-times"></i>\
//                                                    </a>\
//                                                    <input style="display:none" name="id[]" value="product_'+b.just_id+'">\
//                                                </td>\
//                                                <td>'+b.name+'</td>\
//                                                <td class="prodPrice_'+b.just_id+'">'+ prices+'</td>\
//                                                <td class="cnt">\
//                                                <input name="count[]" style="display:none" value="'+b.count+'">\
//                                                    <a type="button" class="pluss btn">\
//                                                        <i class="fa fa-plus"></i>\
//                                                    </a>\
//                                                    <span>'+b.count+'</span>\
//                                                    <a type="button" class="minus btn">\
//                                                        <i class="fa fa-minus"></i>\
//                                                    </a>\
//                                                </td>\
//                                            </tr>';
//                    });
//                }
//            }
//            htmlText += '</tbody>\
//                                <tfoot>\
//                                    <tr>\
//                                        <td colspan="2">Итого</td>\
//                                        <td colspan="2" id="summ">'+new Intl.NumberFormat('en-US', {maximumFractionDigits: 0}).format(summ/100)*100+'</td>\
//                                    </tr>\
//                                    <tr>\
//                                        <td class="text-center" colspan="4">';
//            if(data.status != false){
//                htmlText += '<a style="padding: 3px 5px;" href="/expense/printExpCheck?exp='+data.model.expense_id+'" type="button" name="button" class="btn btn-info expCheck">Напечатать счет</a>'+
//                '<a style="padding: 3px 5px;" href="#" onclick="closeExp('+data.model.expense_id+')" type="button" name="button" class="btn btn-info expClose">Закрыть счет</a>';
//                console.log(htmlText);
//            }
//            htmlText += '</td>\
//                                    </tr>\
//                                </tfoot>';
//            $("#dataTable").html(htmlText);
//        }
    </script>
</div>

<div id="createDiv">
    <form id='expense-form'>
    <? $menu = new Menu(); ?>

    <style>
        .removed{
            width: 100%;
            font-size: 140%;
            text-align: center;
            cursor: pointer;
        }
        .closedBtns{
            margin: 0 auto;
            width: 200px;
        }
        .modal {
        }
        body{
            font-size: 100%!important;
        }
        @media (max-width: 768px) {
            .thumbnail {
                font-size: 50%;
            }
        }
        .plus {
            cursor: pointer;
        }

        .thumbnail {
            font-size: 150%;
        }

        .sidebar {
            width: 16%;
            height: 670px;
        }
        .right-sidebar {
            height: 670px;
            z-index: 1;
            position: absolute;
            width: 27%;
            margin-top: 51px;
        }

        #page-wrappers {
            height: 670px;
            overflow-y: scroll;
            margin: 0 27% 0 16%;
            padding: 15px;
        }
        .fa{
            font-size: 100%;
        }

        .thumbnail {
            position: relative;
        }

        .texts {
            position: absolute;
            top: 3px;

        }

        #expense-form {
            margin-top: 0px;
        }

        .cnt {
            cursor: pointer;
        }

        .liStyle {
            list-style: none;
            border: none !important;
        }


        #dataTable td, th {
            padding: 4px !important;
        }

        #dataTable .btn {
            padding: 0;
        }

        #menuList a {
            padding: 10px 4px;
            font-size: 14px;
        }

        .topHead {
            position: absolute;
            z-index: 1000;
            overflow: visible;
            top: 1%;
            left: 20%;
        }

        #summ {
            color: red;
            font-weight: bold;
        }
        .submitDiv{
            bottom: 60px;
        }
        .btnPrint{
            display: none;
        }
        .chosen-container{
            width: 100%!important;
        }
        #tableNum{
            cursor: pointer;
        }
        .btnDigit .buttons button{
            border: 0;
            width: 55px;
            height: 55px;
            padding: 0;
            border-bottom: none;
            margin-bottom: 20px;
            font-size: 35px;
            font-weight: 200;
            line-height: 55px;
            text-align: center;
            color: #1d1d1d;
            border-radius: 4px;
            background: #f2f2f2;
        }
        .btnDigit{
            width: 200px;
            margin: 0 auto;
            padding-bottom: 0;
        }
        .btnDigit .buttons{
            text-align: justify;
        }

    </style>
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <!-- /.navbar-header -->
        <ul class="nav navbar-nav">
            <li><a href="javascript:;" id="toTable"><i class="fa fa-caret-left "></i> Столы</a></li>

        </ul>
        <ul class="nav navbar-nav pull-right" style="margin-right: 6%">
            <li><a href="javascript:;" class="logout">  </a></li>
            <li><a href="javascript:;"  id="close"><i class="fa fa-unlock-alt fa-2x hide"></i></a></li>
        </ul>

    </nav>
        <input id="tempPrice" type="text" class="hide" />
    <!-- /.navbar-top-links -->
    <div class="navbar-default sidebar" style="margin-top: 0;" role="navigation; overflow-x: scroll;">
        <div class="sidebar-nav tab-box">
            <ul class="nav nav-pills nav-stacked tab-nav" id="menuList">
                <? foreach($menuModel as $key => $value){
                    $subMenu = Dishtype::model()->findAll('t.parent = :parent',array(':parent'=>$value->type_id))
                    ?>
                    <li id="<?=$value->type_id?>">
                        <a href="javascript:;" class="types"><?=$value->name?><span style="float: right;" class="fa fa-angle-right"></span></a>
                        <ul><? foreach($subMenu as $val){?>
                                <li class="liStyle" id="<?=$val->type_id?>">
                                    <a href="javascript:;" class="types"><?=$val->name?><span style="float: right;" class="fa fa-angle-right"></span></a>
                                </li>
                            <? }?>
                        </ul>
                    </li>
                <? }?>

            </ul>

        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <div id="page-wrappers">
        <div class="col-xs-7 topHead">
            <div class="col-xs-3">

                <?=CHtml::button('Мои заказы',array('type'=>'button','class'=>'btn btn-info pull-right','id'=>'orders'))?>
            </div>
            <div class="col-xs-3" id="tableNum">
                <a href="javascript:;"  data-toggle="modal" id="curTables" data-target="#tableModal">Стол № <span></span></a>
                <?php// echo Chtml::dropDownList('Expense[table]','',$table,array('class'=>'form-control'))?> &nbsp; &nbsp;

            </div>
            <div class="col-xs-5">
                <div class='checkbox'>
                    <label for="" style='font-size:16px;'>
                        <input type="checkbox" name='banket' id='banket'> Банкет
                    </label>
                </div>
                <?//=CHtml::dropDownList('menuDrop','',$menu->getMenuList())?>
            </div>
        </div>
        <div class="tab-panels" id="data">

        </div>
    </div>
    <div class="navbar-default right-sidebar" style="right: 0; top: 0;">
        <div>
            <table class="table table-bordered table-fixed" id="dataTable">
                <thead>
                <tr>
                    <th id="all" class=" col-sm-1"><a class="btn all">Все</a></th>
                    <th id="ordName" class="col-sm-7">Нименование</th>
                    <th id="ordPrice" class="col-sm-2">Цена</th>
                    <th id="ordCount" class="col-sm-2">Кол-во</th>
                </tr>
                </thead>
                <tbody id="order">

                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2">Итого</td>
                    <td colspan="2" id="summ">0</td>
                </tr>
                </tfoot>

            </table>
            <table>
                <tr>
                    <td>

                        <div class="form-actions pull-right submitDiv col-xs-12 " style="margin-top:45px;">
                            <button class="btn btn-success " id="submitBtn" type="button">Добавить</button>
                            <script src="/js/jquery.printPage.js"></script>
                            <?=CHtml::link('<i class="fa fa-print"></i>  Печать',array('/expense/printCheck?id='.$id),array('class'=>'btn btnPrint'))?>

                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <?echo Chtml::textField('Expense[comment]','',array('style'=>'display:none'))?>
    </div>

    <script>
    var counts = [],
        temps,
        count;
    function str_split ( str, len ) {

        str = str.split('_');
        if ( !len ) { return str; }

        var r = [];
        for( var k=0;k<(str.length/len); k++ ) {
            r[k] = '';
        }
        for( var k in str ) {
            r[ Math.floor(k/len) ] += str[k];
        }
        return r;
    };
    $(document).ready(function(){
        $("#menuDrop").chosen({
            no_results_text: "Ничего не найдено"
        }).change(function(){
            var texts = $(this).find('option:selected').text();
            var thisId = $(this).val();
            var temps = str_split(texts,1);
            if($('#order tr.'+thisId).exists()){
                var types = str_split(thisId,1);
                var count = $('#order tr.'+thisId).children("td.cnt").children('input').val();
                count = parseFloat(count)+1;
                $('#order tr.'+thisId).children("td:first-child").children('input').val(types[1]);
                $('#order tr.'+thisId).children("td.cnt").children('input').val(count);
                $('#order tr.'+thisId).children("td.cnt").children('span').text(count);
            }
            else{
                var types = str_split(thisId,1);
                    $('#order').append("<tr class="+thisId+">\
                                    <td class='removed fa fa-times'>\
                                        <input style='display:none' name='id[]' value='"+thisId+"' />\
                                    </td>\
                                    <td>"+temps[0]+"</td>\
                                    <td>"+temps[1]+"</td>\
                                    <td class='cnt'>\
                                        <input name='count[]' style='display:none' value='1' />\
                                        <a type='button' class='pluss btn hide'>\
                                            <i class='fa fa-plus'></i>\
                                        </a>\
                                        <span>" +1+"</span>\
                                        <a type='button' class='minus btn hide'>\
                                            <i class='fa fa-minus'></i>\
                                        </a>\
                                    </td>\
                                </tr>");
            }
            getSum();
        });
        ion.sound({
            sounds: [
                {name: "bell_ring"},
                {name: "door_bell"}
            ],
            path: "/src/sounds/",
            preload: true,
            volume: 1.0
        });
    });
    // $(document).on('click','#curTables', function(){
    //     $.ajax({
    //         type: "POST",
    //         url: "<?php echo Yii::app()->createUrl('expense/getCurTables'); ?>",
    //         data: 'expId='+$.session.get('expId'),
    //         success: function(data){
    //             $('#tableModalContent').html(data);
    //         }
    //     });
    // })
    /*$('#close').click(function(){
        $('.tableBtn').css('background','#555');
        $('#createDiv').css('display','none');
        $('#loginDiv').css('display','block');
    });*/
    $('#orders').click(function(){
        $("#ModalsHeader").html("Текущие заказы");
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('expense/todayOrder'); ?>",
            data: 'user='+userData.employee_id,
            success: function(data){
                $('#ModalsBody').html(data);
            }
        });
        $("#Modals").modal();
        return false;
    });
    $(".btnPrint").printPage();
    $(".expCheck").printPage();

    function closeExp(id){
        $("#paidModal").modal("show");
//
    }

    $(document).on("click","#closeCash", function () {
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('expense/closeExp'); ?>",
            data: "id="+$.session.get('expId')+"&paid=cash&check="+userData.check_percent,
            success: function(data){
                $("#paidModal").modal("hide");
                $('#createDiv').css('display','none');
                $('#loginDiv').css('display','block');
            }
        });
    });

    $(document).on("click","#closeTerm", function () {
        var half = false;
        var sum = 0;
        if($("#termSum").val() == ""){
            sum = $("#summ").text();
        }
        else{
            sum = $("#termSum").val();
            half = true;
        }
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('expense/closeExp'); ?>",
            data: "id="+$.session.get('expId')+"&paid=term&sum="+sum+"&check="+userData.check_percent+"&types="+half,
            success: function(data){
                $("#paidModal").modal("hide");
                $('#createDiv').css('display','none');
                $('#loginDiv').css('display','block');
                $("#termSum").val("")
            }
        });
    });

    $(document).on('click','.expCheck',function(){
        $('#createDiv').css('display','none');
        $('#loginDiv').css('display','block');
    });

    $('#submitBtn').click(function(){
        var data = $("#expense-form").serialize();
        var linkText = '<?php echo Yii::app()->createUrl('expense/printCheck'); ?>?table='+tables+'&user='+userData.employee_id+'&expId='+$.session.get('expId')+"&"+data;
        var expSum = $("#summ").text();
        var banket = ($("#banket").is(":checked")) ? 1 : 0;
        $(".btnPrint").attr('href',linkText);
        //$(".btnPrint").click();
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('expense/create'); ?>",
            data: data+"&table="+tables+"&employee_id="+userData.employee_id+"&expenseId="+ $.session.get('expId')+"&peoples="+people+"&expSum="+expSum+"&check="+userData.check_percent+"&banket="+banket
        });
        $('#order').children('tr').remove();
        $('#Expense_debt').removeAttr('checked');
        $("#Expense_comment").val('');
        $('#createDiv').css('display','none');
        $('#loginDiv').css('display','block');
        getSum();
        userData = '';
    });
    var cntObj;
    var cntVal;
    $(document).on("click", ".cnt", function() {
        var count = $(this).children('input').val();
        cntObj = $(this);
        cntVal = count;
        var thisClass = $(this).parent().parent().attr('class');
//        $("#myModalHeader").html("Укажите количество");
//        $('#myModalBody').html("<input class='span2 form-control' type='text' name='' value='' />");
//        $("#myModalBody").children('input').val(count);
//        $("#myModalBody").children('input').attr('name',thisClass);
        $("#myModal").modal();
        return false;
    });

    $(document).on("click", '.types' ,function(){
        var thisId = $(this).parent().attr('id');
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('expense/lists'); ?>",
            data: "id="+thisId,
            success: function(data){
                $('#data').html(data);
            }
        });
    })

    jQuery.fn.exists = function() {
        return $(this).length;
    }



    /*$(document).on("click", ".minus", function() {
        var count = $(this).parent().parent().children("td.cnt").children('input').val();
        count = parseFloat(count)-1;
        var id = $(this).parent().parent().attr('class');
        if(count > 0){
            $(this).parent().parent().children("td.cnt").children('input').val(count);
            $(this).parent().parent().children("td.cnt").children('span').text(count);
            //removeFromOrder(id,count);
        }
        else{
            $(this).parent().parent().remove();
            removeFromOrder(id,0);
        }
        if($("#order tr").exists() == 0){
        }
        getSum();
    });*/
    $(document).on("click", ".pluss", function() {
        var count = $(this).parent().parent().children("td.cnt").children('input').val();
        count = parseFloat(count)+1;
        var id = $(this).parent().parent().attr('class');
        if(count > 0){
            $(this).parent().parent().children("td.cnt").children('input').val(count);
            $(this).parent().parent().children("td.cnt").children('span').text(count);
        }
        else{
            $(this).parent().parent().remove();

        }
        if($("#order tr").exists() == 0){
        }
        getSum();
    });


    $(document).on("click", "#ok", function() {
        var curCount = $("#myModalBody").children('input').val();
        var curClass = $("#myModalBody").children('input').attr('name');
        if(curCount != '') {
            curCount = parseFloat(curCount.replace(/,/,'.'));
        }
        else{
            curCount = 0;
        }
        var inputVal = parseFloat($("." + curClass).children("td.cnt").children('input').val());
        var spanVal = parseFloat($("." + curClass).children("td.cnt").children('span').text());
        $("." + curClass).children("td.cnt").children('input').attr('value',curCount);
        $("." + curClass).children("td.cnt").children('span').text(curCount);
        getSum();
    });


    $(document).on('click','.all',function(){
        $("#order").empty();
        getSum();
    });

    $(document).on('click','#toTable',function(){
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('expense/tables'); ?>",
            success: function(data){
                data = JSON.parse(data);
                $.each(data, function(i, b) {

                        if (b.employee_id == userData.employee_id) {
                            var tableClass = ".table-" + b.table;
                            $(tableClass).addClass('actived');
                        }

                });
            }
        });
        $('#createDiv').css('display','none');
        $('#tablesDiv').css('display','block');
    });

    $(document).on('click', '.modalTableBtn', function(){
        var id = '.table-'+tables;
        $(id).removeClass('actived');
        tables = $(this).text();
        id = '.table-'+tables;
        $(id).addClass('actived');
        $('#tableNum span').text(tables);
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('expense/changeTable'); ?>",
            data: 'table='+tables+"&user="+userData.employee_id+'&expId='+ $.session.get('expId'),
            success: function(data) {

            }
        });
        $('#tableModal').modal('hide')
    });

    function addToOrder(id,count){
        var temp;
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('expense/addToOrder'); ?>",
            data: "id="+id+'&count='+count+'&expenseId='+expId+'&table='+tables+'&user='+userData.employee_id,
            success: function(data){
                if(expId == 0)
                    temp = parseInt(data);
            }
        });
    }

    function removeFromOrder(id,count){
        var expId = $("#expenseId");
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('expense/removeFromOrder'); ?>",
            data: "id="+id+'&count='+count+'&expenseId='+$.session.get('expId')+'&table='+tables+'&user='+userData.employee_id,
            success: function(data){
                expId.val(parseInt(data));
            }
        });
    }

    function removeEx(){
        var expId = $("#expenseId");
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('expense/removeEx'); ?>",
            data: "expenseId="+expId.val(),
            success: function(data){
                expId.val(parseInt(data));
            }
        });
    }

    function getSum(){
        var summ = 0;
        $('#dataTable tbody tr').each(function(indx){
            var temp = parseFloat($(this).children('td:nth-child(4)').text())*parseInt($(this).children('td:nth-child(3)').text());
            summ += temp
            //sum += $(this).children('td:nth-child(3)').text();
        });
        $('#summ').text(summ);
    }


    var res;
    function getPrice(id,mType,type,orderDate){
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('expense/getPrice'); ?>",
            data: "id="+id+"&mType="+mType+"&type="+type+"&orderDate="+orderDate,
            success: function(data){
                var price = data.toString();
                if(type == 1) {
                    var ids = ".dishPrice_"+id+"";
                        $(ids).html(price);
                }
                if(type == 2) {
                    var ids = ".stuffPrice_"+id;
                        $(ids).html(price);
                }
                if(type == 3) {
                    var ids = ".prodPrice_"+id;
                        $(ids).html(price);
                }
            }
        });
    }

    $(document).on("click",".digits",function(){
        var emptyVal = $('#termSum').val();
            $('#termSum').val(emptyVal+$(this).text());
    });

    $(document).on("click",".backspaces",function(){
        var str = $('#termSum').val();
        str = str.slice(0,-1);
        $('#termSum').val(str);
    });

    $(document).on("click",".clears",function(){
        var emptyVal = $('#termSum').val();
        $('#termSum').val("");
    });

    $(document).on("click","#saveCosBtn", function () {
        var data = $("#costsForm").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('expense/saveCost'); ?>",
            data: data+'&user='+userData.employee_id,
            success: function(data) {
                $("#costs").modal("hide");
                $("#costsForm input").val("");
            }

        });
    });

    $(document).on("click", "#modalOk", function () {
        $('#dataTable tbody tr').each(function(indx){
            /*if(parseFloat($(this).children('td:nth-child(4)').text()) == 0){
                var id = $(this).attr('class');
                $(this).remove();
                removeFromOrder(id,0);
            }*/
        });
    });

    $(document).on("click", ".removed", function () {
        /*var id = $(this).parent().attr('class');
        $(this).parent().remove();
        removeFromOrder(id,0);

        getSum();*/
    });
    $.fn.cntChange = function () {
        $(this).on('click',function() {
            var id = $(this).attr("id");
            switch (id){
                case "plusOne":
                    cntObj.children("span").text(parseFloat(cntObj.children("span").text()) + 1);
                    cntObj.children("input").val(parseFloat(cntObj.children("input").val()) + 1);
                    break;
                case "plusHalf":
                    cntObj.children("span").text(parseFloat(cntObj.children("span").text()) + 0.5);
                    cntObj.children("input").val(parseFloat(cntObj.children("input").val()) + 0.5);
                    break;
                case "minusHalf":
                    if($("#action").val() == "update"){

                        if(parseFloat(cntObj.children("span").text()) > parseFloat(cntObj.children("a").children("input").val())){
                            console.log("change");
                            cntObj.children("span").text(parseFloat(cntObj.children("span").text()) - 0.5);
                            cntObj.children("input").val(parseFloat(cntObj.children("input").val()) - 0.5);
                        }
                    }
                    else if($("#action").val() == "create"){
                        cntObj.children("span").text(parseFloat(cntObj.children("span").text()) - 0.5);
                        cntObj.children("input").val(parseFloat(cntObj.children("input").val()) - 0.5);
                    }
                    break;
                case "minusOne":
                    cntObj.children("span").text(parseFloat(cntObj.children("span").text()) - 1);
                    cntObj.children("input").val(parseFloat(cntObj.children("input").val()) - 1);
                    break;
            }
            getSum();
        });
        return this;
    };

    </script>
    </form>


    <!--/*****      --------------Modal windows------------     ******/-->


    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body" id="myModalBody">
                    <div class="row">
                        <div class="col-xs-3 col-md-2 hide">
                            <a href="#" class="thumbnail cntPlus" id="plusOne">
                                <img src="/images/dish_bg.jpg" alt="...">
                                <h1 class="texts">+1</h1>
                            </a>
                        </div>
                        <div class="col-xs-3 col-md-2">
                            <a href="#" class="thumbnail cntPlus" id="plusHalf">
                                <img src="/images/dish_bg.jpg" alt="...">
                                <h1 class="texts">+0.5</h1>
                            </a>
                        </div>
                        <div class="col-xs-3 col-md-2" >
                            <a href="#" class="thumbnail cntPlus" id="minusHalf">
                                <img src="/images/dish_bg.jpg" alt="...">
                                <h1 class="texts">-0.5</h1>
                            </a>
                        </div>
                        <div class="col-xs-3 col-md-2 hide" >
                            <a href="#" class="thumbnail cntPlus" id="minusOne">
                                <img src="/images/dish_bg.jpg" alt="...">
                                <h1 class="texts">-1</h1>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="modalOk" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="paidModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body" id="paidModalBody">
                    <input type="text" id="termSum" class="form-control">
                    <div class="btnDigit">

                        <div class="buttons">
                            <button class="digits num1">1</button>
                            <button class="digits num2">2</button>
                            <button class="digits num3">3</button>
                            <button class="digits num4">4</button>
                            <button class="digits num5">5</button>
                            <button class="digits num6">6</button>
                            <button class="digits num7">7</button>
                            <button class="digits num8">8</button>
                            <button class="digits num9">9</button>

                            <button class="clears"><i class="glyphicon glyphicon-trash"></i></button>
                            <button class="digits num0">0</button>
                            <button class="backspaces"><i class="fa fa-chevron-left"></i></button>

                            <div class="justify-dummy"></div>
                        </div>
                    </div>
                    <div class="closedBtns">
                        <button class="btn btn-danger" id="closeCash">Наличные</button>
                        <button class="btn btn-danger" id="closeTerm">Терминал</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <div class="modal fade" id="Modals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="ModalsHeader"></h4>
                </div>
                <div class="modal-body" id="ModalsBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal fade" id="tableModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="TableTitle">Поменять стол</h4>
            </div>
            <div class="modal-body">
                <div id="tableModalContent">
                    <? $cnt = 1;
                    foreach ($table as $val) {?>
                        <div class="col-md-2">
                            <a class="modalTableBtn table-<?=$val['table_num']?>" href="#"><?=$val['table_num']?></a>
                        </div>
                        <?$cnt++;
                    }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="costs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="" id="costsForm">
                    <div class="form-group">
                        <input type="text" name="costDesc" placeholder="Причина расхода" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" name="costSum" placeholder="сумма" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="saveCosBtn" >Сохранить</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="dropdown-wrap">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">

    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(".cntPlus").cntChange();
        $(document).keyboard({
            language: 'russian,us',
            enterKey: function () {
                //alert('Hey there! This is a callback function example.');
            },
            keyboardPosition: 'bottom',
            directEnter: false
        });
    });
</script>