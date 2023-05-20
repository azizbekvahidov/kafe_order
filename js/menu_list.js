function getMenuList(result){
    var text = `<div id="">
    <div class="row">`;
    
    for (var value of result.menu1) {
        text += `<div class="element">
        <div id="dish_${value.id}" class="thumbnail plus">
          <img class="img-rounded" src="/images/dish_bg.jpg" alt="${value.name}" />
          <span class="texts">
          ${value.name}
          </span>
          <div>${value.price}</div>
        </div>
      </div>`;
    }
    for (var value of result.menu2) {
        text += `<div class="element">
        <div id="stuff_${value.id}" class="thumbnail plus">
          <img class="img-rounded" src="/images/dish_bg.jpg" alt="${value.name}" />
          <span class="texts">
          ${value.name}
          </span>
          <div>${value.price}</div>
        </div>
      </div>`;
    }
    for (var value of result.menu3) {
        text += `<div class="element">
        <div id="prod_${value.id}" class="thumbnail plus">
          <img class="img-rounded" src="/images/dish_bg.jpg" alt="${value.name}" />
          <span class="texts">
          ${value.name}
          </span>
          <div>${value.price}</div>
        </div>
      </div>`;
    }
    
        text += `</div>

    </div>`;
        return text;
    }
  
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
                                  <td class='dish'><input style='display:none' type='text' name='comment[]'>"+identifies+"</td>\
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