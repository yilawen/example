/**
 * 
 */

$(function(){
	$(".showDetail").each(function(){		
		$(this).click(function(){
			$orderid = $(this).attr("value");
			$.ajax({
				url : getRootPath_web()+"/admin/getOrderDetail",
				type : "post",
				data : {orderid : $orderid},
				async: false,
				dataType : "json",
				success : function(data) {
					$("#modalTitle").html("订单ID："+data[0].orderid+"&nbsp&nbsp&nbsp&nbsp&nbsp用户ID："+data[0].userid);
					$("#detailTable").html("<tr><td>商品ID</td><td>商品名</td><td>品牌</td><td>单价</td><td>数量</td></tr>");
					for($i=0;$i<data.length;$i++) {
					$("<tr><td>"+data[$i].itemid+					   
					   "</td><td>"+data[$i].itemname+
					   "</td><td>"+data[$i].brand+
					   "</td><td>"+data[$i].itemprice+
					   "</td><td>"+data[$i].quantity+
					   "</td></tr>").appendTo("#detailTable");
					};
					
				},
				error : function() {
					alert("异常");
				}
			});
		})
	});
	
	
	
	$("#skip").click(function(){
		$page = parseInt($("#skipPage").val())-1;
		$str = getRootPath_web()+"/Admin/orderManage?offset="+$page;
		$(this).attr("href", $str);
		
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


