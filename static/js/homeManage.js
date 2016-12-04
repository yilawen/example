/**
 * 
 */
$(function(){
	$("#addSubmit").click(function(){
		$.ajax({
			url : getRootPath_web()+"/admin/addItemToHome",
			data : {
				'itemid' : $("#additemid").val(),
				'flag' : $('#select option:selected') .val(),
			},
			dataType : "html",
			type : "post",
			success : function(data) {
				if(data){
					alert("添加成功！");
					$("#addItemModal").modal("hide");
					window.location.reload();	
				}
			},
			error : function() {
				alert("异常");
			}
		})
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