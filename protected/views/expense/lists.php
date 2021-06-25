<? $prices = new Prices(); $dates = date('Y-m-d')?>
<div id="">
    <div class="row">
    <? foreach($newModel1 as $val){ ?>
      <div class="element">
        <div id="dish_<?=$val["dish_id"]?>" class="thumbnail plus">
          <img class="img-rounded" src="<?php echo Yii::app()->request->baseUrl; ?>/images/dish_bg.jpg" alt="<?=$val["name"]?>" />
          <span class="texts">
            <?=$val["name"]?>
          </span>
          <div><?=$prices->getPrice($val["just_id"],$val["mType"],1,$dates);?></div>
        </div>
      </div>
    <?}?>
    <? foreach($newModel2 as $val){ ?>
      <div class="element ">
        <div id="stuff_<?=$val["halfstuff_id"]?>" class="thumbnail plus">
          <img class="img-rounded" src="<?php echo Yii::app()->request->baseUrl; ?>/images/dish_bg.jpg" alt="<?=$val["name"]?>" />
          <span class="texts">
            <?=$val["name"]?>
          </span>
            <div><?=$prices->getPrice($val["just_id"],$val["mType"],2,$dates)?></div>
        </div>
      </div>
    <?}?>
    <? foreach($newModel3 as $val){?>
      <div class="element   ">
        <div id="product_<?=$val["product_id"]?>" class="thumbnail plus ">
          <img class="img-rounded" src="<?php echo Yii::app()->request->baseUrl; ?>/images/dish_bg.jpg" alt="<?=$val["name"]?>" />
          <span class="texts">
            <?=$val["name"]?>
          </span>
            <div><?=$prices->getPrice($val["just_id"],$val["mType"],3,$dates)?></div>
        </div>
      </div>
    <?}?>
    </div>

</div>
<script>
    $('.plus').on('click', function () {
      $("#submitBtn").removeAttr('disabled');
      var identifies = $(this).children('span').text();
      var thisId = $(this).attr('id');
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
                                <td>"+identifies+"</td>\
                                <td>"+$(this).children('div').text()+"</td>\
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


</script>