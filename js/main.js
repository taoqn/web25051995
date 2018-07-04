var column_name_search = column_name;
var page = parseInt($("#number-page").attr('value'));
var limit = parseInt($("#number-row").val());
var order = column_name[0];
var type = "ASC";
var value = $("#table-data-header-value-search").val();

function table_data_body_tbody(column_n,page,limit,order,type,value){
    $('#table-data-body').addClass('table-tbody');
    $.ajax({
        url : "index-view-data.php?p=getBody", 
        type : "get",
        dateType: "html",
        data : {
            "columns[]" : column_n,
            "table" : table_name,
            "page" : page,
            "limit" : limit,
            "order" : order,
            "type" : type,
            "value" : value
        },
        success : function (result){
            $('#table-data-body').removeClass('table-tbody');
            $('#table-data-body-tbody').html(result);
        }
    });
}

function table_data_footer(column_n,page,limit,order,type,value){
    $.ajax({
        url : "index-view-data.php?p=getFooter", 
        type : "get",
        dateType: "html",
        data : {
            "columns[]" : column_n,
            "table" : table_name,
            "page" : page,
            "limit" : limit,
            "order" : order,
            "type" : type,
            "value" : value
        },
        success : function (result){
            $('#table-data-footer').html(result);
        }
    });
}

function modal_button_save_insert_data(value_save_insert_data){
	$('#modal-button-save-insert-data').attr('disabled', true);
	$('#modal-button-save-insert-data').addClass('disabled');
    $.ajax({
        url : "index-insert-data.php", 
        type : "get",
        dateType: "text",
        data : {
            "columns_value[]" : value_save_insert_data,
            "columns[]" : column_name,
            "table" : table_name
        },
        success : function (result1){
        	$('#modal-button-save-insert-data').attr('disabled', false);
			$('#modal-button-save-insert-data').removeClass('disabled');
            $('#modal-insert-data').modal("hide");
            if (result1 == 'true') {
                $.ajax({
                    url : "index-insert-data.php?p=getID", 
                    type : "get",
                    dateType: "text",
                    data : {
                        "id" : column_name[0],
                        "table" : table_name
                    },
                    success : function (result2){
                        $('#page-alert').append('<div class="alert alert-success"><strong>Thành công !</strong> thêm một hàng thành công với id <b>'+result2+'</b> .</div>');
                        var text = '<tr class="row-insert-new">';
                        text += '<td><input type="checkbox" value="'+result2+'" onclick="table_data_body_tbody_tr_td_input_click()" /></td>';
                        value_save_insert_data[0] = result2;
                        for (i = 0; i < column_name.length; i++) {
                            text += '<td>'+value_save_insert_data[i]+'</td>';
                        }
                        text += '</tr>';
                        $('#table-data-body-tbody').append(text);
                        $('html, body').animate({
                            scrollTop: $("#table-data-footer").offset().top
                        },3000);
                    }
                });
            }else{
                $('#page-alert').append('<div class="alert alert-danger"><strong>Cảnh báo !</strong> Đã xảy ra lỗi khi thêm dữ liệu.</div>');
                $('html, body').animate({
                	scrollTop: $("#page-alert").offset().top
            	},3000);
            }
        }
    });
}

function modal_button_save_update_data(value_save_update_data){
	$('#modal-button-save-update-data').attr('disabled', true);
	$('#modal-button-save-update-data').addClass('disabled');
    $.ajax({
        url : "index-update-data.php", 
        type : "get",
        dateType: "text",
        data : {
            "columns_value[]" : value_save_update_data,
            "columns[]" : column_name,
            "table" : table_name
        },
        success : function (result){
        	$('#modal-button-save-update-data').attr('disabled', false);
			$('#modal-button-save-update-data').removeClass('disabled');
            $('#modal-update-data').modal("hide");
            if (result == 'true') {
            	$('#page-alert').append('<div class="alert alert-info"><strong>Thành công !</strong> chỉnh sửa một hàng thành công với id <b>'+value_save_update_data[0]+'</b> .</div>');
            	$("#table-data-body-tbody tr").each(function () {
	    			var val = $(this).children().children().attr('value');
	    			if (val == getID()[0]) {
			    		$(this).children().each(function(ind) {
			    			if (ind != 0) {
			    				$(this).text(value_save_update_data[ind-1]);
			    			}
			    		});
			    		$(this).addClass('row-update-new');
			    		var tr = $(this);
			    		$('html, body').animate({
		                    scrollTop: tr.offset().top
		                },3000);
			    	}
			    });
            }else{
                $('#page-alert').append('<div class="alert alert-danger"><strong>Cảnh báo !</strong> Đã xảy ra lỗi khi chỉnh sửa dữ liệu với id <b>'+value_save_update_data[0]+'</b> .</div>');
                $('html, body').animate({
                	scrollTop: $("#page-alert").offset().top
            	},3000);
            }
        }
    });
}

