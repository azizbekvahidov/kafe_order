function getOrderView(result){
    var sum = 0;
    $.session.set('expId',Object.keys(result.model).length != 0 ? result.model.expense_id : 0);
    var text = `<thead>\
        <tr>\
            <th id="all" class=" col-sm-1"><a class="btn all hide">Все</a></th>\
            <th id="ordName" class="col-sm-7">Название\
                <?if(!empty($model)){?>\
                    <input style="display:none" name="action" id="action" value="${Object.keys(result.model).length != 0 ? "update" : "create"}">\
            </th>\
            <th id="ordPrice" class="col-sm-2">Цена</th>\
            <th id="ordCount" class="col-sm-2">кол.</th>\
        </tr>\
    </thead>\
    <tbody id="order">`;
        
    for (var value of result.order) {
        text += `<tr class="dish_${value.just_id}">
                    <td class="">
                        <i class=" fa fa-check"></i>
                        <input style="display:none" name="id[]" value="dish_${value.just_id}">
                    </td>
                    <td class="dish"><input style='display:none' type='text' name='comment[]'>
                        ${value.name}
                    </td>
                    <td>${value.price}</td>
                    <td class="cnt">
                        <input name="count[]" style="display:none" value="${value.count}">
                        <a type="button" class="pluss btn hide">
                            <input name="" style="display:none" value="${value.count}">
                            <i class="fa fa-plus"></i>
                        </a>
                        <span>${value.count}</span>
                        <a type="button" class="minus btn hide">
                            <i class="fa fa-minus"></i>
                        </a>
                    </td>
                </tr>`;
    }
    
    for (var value of result.order2) {
        text += `<tr class="stuff_${value.just_id}">
                    <td class="">
                        <i class=" fa fa-check"></i>
                        <input style="display:none" name="id[]" value="stuff_${value.just_id}">
                    </td>
                    <td class="dish"><input style='display:none' type='text' name='comment[]'>
                        ${value.name}
                    </td>
                    <td>${value.price}</td>
                    <td class="cnt">
                        <input name="count[]" style="display:none" value="${value.count}">
                        <a type="button" class="pluss btn hide">
                            <input name="" style="display:none" value="${value.count}">
                            <i class="fa fa-plus"></i>
                        </a>
                        <span>${value.count}</span>
                        <a type="button" class="minus btn hide">
                            <i class="fa fa-minus"></i>
                        </a>
                    </td>
                </tr>`;
    }
                
    
    for (var value of result.order3) {
        text += `<tr class="prod_${value.just_id}">
                    <td class="">
                        <i class=" fa fa-check"></i>
                        <input style="display:none" name="id[]" value="prod_${value.just_id}">
                    </td>
                    <td class="dish"><input style='display:none' type='text' name='comment[]'>
                        ${value.name}
                    </td>
                    <td>${value.price}</td>
                    <td class="cnt">
                        <input name="count[]" style="display:none" value="${value.count}">
                        <a type="button" class="pluss btn hide">
                            <input name="" style="display:none" value="${value.count}">
                            <i class="fa fa-plus"></i>
                        </a>
                        <span>${value.count}</span>
                        <a type="button" class="minus btn hide">
                            <i class="fa fa-minus"></i>
                        </a>
                    </td>
                </tr>`;
    }
    text += `</tbody>
    <tfoot>
        <tr>
            <td colspan="2">Итого</td>
            <td colspan="2" id="summ">${sum}</td>
        </tr>
        <tr>
            <td class="text-center" colspan="4">`;
                 if(Object.keys(result.model).length != 0){
                  text += `<a style="padding: 3px 5px;" href="javascript:;" ${result.model.print == 1 ? "disabled" : ""} type="button" name="button" class="btn btn-info expCheck">Напечатать счет</a>
                    <br><br>
                  <a style="padding: 3px 5px;" href="#" onclick="closeExp(<?=$model['expense_id']?>)" type="button" name="button" class="btn btn-danger expClose hide">Закрыть счет</a>`;
                }
            text += `</td>
        </tr>
    </tfoot>`;
    return text;
}