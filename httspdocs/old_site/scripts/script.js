$(document).ready(function(){
	
	/*AJAX Error handler*/
	$(document).ajaxError(function(e, xhr, settings, exception) {
		alert('error in: ' + settings.url + ' \n'+'error:\n' + xhr.responseText );
	});
	
	$('#contact-form').jqTransform();

	$("button").click(function(){

		$(".formError").hide();

	});

	var use_ajax=true;
	$.validationEngine.settings={};

	$("#contact-form").validationEngine({
		inlineValidation: false,
		promptPosition: "centerRight",
		success :  function(){use_ajax=true},
		failure : function(){use_ajax=false;}
	 })

	$("#contact-form").submit(function(e){

/*
			if(!$('#subject').val().length)
			{
				$.validationEngine.buildPrompt(".jqTransformSelectWrapper","* This field is required","error")
				return false;
			}
*/			
			if(use_ajax)
			{
				$('#loading').css('visibility','visible');
				$.post('/scripts/submit.php',$(this).serialize()+'&ajax=1',
				
					function(data){
						//alert(data);
						if(parseInt(data)==-1)
							$.validationEngine.buildPrompt("#captcha","* Suma incorrecta!","error");
							
						else
						{
							$("#contact-form").hide('slow').after('<h1>Mensaje Recibido...!</h1>');
						}
						
						$('#loading').css('visibility','hidden');
					}
				
				);
			}
			e.preventDefault();
	})

});