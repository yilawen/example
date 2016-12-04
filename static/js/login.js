/**
 * 
 */
$(function(){
    $re = document.getElementById("re");	
    checkCookie();
	$("#login").click(function(){
		if($("#username").val()!=""&&$("#password").val()!=""){
		$.ajax( {  
			url : "../user/login",
			data : {
				username : $("#username").val(),
				password : $("#password").val()
			},
			type : "post",
			dataType : "html",
			success : function(data){
				if(data){
					if($re.checked){
					  setCookie('username',$("#username").val(),365);
					} else {
					  delCookie("username");
					}				
					window.location.href=getRootPath_web()+"/home/index"; 
				}else{
					$("#login-tip").removeClass("alert-info").addClass("alert-danger");
					$("#tip-text").text("用户名和密码不匹配！");
					$("#password").val("");
				}			
			},
			error : function(){
				alert("异常");
			}
		}			  
);} else {
	$("#login-tip").removeClass("alert-info").addClass("alert-danger");
	$("#tip-text").text("请输入用户名和密码！");
}		
});	
	$(this).ajaxStart(function(){
		  $("#login").val("正在登录...");
		});
	$(this).ajaxStop(function(){
		  $("#login").val("登录");
		});
	$("#username").focus(function(){
		$("#login-tip").removeClass("alert-danger").addClass("alert-info");
		$("#tip-text").text("不建议在公共场所记住账号，以防丢失");
	});
	$("#password").focus(function(){
		$("#login-tip").removeClass("alert-danger").addClass("alert-info");
		$("#tip-text").text("不建议在公共场所记住账号，以防丢失");
	});
	
	
	function setCookie(c_name,value,expiredays)
	{
	var exdate=new Date()
	exdate.setDate(exdate.getDate()+expiredays)
	document.cookie=c_name+ "=" +escape(value)+
	((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
	}
	
	function getCookie(c_name)
	{
	if (document.cookie.length>0)
	  {
	  c_start=document.cookie.indexOf(c_name + "=")
	  if (c_start!=-1)
	    { 
	    c_start=c_start + c_name.length+1 
	    c_end=document.cookie.indexOf(";",c_start)
	    if (c_end==-1) c_end=document.cookie.length
	    return unescape(document.cookie.substring(c_start,c_end))
	    } 
	  }
	return "";
	}
	
	function delCookie(name){
		   var date = new Date();
		   date.setTime(date.getTime() - 10000);
		   document.cookie = name + "=a; expires=" + date.toGMTString();
		}


	function checkCookie()
	{
	username=getCookie('username')
	if (username!=null && username!="")
	  {
		$re.checked = true;
		$("#username").val(username);
		
	  }
	}
	
	

	
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