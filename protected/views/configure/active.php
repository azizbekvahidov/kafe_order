
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/gentella/active.js"></script>
<div class="ldBar " id="loadBar" data-preset="bubble" data-value="0">
</div>

<div class="error d-none" id="error">
    <div class="col-md-12">
        <div class="col-middle">
            <div class="text-center text-center">
                <h1 class="error-number">Извините</h1>
                <h2>что то пошло не так</h2>

            </div>
        </div>
    </div>
</div>


<script>
    var data = <?=json_encode($data)?>;
    sendData(data);
</script>