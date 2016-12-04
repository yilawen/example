/**
 * 
 */
$(function(){
	
	$("#registerForm").validate({
		rules:{
			username : {
				required : true,
				minlength: 6				
			},
			password : {
				required : true,
				minlength : 6
			},
			AckPassword : {
				required : true,
				minlength : 6,
				equalTo : "#password"
			},
			telephone : {
				digits : true,
				maxlength : 13
			} 
		},
		messages: {
			username : {
				require : "请输入用户名",
			},
			password: {
		    required: "请输入密码",
		    minlength: "密码不能小于6个字 符"
		   },
		   AckPassword: {
		    required: "请输入确认密码",
		    minlength: "确认密码不能小于6个字符",
		    equalTo: "两次输入密码不一致"
		   },
		},
		   errorPlacement:function(error,element) {  
				error.appendTo(element.parent("div").next("div"));
		   },
		   submitHandler: function(form) 
		   {      
		      $.ajax({
		    	  url : "../user/register",
					data : {				
						username : $("#username").val(),
				        password : $("#password").val(),
				        telephone : $("#telephone").val(),
				        address : $("#address").val()
					},
					type : "post",
					dataType : "html",
					success : function(data) {	
						if(data) {
							alert("注册成功");	
							window.setTimeout(location='../user/showLogin',5000);
						}
						else {
							alert("该用户名已被使用！")
						}
					},
					error : function(){
						alert("异常");
					}
		      });
		   }  
		   
	});
	

	
	

	
})