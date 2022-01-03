
<div id="mostByteLogo">
    <img src="/images/CafeLogo.png" alt="">
</div>

<div id="loginDiv">
    <div id="logo" ><?//=Yii::app()->config->get("name") ?>
        <img src="/images/CafeLogo.png" alt="">
    </div>
    <div class="main-container page-login">
        <div class="content-wrapper">

            <div class="inputs">
                <div class="input empty">
                    <input class="info" disabled="" type="password" />
                </div>

                <div class="justify-dummy"></div>
            </div>

            <div class="buttons">
                <button class="digit num1 btn-info">1</button>
                <button class="digit num2 btn-info">2</button>
                <button class="digit num3 btn-info">3</button>
                <button class="digit num4 btn-info">4</button>
                <button class="digit num5 btn-info">5</button>
                <button class="digit num6 btn-info">6</button>
                <button class="digit num7 btn-info">7</button>
                <button class="digit num8 btn-info">8</button>
                <button class="digit num9 btn-info">9</button>

                <button class="clear btn-danger"><i class="fa fa-trash"></i></button>
                <button class="digit num0 btn-info">0</button>
                <button class="backspace btn-danger"><i class="fa fa-arrow-left"></i></button>

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
        var commentedElement = "";
        var selectedInput = "";
        $(document).ready(function(){

            document.onkeyup = function (e) {
                e = e || window.event;
                if(shifted === false) {
                    switch (e.keyCode) {
                        case 16:
                            shifted = true;
                            break;
                        case 96:
                            $(".num0.digit").click();
                            break;
                        case 97:
                            $(".num1.digit").click();
                            break;
                        case 98:
                            $(".num2.digit").click();
                            break;
                        case 99:
                            $(".num3.digit").click();
                            break;
                        case 100:
                            $(".num4.digit").click();
                            break;
                        case 101:
                            $(".num5.digit").click();
                            break;
                        case 102:
                            $(".num6.digit").click();
                            break;
                        case 103:
                            $(".num7.digit").click();
                            break;
                        case 104:
                            $(".num8.digit").click();
                            break;
                        case 105:
                            $(".num9.digit").click();
                            break;
                        case 48:
                            $(".num0.digit").click();
                            break;
                        case 49:
                            $(".num1.digit").click();
                            break;
                        case 50:
                            $(".num2.digit").click();
                            break;
                        case 51:
                            $(".num3.digit").click();
                            break;
                        case 52:
                            $(".num4.digit").click();
                            break;
                        case 53:
                            $(".num5.digit").click();
                            break;
                        case 54:
                            $(".num6.digit").click();
                            break;
                        case 55:
                            $(".num7.digit").click();
                            break;
                        case 56:
                            $(".num8.digit").click();
                            break;
                        case 57:
                            $(".num9.digit").click();
                            break;
                    }
                }
                else{
                    shifted = false;
                }

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
                                                $(tableClass).addClass('disabled').addClass('btn-danger');
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
                        <!--Расходы-->
                    </a>
                </div>
        <? $cnt = 1;
            foreach ($table as $val) { ?>
                <div class="tableBlock">
                    <button type="button" id="table-<?= $val['table_num'] ?>" class="tableBtn table-<?= $val['table_num'] ?>" data-toggle="modal"
                       data-target=".bs-example-modal-sm" >
                        <?= $val['name'] ?>
                    </button>
                </div>
                <? $cnt++;
            }
            ?>
            </div>
            <div class="self hide">
                <div class="col-md-2">
                    <a class="tableBtn table-0" id="table-0" data-toggle="modal"
                       data-target=".bs-example-modal-sm" href="#">
                        <?=0?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script>
        function checkTables(tables,newOrder){
            var tableClassName = 'table-'+tables;
            console.log($(tableClassName));
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
                var temp = $(this).attr('id').split('-');
                tables = temp[1];
                $('#tableNum span').text($(this).text());

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
							$(".btnPrint").attr("data-href","/expense/printExpCheck?exp="+expenses);
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
    </script>
</div>

<div id="createDiv">
    <form id='expense-form'>
    <? $menu = new Menu(); ?>

    <style>

    </style>
        <nav class="navbar navbar-default navbar-static-top" role="navigation" >
        <!-- /.navbar-header -->
        <ul class="nav navbar-nav">
            <li>
                <a href="javascript:;" id="toTable"><i class="fa fa-caret-left "></i> Столы</a>
            </li>
            <li>
                <?=CHtml::button('Мои заказы',array('type'=>'button','class'=>'btn btn-info pull-right','id'=>'orders'))?>
            </li>
            <li  id="tableNum">
                <a href="javascript:;"  data-toggle="modal" id="curTables" data-target="#tableModal">Стол № <span></span></a>
            </li>
            <li>
                <? if(Yii::app()->config->get("banket") == "1"){?>
                    <div class='checkbox'>
                        <label for="banket" >
                            <input type="checkbox" name='banket' id='banket'> Банкет
                        </label>
                    </div>
                <?}?>
            </li>
            <li style="margin-top: 10px; width: 42%">
                <div class="col-sm-12">
                    <div class="col-sm-10"><input type="text" class="form-control" id="searchMenu" placeholder="Введите мин 3 символа"></div>
                    <div class="col-sm-2">
                        <a href="#" class="btn btn-danger" id="closeSearch"><i class="fa fa-close"></i></a>
                    </div>
                </div>

                <div id="searchDiv">

                </div>

<!--                --><?//=CHtml::dropDownList('menuDrop','',$menu->getMenuList())?>
            </li>
        </ul>
        <ul class="nav navbar-nav pull-right">

            <li>
                <a href="javascript:;" class="logout">  </a>
            </li>
<!--            <li >-->
<!--                <a href="javascript:;"  id="close"><i class="fa fa-unlock-alt"></i></a>-->
<!--            </li>-->
        </ul>

    </nav>
        <input id="tempPrice" type="text" class="hide" />
    <!-- /.navbar-top-links -->
        <div>
        <div class="navbar-default sidebar" >
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
            <div class="tab-panels" id="data">

            </div>
        </div>
        <div class="navbar-default right-sidebar" >
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
        </div>
            <div>
                <table>
                    <tr>
                        <td>

                            <div class="form-actions pull-right submitDiv col-xs-12 " style="margin-top:45px;">
                                <button class="btn btn-success " id="submitBtn" type="button">Добавить</button>
                                <?=CHtml::link('<i class="fa fa-print"></i>  Печать',array('/expense/printCheck?id='.$id),array('class'=>'btn btnPrint hide'))?>

                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        <?echo Chtml::textField('Expense[comment]','',array('style'=>'display:none'))?>
    </div>
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

    $(document).on("click", ".removed i", function () {
        // var id = $(this).parent().attr('class');
        $(this).parent().parent().remove();
        console.log("asdada");

        getSum();
    });

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
    $/*('#close').click(function(){
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
    $(document).on("focus","#searchMenu",function (){
        $("#searchDiv").css("display","block");
        selectedInput = "searchMenu";
    });


    $(document).on("click","#closeSearch",function (){
        console.log("clicked");
        $("#searchDiv").css("display","none");
        $("#searchMenu").val("");
        $("#searchDiv").html("");
        selectedInput = "";
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
		$(".btnPrint").click();
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
        $("#closeSearch").click();
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
        var temp = $(this).attr('id').split('-');
        tables = temp[1];
        id = '.table-'+tables;
        $(id).addClass('actived');
        $('#tableNum span').text($(this).text());
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
        summ = parseInt(summ/100) * 100;
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

    $(document).on("click","#addCustomValue", function(e){

            console.log($("#customValue").val());
        if($("#action").val() == "update"){

            if(parseFloat(cntObj.children("span").text()) <= $("#customValue").val()){
                cntObj.children("span").text($("#customValue").val());
                cntObj.children("input").val($("#customValue").val());
            }
        }
        else if($("#action").val() == "create"){
            cntObj.children("span").text($("#customValue").val());
            cntObj.children("input").val($("#customValue").val());
        }
            getSum();
            $("#customValue").val("");
            $("#myModal").modal("hide");

    });

    $(document).on("click", ".dish", function () {
        $("#comment").modal("show");
        commentedElement = $(this).parent().attr('class');
    });

    $(document).on('click',"#saveComment", function () {
        let text = $("#commentText").val();
        $("."+commentedElement+" .dish>input").val(text);
        $("#commentText").val("");
        $("#comment").modal("hide");
    });

    $(document).on('hide.bs.modal','#comment', function () {
        console.log("close modal");
        $('#commentText').val("");
    });

    $(document).on('show.bs.modal','#comment', function () {
        console.log("open and focus modal");
        $('#commentText').focus();
    });

    function searchMenu(){
        var searchTxt = $("#searchMenu").val();
        var htmlTxt = "";
        if(searchTxt.length >= 3) {
            $.ajax({
                type: "GET",
                url: "<?php echo Yii::app()->createUrl('menu/searchList'); ?>",
                data: "txt=" + searchTxt,
                success: function (data) {
                    data = JSON.parse(data);
                    $.each(data, function (i, b) {
                        htmlTxt += "<div class='searchElement' data-id='" + i + "'>" + b + "</div>";
                    });
                    $("#searchDiv").html(htmlTxt);
                }
            });
        }
    }

    $(document).on("click",".searchElement", function (){
        $(".searchElement").removeClass("activeSearchElement");
        $(this).addClass("activeSearchElement");
        var texts = $(this).text();
        var thisId = $(this).attr("data-id");
        var temps = str_split(texts,1);
        if($('#order tr.'+thisId).exists()){
            var types = str_split(thisId,1);
            var count = $('#order tr.'+thisId).children("td.cnt").children('input').val();
            count = parseFloat(count)+1;
            $('#order tr.'+thisId).children("td:first-child").children('input').val(thisId);
            $('#order tr.'+thisId).children("td.cnt").children('input').val(count);
            $('#order tr.'+thisId).children("td.cnt").children('span').text(count);
        }
        else{
            var types = str_split(thisId,1);
            $('#order').append("<tr class="+thisId+">\
                                <td class='removed'>\
                                    <i class='  fa fa-times'></i>\
                                    <input style='display:none' name='id[]' value='"+thisId+"' />\
                                </td>\
                                    <td class='dish'><input style='display:none' type='text' name='comment[]'>"+temps[0]+"</td>\
                                    <td>"+temps[1]+"</td>\
                                <td class='cnt'>\
                                    <input name='count[]' style='display:none' value='1' />\
                                    <a type='button' class='pluss btn hide'>\
										<input name='' style='display:none' value='0'>\
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

    $.fn.cntChange = function () {
        $(this).on('click',function() {
            var id = $(this).attr("id");
            switch (id){
                case "plusOne":
                    cntObj.children("span").text(parseFloat(cntObj.children("span").text()) + 0.1);
                    cntObj.children("input").val(parseFloat(cntObj.children("input").val()) + 0.1);
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
                    if($("#action").val() == "update"){

                        if(parseFloat(cntObj.children("span").text()) > parseFloat(cntObj.children("a").children("input").val())){
                            console.log("change");
                            cntObj.children("span").text(parseFloat(cntObj.children("span").text()) - 0.1);
                            cntObj.children("input").val(parseFloat(cntObj.children("input").val()) - 0.1);
                        }
                    }
                    else if($("#action").val() == "create"){
                        cntObj.children("span").text(parseFloat(cntObj.children("span").text()) - 0.1);
                        cntObj.children("input").val(parseFloat(cntObj.children("input").val()) - 0.1);
                    }
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
                        <div class="col-xs-3 col-md-2">
                            <a href="#" class="thumbnail cntPlus" id="plusOne">
                                <img src="/images/dish_bg.jpg" alt="...">
                                <h1 class="texts">+0.1</h1>
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
                        <div class="col-xs-3 col-md-2" >
                            <a href="#" class="thumbnail cntPlus" id="minusOne">
                                <img src="/images/dish_bg.jpg" alt="...">
                                <h1 class="texts">-0.1</h1>
                            </a>
                        </div>
                        <div class="col-xs-5 col-md-5">
                            <input type="number" class="form-control" id="customValue">
                        </div>
                        <div class="col-xs-1 col-md-1">
                            <a href="javascript:;" id="addCustomValue" class="btn btn-info">OK</a>
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
                            <a id="modalTable-<?=$val['table_num']?>" class="modalTableBtn table-<?=$val['table_num']?>" href="#"><?=$val['name']?></a>
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

<div class="modal fade" id="comment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="" id="costsForm">
                    <div class="form-group">
                        <input type="text" id="commentText" placeholder="Комментарий к блюду" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-default" id="saveComment" >Сохранить</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {

        $(".cntPlus").cntChange();
        $(document).keyboard({
            language: 'russian,us',
            keyColor: "#000",
            keyTextColor: "#fff",
            enterKey: function () {

                if(selectedInput == "searchMenu"){
                    searchMenu();
                }
                //alert('Hey there! This is a callback function example.');
            },
            keyboardPosition: 'bottom',
            directEnter: true
        });
    });
</script>