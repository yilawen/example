/**
 * 
 */
$(function(){
	
	
	$("#addItemSubmit").click(function(){
		$("#addItemForm").submit();
	});
	
	$("#updateItemSubmit").click(function(){
		$("#updateItemForm").submit();
	});
	
	$("#addItemForm").validate({
		rules:{
			itemname : "required",
			itemclass : "required",
			itemprice : {required:true,number : true,},
			inventory : {required:true,digits : true,},
			brand : "required"
		},				   
		   errorPlacement : function(error,element) {  
				error.appendTo(element.parent("div").next("div"));
		   },
		   submitHandler : function(form){
  	            	$.ajax({
  	            		url : getRootPath_web()+"/admin/addItem",
  	            	    type : "post",
  	            	    data : {
  	            	      itemname : $("#itemname").val(),
  	            	      itemclass : $("#itemclass").val(),
  	            	      itemprice : $("#itemprice").val(),
  	            	      itemimg : $("#itemimg").val(),
  	            	      brand : $("#brand").val(),
  	            	      information : $("#information").val(),
  	            	      inventory : $("#inventory").val()
  	            	    },
  	            	    dataType : "html",
  	            	    success : function(data) {
  	            	    	alert("入库成功");
  	            	    	$("#addItemForm input").val("");
  	            	    	$("#addItemModal").modal("hide");
  	            	    },
  	            	    error : function() {
  	            	    	alert("异常");
  	            	    }
  	            	})
	        }   
	});
	
	$(".editItem").each(function(){
	    $(this).click(function(){
	    	$id=$(this).attr("id");	    
	    	$("#uitemname").val($("#itemname"+$id).text());
	    	$("#uitemclass").val($("#itemclass"+$id).text());
	    	$("#uitemprice").val($("#itemprice"+$id).text());
	    	$("#uinformation").val($("#information"+$id).text());
	    	$("#uinventory").val($("#inventory"+$id).text());
	    	$("#uitemimg").val($("#itemimg"+$id).attr("alt"));
	    	$("#ubrand").val($("#brand"+$id).text());
	    	$("#updateItemSubmit").attr("value",$id);
	    })
	  });
	
	$("#updateItemForm").validate({
		rules:{
			uitemname : "required",
			uitemclass : "required",
			uitemprice : {required:true,number : true,},
			uinventory : {required:true,digits : true,},
			ubrand : "required"
		},				   
		   errorPlacement : function(error,element) {  
				error.appendTo(element.parent("div").next("div"));
		   },
		   submitHandler : function(form){
  	            	$.ajax({
  	            		url : getRootPath_web()+"/admin/updateItem",
  	            	    type : "post",
  	            	    data : {
  	            	      itemid : $("#updateItemSubmit").attr("value"),
  	            	      itemname : $("#uitemname").val(),
  	            	      itemclass : $("#uitemclass").val(),
  	            	      itemprice : $("#uitemprice").val(),
  	            	      itemimg : $("#uitemimg").val(),
  	            	      brand : $("#ubrand").val(),
  	            	      information : $("#uinformation").val(),
  	            	      inventory : $("#uinventory").val()
  	            	    },
  	            	    dataType : "html",
  	            	    success : function(data) {
  	            	    	if(data) {
  	            	    	alert("修改成功!");
  	            	    	$("#myModal").modal("hide");
  	            	    	 window.location.reload();	
  	            	    	} else {
  	            	    		alert("此商品不存在！");
  	            	    	}
  	            	    },
  	            	    error : function() {
  	            	    	alert("异常");
  	            	    }
  	            	})
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