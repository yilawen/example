/**
 * 
 */
$(function(){
	$("#submitInf").click(function(){
		$.ajax({
			url : getRootPath_web()+"/user/updateInf",
			data : {
				telephone : $("#telephone").val(),
				address : $("#address").val()
			},
			type : 'post',
			dataType : 'html',
			success : function(data){
				alert("修改成功！");
				window.location.href=getRootPath_web()+"/user/userDetail"; 
			},
			error : function(){
				alert("异常");
			}
		})
	});
	

	$("#infForm").validate({
		rules:{			
			telephone : {
				digits : true,
				maxlength : 13
			} 
		},						   
		   errorPlacement:function(error,element) {  
				error.appendTo(element.parent("div").next("div"));
		   },		   
	});
	
	$("#pwdForm").validate({
		rules:{	
			oldPwd :{
				required : true
			},
			newPwd : {
				required : true,
				minlength : 6
			},
			ackPwd : {
				required : true,
				minlength : 6,
				equalTo : "#newPwd"
			},
		},		
		 submitHandler: function(form) {
			 $.ajax({
				  url : getRootPath_web()+"/user/updatePwd",
					data : {				
						oldPwd : $("#oldPwd").val(),
						newPwd : $("#newPwd").val()
					},
					type : "post",
					dataType : "html",
					success : function(data) {	
						if(data) {
							alert("修改成功");	
							window.location.href=getRootPath_web()+"/user/logout"; 
						}
						else {
							$("#pwdTip").html("密码错误");
						}
					},
					error : function(){
						alert("异常");
					}
			 })
		 },
		   errorPlacement:function(error,element) {  
				error.appendTo(element.parent("div").next("div"));
		   },		   
	});
	
	$("#submitPwd").click(function(){
		$("#pwdForm").submit();
	});
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function getRootPath_web() {
        //获取当前网址，如： http://localhost:8083/uimcardprj/share/meun.jsp
        var curWwwPath = window.document.location.href;
        //获取主机地址之后的目录，如： uimcardprj/share/meun.jsp
        var pathName = window.document.location.pathname;
        var pos = curWwwPath.indexOf(pathName);
        //获取主机地址，如： http://localhost:8083
        var localhostPaht = curWwwPath.substring(0, pos);
        //获取带"/"的项目名，如：/uimcardprj
        var projectName = pathName.substring(0, pathName.substr(1).indexOf('/') + 1);
        return (localhostPaht + projectName);
    };
})