function modal_button_yes_delete_data(){
    $('#modal-button-yes-delete-data').attr('disabled', true);
    $('#modal-button-yes-delete-data').addClass('disabled');
    $.ajax({
        url : "index-delete-data.php", 
        type : "get",
        dateType: "text",
        data : {
            "columns_id[]" : getID(),
            "columns[]" : column_name,
            "table" : table_name
        },
        success : function (result){
            $('#modal-button-yes-delete-data').attr('disabled', false);
            $('#modal-button-yes-delete-data').removeClass('disabled');
            $('#modal-delete-data').modal("hide");
            if (result == 'true') {
                var today = new Date();
                var time = today.get
                var dd = today.getDate();
                var mm = today.getMonth()+1;
                var yyyy = today.getFullYear();
                var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                if(dd<10) { dd = '0'+dd; } 
                if(mm<10) { mm = '0'+mm; } 
                today = dd+'/'+mm+'/'+yyyy;
                $("#table-data-body-tbody tr").each(function () {
                    var i = 2;
                    var tr = $(this);
                    if (getID_check(tr.find("input").val())) {
                        tr.fadeOut(i*1000);
                        setTimeout( function(){
                            tr.remove();
                            if ($("#table-data-body-thead-th-check-all").is(':checked')) {
                                $("#table-data-body-thead-th-check-all").prop("checked", false);
                                table_data_body_tbody(column_name,page,limit,order,type,value);
                                table_data_footer(column_name,page,limit,order,type,value);
                            }
                            set_button_update_data();
                        },i*1000);
                    }
                });
                $('#page-alert').append('<div class="alert alert-warning"><strong>Thành công !</strong> Đã xóa <b>'+getID().length+'</b> hàng thành công vào lúc <b>'+time+' - '+today+'</b> .</div>');
            }else{
                $('#page-alert').append('<div class="alert alert-danger"><strong>Cảnh báo !</strong> Đã xảy ra lỗi khi xóa dữ liệu .</div>');
                $('html, body').animate({
                    scrollTop: $("#page-alert").offset().top
                },3000);
            }
        }
    });
}

function button_update_data() {
	if (getID().length == 1) {
		$('#modal-update-data').modal("show");
		var points_id_value = [];
	    $("#table-data-body-tbody tr").each(function () {
	    	var val = $(this).children().children().attr('value');
	    	if (val == getID()[0]) {
	    		$(this).children().each(function(ind) {
	    			if (ind != 0) {
	    				points_id_value[points_id_value.length] = $(this).text();
	    			}
	    		});
	    	}
	    });
        for (i = 0; i < column_name.length; i++) {
           $("#input-Column-update-data-"+column_name[i]).val(points_id_value[i]);
        }
	}
}

function table_data_body_tbody_tr_td_input_click(){
    set_button_update_data();
}

function number_page_change(page){
    var m = $("#number-page").attr('max');
    if(page < 1 || page > m){
        return;
    }
    page = parseInt(page);
    $('#table-data-footer-current-row-number').html('<div class="text-center"><h6><i>Hiển thị</i></h6></div>');
    table_data_body_tbody(column_name,page,limit,order,type,value);
    table_data_footer(column_name,page,limit,order,type,value);
    set_button_update_data();
}

function number_row_change(){
    var i = parseInt($("#number-row").val());
    if(i < 10 || i > 200){
        return;
    }
    limit = i;
    table_data_body_tbody(column_name,page,limit,order,type,value);
    table_data_footer(column_name,page,limit,order,type,value);
    set_button_update_data();
}

function getID(){
    var points_id = [];
    $("#table-data-body-tbody input[type=checkbox]").each(function () {
        if ($(this).is(':checked')) {
            points_id[points_id.length] = $(this).val();
        }
    });
    return points_id;
}

