/**
 * 
 */
$(function(){
	$totalPrice = $("#submit").attr("href");
	$src = getRootPath_web()+"/home/submitOrder?totalPrice="+$totalPrice+"&recipient="+$("#preName").text()+"&orderPhone="
	+$("#prePhone").text()+"&orderAddr="+$("#preAddr").text();
	$("#submit").attr("href",$src);
	$("#edit").click(function(){
		$("#myModal").modal('show');
	});
	
	$("#submitEdit").click(function(){
		$("#editForm").submit();
	});
	
	$("#submit").click(function(){
		if($("#preName").text()==""||$("#prePhone").text()==""||$("#preAddr").text()=="") {
			alert("请先完善收货信息！");
			return false;
		}
	});
	
	$("#editForm").validate({
		rules:{
			editName : "required",
			editPhone : "required",
			editAddr : "required"
		},				   
		   errorPlacement : function(error,element) {  
				error.appendTo(element.parent("div").next("div"));
		   },
		   submitHandler : function(form){
  	            $("#preName").text($("#editName").val());
  	            $("#prePhone").text($("#editPhone").val());
  	            $("#preAddr").text($("#editAddr").val());
  	            $("#myModal").modal("hide");
  	          $src = getRootPath_web()+"/home/submitOrder?totalPrice="+$totalPrice+"&recipient="+$("#preName").text()+"&orderPhone="
  	    	+$("#prePhone").text()+"&orderAddr="+$("#preAddr").text();
  	    	$("#submit").attr("href",$src); 	    	
	        }   
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