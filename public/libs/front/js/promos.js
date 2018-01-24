$("#frmcontacto").validate({
	rules:{
		txtnombre:{
			required:true,
			maxlength:100
		},
		emlcorreo_electronico:{
			required:true,
			email:true,
		},
		txttelefono:{
			required:true,
			minlength:10,
			maxlength:100
		},
		nmbpersonas:{
			required:true,
			digits:true,
			min:1,
		},
		txaobservaciones:{
			required: true,
			maxlength:5000,
		}
	},
	submitHandler:function(form){
		$.ajax({
			url: $(form).attr("action"),
			data: $(form).serialize(),
			type: "post",
			dataType:"json",
			beforeSend:function(){
				$(".spinner").css("opacity",1);
			},
			success:function(data){
				console.log(data)
				$(".spinner").css("opacity",0);
				if(data.head == "_er:"){
					$(".alert-error").html(data.body).fadeIn( "slow").delay(2000).fadeOut("slow");
				}else{
					$(".alert-success").html(data.body).fadeIn( "slow").delay(2000).fadeOut("slow");
					$(form)[0].reset();
				}
			}
		})
	}			
});