function getID_check(id){
    for (i = 0; i < getID().length; i++) {
        if (getID()[i] == id) {
            return true;
        }
    }
    return false;
}

function set_button_update_data(){
    $("button").each(function() {
        if ($(this).attr('id') == 'button-insert-data') {
            if (getID().length != 0) {
                $(this).attr('disabled', true);
                $(this).hide("slow");
            }else{
                $(this).attr('disabled', false);
                $(this).show("slow");
            }
        }
        if ($(this).attr('id') == 'button-update-data') {
            if (getID().length != 1) {
                $(this).attr('disabled', true);
                $(this).hide("slow");
            }else{
                $(this).attr('disabled', false);
                $(this).show("slow");
            }
        }
        if ($(this).attr('id') == 'button-delete-data') {
            if (getID().length == 0) {
                $(this).attr('disabled', true);
                $(this).hide("slow");
            }else{
                $(this).attr('disabled', false);
                $(this).show("slow");
            }
        }
    });
}

function table_data_header_search(val,name) {
    column_name_search = [];
    if (val > -1) {
        column_name_search[0] = column_name[val];
    }else{
        column_name_search = column_name;
    }
    $('#table-data-header-search-concept').html('Đã chọn : <b>'+name+'</b>');
}

function set_table_data_body_thead(obj){
    var number_column = obj.attr('id');
    number_column = number_column.substring(25, number_column.lenght);
    $("#table-data-body-thead th").each(function () {
        if ($(this).attr('id') == obj.attr('id')) {
            if (obj.attr('class') == 'header') {
                order = column_name[number_column-1];
                type = "ASC";
                obj.attr('class', 'headerSortDown');
            } else if(obj.attr('class') == 'headerSortDown'){
                order = column_name[number_column-1];
                type = "DESC";
                obj.attr('class', 'headerSortUp');
            } else{
                order = column_name[number_column-1];
                type = "ASC";
                obj.attr('class', 'headerSortDown');
            }
            table_data_body_tbody(column_name,page,limit,order,type,value);
            table_data_footer(column_name,page,limit,order,type,value);
        }else{
            if ($(this).attr('id') !== 'table-data-body-thead-th-0') {
                $(this).attr('class', 'header');
            }
        }
    });
}

$(document).ready(function(){
    
    table_data_body_tbody(column_name,page,limit,order,type,value);
    table_data_footer(column_name,page,limit,order,type,value);
    set_button_update_data();

    //Phần giao diện
    $("#table-data-body-thead-th-check-all").click(function () {
        if ($("#table-data-body-thead-th-check-all").is(':checked')) {
            $("#table-data-body-tbody input[type=checkbox]").each(function () {
                $(this).prop("checked", true);
            });
        } else {
            $("#table-data-body-tbody input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
        }
        set_button_update_data();
    });
    $("#table-data-body-thead").click(function (event) {
        var obj = $(event.target);
        if (obj.attr('id') !== 'table-data-body-thead-th-0') {
            set_table_data_body_thead(obj);
        }
    });
    $("#button-theme-light").click(function () {
        $("#theme-css").attr("href","css/main.css");
    });
    $("#button-theme-dark").click(function () {
        $("#theme-css").attr("href","css/main-dark.css");
    });

    //Phần truy xuất data
    $("#table-data-header-button-search").click(function () {
        value = $("#table-data-header-value-search").val();
        table_data_body_tbody(column_name_search,page,limit,order,type,value);
        table_data_footer(column_name_search,page,limit,order,type,value);
    });

    $("#modal-button-save-insert-data").click(function () {
        var value_save_insert_data = [];
        value_save_insert_data[0] = "null";
        for (i = 1; i < column_name.length; i++) {
            value_save_insert_data[i] = $("#input-Column-insert-data-"+column_name[i]).val();
        }
        modal_button_save_insert_data(value_save_insert_data);
    });

    $("#modal-button-save-update-data").click(function () {
        var value_save_update_data = [];
        for (i = 0; i < column_name.length; i++) {
            value_save_update_data[i] = $("#input-Column-update-data-"+column_name[i]).val();
        }
        modal_button_save_update_data(value_save_update_data);
    });

    $("#modal-button-yes-delete-data").click(function () {
        if (getID().length>0) {
            modal_button_yes_delete_data();
        }else{
            $('#modal-delete-data').modal("hide");
        }
    });
});