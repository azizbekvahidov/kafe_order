<div class="row justify-content-center" >
    <div class="col-md-6 col-sm-6 ">
        <div class="x_panel">
            <div class="x_title">
                <h1 class="float-left">Настройка</h1>
                <div class=" float-right logo-middle">
                    <img src="/images/CafeLogo.png" class="" alt="">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <?  if (!empty($model)){?>
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" autocomplete="off" action="/configure/active" method="post">
                        <input type="text" name="type" value="waiter" hidden>
                        <input type="text" name="licenseId" value="<?=$model["licenseId"]?>" hidden>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="placeName">Название заведения <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" id="placeName" name="placeName" value="<?=Yii::app()->config->get("name")?>" required="required" class="form-control">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label for="secretKey" class="col-form-label col-md-3 col-sm-3 label-align">Секретный ключ <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input id="secretKey" name="secretKey" class=" form-control" required="required" type="text">
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="item form-group">
                            <div class="col-md-6 col-sm-6 offset-md-3">
                                <button type="submit" class="btn btn-success">Сохранить и активировать</button>
                            </div>
                        </div>

                    </form>
                <?}else{?>
                <div class="text-center text-center">
                    <h1 class="error-number">Внимание!!!</h1>
                    <h2>
                        Не активирован административная лицензия. <br>
                        Пожалуйста обратитесь администратору по номеру +998935193171 <br> или активируйте ключ предоставленный вам. <br>
                        Повторите попытку перейдя<a href='/configure/index'>  на страницу регистрации</a>
                    </h2>

                </div>
                <?}?>
            </div>
        </div>
    </div>
</div>