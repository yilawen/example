/**
 * 
 */
$(function(){
	$("#add").click(function(){
		if($("#quantity").val() == ""){
			$("#quantity").val("1");
		} else {
			$total =parseInt($("#quantity").val());
		    $("#quantity").val($total+1);
		}		      
	});
	
	$("#cut").click(function(){
      if($("#quantity").val()=="1"||$("#quantity").val()=="")
        {
    	  $("#quantity").val("1");
        } else{
            $total =parseInt($("#quantity").val());
		    $("#quantity").val($total-1);
        }		     	
	});
	
	$("#addToCar").click(function(){
		$.ajax({
			url : "../home/addToCar",
			data : {				
				itemid : $("#addToCar").attr('itemid'),
				quantity : $("#quantity").val()
			},
			type : "post",
			dataType : "html",
			success : function(data){
				if(!data){
					window.location.href=getRootPath_web()+"/user/showLogin";
				} else {
					$(".modal-body").html("成功加入购物车！");
				}				
			},
			error : function(){
				alert("异常");
			}
		});
	});
	
	$(this).ajaxStart(function(){		
		$(".modal-body").html("请稍后...");
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
	

