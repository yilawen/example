/**
 * 
 */
$(function(){
	calculate();
	$("#selectAll").click(function(){
		   var checklist = document.getElementsByName ("selected");
		   if($("#selectAll").attr("value") == "false")
		   {
		   for(var i=0;i<checklist.length;i++)
		   {
		      checklist[i].checked = true;
		   } 
		   $("#selectAll").attr("value","true");
		 }else{
		  for(var j=0;j<checklist.length;j++)
		  {
		     checklist[j].checked = false;
		  }
		  $("#selectAll").attr("value","false") ;
		 };
		 calculate();
	});
	
	checklist = document.getElementsByName ("selected");
	$.each(checklist,function(){
		$(this).click(function(){
			calculate();
		});		
	});

	
	function calculate()
	{
		 $checklist = document.getElementsByName ("selected");
		 $total = 0;
		 for(var i=0;i<$checklist.length;i++)
			 {			 
			 if($checklist[i].checked) {
				 $itemid = $checklist[i].id;
				$total+=parseFloat($("#itemall"+$itemid).text());
			 } 		
			 }
		 $("#totalPrice").text($total);		
	}
	
	
	$(".add").click(function(){		
		$itemid = $(this).parents("tr").attr("itemid");
		$old = parseInt($("#itemq"+$itemid).val());
		$("#itemq"+$itemid).val($old+1);
		$quantity = parseInt($("#itemq"+$itemid).val());
		$.ajax({
			url : "../home/alterShopCar",
			data : {
			       itemid : $itemid,
			       quantity : $quantity
			},
			type : "post",
			dataType : "html",			
		    success : function(data){
		    	$unitPrice = parseInt($("#itemp"+$itemid).html());
		    	$total = $unitPrice*$quantity;
		    	$("#itemall"+$itemid).html($total);
		    	calculate();
		    },
		    error : function(){
		    	alert("异常");
		    }
		});
	});
	$(".cut").click(function(){
		$itemid = $(this).parents("tr").attr("itemid");
		$old = parseInt($("#itemq"+$itemid).val());
		$("#itemq"+$itemid).val($old-1);
		$quantity = parseInt($("#itemq"+$itemid).val());
		$.ajax({
			url : "../home/alterShopCar",
			data : {
			       itemid : $itemid,
			       quantity : $quantity
			},
			type : "post",
			dataType : "html",			
		    success : function(data){
		    	$unitPrice = parseInt($("#itemp"+$itemid).html());
		    	$total = $unitPrice*$quantity;
		    	$("#itemall"+$itemid).html($total);
		    	calculate();
		    },
		    error : function(){
		    	
		    } 
		});		
	});
	
	$("input:text").change(function(){
		$itemid = $(this).parents("tr").attr("itemid");
		$quantity = parseInt($("#itemq"+$itemid).val());
		$.ajax({
			url : "../home/alterShopCar",
			data : {
			       itemid : $itemid,
			       quantity : $quantity
			},
			type : "post",
			dataType : "html",			
		    success : function(data){
		    	$unitPrice = parseInt($("#itemp"+$itemid).html());
		    	$total = $unitPrice*$quantity;
		    	$("#itemall"+$itemid).html($total);
		    	calculate();
		    },
		    error : function(){
		    	
		    } 
		});		
	});
	
	$(".delete").click(function(){
	    $itemid = $(this).parents("tr").attr("itemid");
	    $select = confirm("确认要删除？");
	    if($select) {
	    	$.ajax({
	    		url : "../home/deleteItem",
	    		data : {
	    			itemid : $itemid,
	    		},
	    		type : "post",
	    		dataType : "html",
	    		success : function(data) {
	    			$("tr").remove(".tr"+$itemid);
	    			calculate();
	    		}
	    	})
	    } 
	});
	
	$("#settle").click(function(){
		$itemIds = new Array();		
		$checklist = document.getElementsByName ("selected");
		var j = 0;
		for(var i=0;i<$checklist.length;i++)
			{			 
			if($checklist[i].checked) {
				$itemIds[j] = $checklist[i].id;
				j++;
		    } 		
		    };
				
		$.ajax({
			url : "../home/preItems",
			data : {
				itemIds : $itemIds,
				totalPrice :  $("#totalPrice").text()
			},
			type : "post",
			dataType : "html",
			success : function(data) {
				window.location.href=getRootPath_web()+"/home/preOrder";
			}			
		});
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