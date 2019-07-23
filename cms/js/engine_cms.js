$(document).ready(function(){
	
	function set_required(object){
		$target = $('.'+object.data('target'));
		if (object.is(':checked')) {
			$target.prop('required', true);
		}else{
			$target.prop('required', false);
		}
	}
	
	$('.set_required').click(function(){
		set_required($(this));
	}) 
	$('.set_required').each(function(){
		set_required($(this));
	})
	
	$('.select_checkbox').click(function(){
		$this = $(this);
		if ($this.is(':checked')) {
			$this.parents('.parent_select_checkbox').find('input[type=checkbox]').prop('checked', true);
		}else{
			$this.parents('.parent_select_checkbox').find('input[type=checkbox]').prop('checked', false);
		}
	}) 
	
	$('.offers_option_select').change(function(){
		$this = $(this);
		if($this.val()=='select'){
			$this.parents('form').find('.offers_option_label').show().find('textarea').attr("disabled", false);
		}else{
			$this.parents('form').find('.offers_option_label').hide().find('textarea').attr("disabled", true);
		}
	})
	$('.offers_option_select').change();
	
	$('.inactive').click(function(){
		return false;
	})
	
	$(".ajax").not('.inactive').click(function(){
		var mydata = $(this).data();
		$.post('php/functions_ajax.php', {
			'data' : mydata,
			'send': 'ok'}, 
			function(data) {
				window.location.href = window.location;
		});
        return false;   
    });

	$('.datepicker').datepicker({language: 'pl',  format: 'yyyy-mm-dd'});
})

$(document).on('click', '.open_roxy', function(){
	$('.roxy_target').removeClass('roxy_target');
	$(this).find('img').addClass('roxy_target');
	$('#roxyCustomPanel').modal({show:true}).find('iframe').attr("src",'js/ckeditor/fileman/index.html?integration=custom');
	return false;
})
	
function closeCustomRoxy(){
	$roxy_target = $('.roxy_target');
	$("[name='"+$roxy_target.data('roxy_name')+"']").val($roxy_target.attr('src'));
	$('#roxyCustomPanel').modal('hide');
}

function run_ckeditor(id,height=200){
	var roxyFileman = 'js/ckeditor/fileman/index.html'; 
	$(function(){
		CKEDITOR.replace( id,{height: height,
			filebrowserBrowseUrl:roxyFileman,
			filebrowserImageBrowseUrl:roxyFileman+'?type=image',
			removeDialogTabs: 'link:upload;image:upload'}); 
	});
}