/**
 * 
 */
//alert("c1");
var ProgressPkid="";
var SelectDT="";
$('#extimepicker').datetimepicker({ 
	　　//minView: "month", //选择日期后，不会再跳转去选择时分秒 
	　　format: "yyyy-mm-dd hh:ii", //选择日期后，文本框显示的日期格式 
	　　language: 'zh-CN', //汉化 
	　　autoclose:true //选择日期后自动关闭 
	});

function IpSegmentFormAdd()
{
	
	//$("#liKZXX").addClass("disabled");
    //初始化表单数据///////////////////////////////////////////////
	alert("ccc");
    var parentipsegmentpkid = document.getElementById("selectedrowpkid").value;
    document.getElementById("taskname").value="";
    document.getElementById("taskclass").value="2";
    document.getElementById("taskgrade").value="2";
    document.getElementById("taskstage").value="1";
    document.getElementById("taskstartdate").value="";
    document.getElementById("taskdutyusera").value="";
    document.getElementById("taskdutyuserb").value="";
    document.getElementById("remark").value="";
    
    $('#basic').modal('show');
    /////////////////////////////////////////////////////////////////////////////
}
////////////////////////////////////////////////////////////////////////////////////
//获取Table表选中行对象的Pkid
////////////////////////////////////////////////////////////////////////////////////
function GetSelectedRowPkid(Flag)
{
	var trobj;
    var chk_value =[];
    
    $('input[type="checkbox"]:checked').each(function(){
    	if($(this).attr("name")!="EnableFlag")
    	{
            chk_value.push($(this).val());
            trobj=$(this).parents('tr');   		
    	}

    });
    //alert(chk_value.length==0 ?'你还没有选择任何内容！':chk_value); 
    if(chk_value.length==0 )
    {
    	if(Flag!="Add")
    	    alert('你还没有选择任何内容！');
    	$('#basic').modal('hide');
    	//$("#CloseBtn").click();
    	return "";
    }
    else if(chk_value.length>1)
    {
    	alert('你选择的记录太多，请选择1条记录进行修改！');
    	$('#basic').modal('hide');
    	return "";
    }
    //var $td = trobj.children('td');
    return chk_value[0];
   
}



///////////////////////////////////////////////////////////////////////////// 
function IpSegmentFormMDV()
{
	//$("#liKZXX").removeClass("disabled");
    //初始化表单数据////////////////////////////////////////////////////////////
    var trobj;
    var chk_value =[];
    var classValue="";
    var typeValue="";
    var brandValue="";
    var selectedrowpkid="";
    //获取系统详细信息///////////////////////////////////////////////////////////
    selectedrowpkid=document.getElementById("selectedrowpkid").value;
    alert(selectedrowpkid);
    selectedarray=selectedrowpkid.split("-");

    if(selectedarray.length==2)
    {
    	if(selectedarray[0]=="sub")
    	{
    		selectedrowpkid=selectedarray[1];
    	}
    	else
    	{
    		return;
    	}
    }
    $.ajax({
    	cache: false,
  	    type: "POST",
        url: "FormData/coopwork/taskplan.php",
        data: {mydate:[{'jsonrpc':'2.0','method':'get_taskplan','datatype':'','formdata':selectedrowpkid}]},     
        success: function(data){
        	//alert(data);
        	var dataObj = eval("("+data+")");
        	//alert(dataObj);
        	try
        	{
        		if(dataObj["status"]=="1")
        		{
        			//alert(dataObj["result"][0]);
        			FillInIpSegmentForm(dataObj["result"]);
        			
        			$('#basic').modal('show');
        		}
        		else
        		{
        			alert("获取任务项信息失败,"+dataObj["result"]);
        			
        		}
        	}
        	catch(err)
        	{
        		alert("获取任务项信息失败,失败信息:"+err.message);
        	}
          //返回数据后操作
        },
        error: function(){alert("获取任务项信息失败！");}
     });
    
    /////////////////////////////////////////////////////////////////////////////
}
/////////////////////////////////////////////////////////////////////////////////
//Create Segment Parent/Subnet Relationship
///////////////////////////////////////////////////////////////////////////// ///
function CreatePSRelation(ParentPkid,SubnetPkid)
{
    
    $.ajax({
    	cache: false,
  	    type: "POST",
        url: "FormData/resources/ipsegment.php",
        data: {mydate:[{'jsonrpc':'2.0','method':'mod_PSRelation','datatype':'','formdata':SubnetPkid,'parentpkid':ParentPkid}]},     
        success: function(data){
        	//alert(data);
        	//var dataObj = eval("("+data+")");
        	//alert(dataObj);

          //返回数据后操作
        },
        error: function(){
        	//alert("获取系统信息失败！");
        }
     });
    
    /////////////////////////////////////////////////////////////////////////////
}
function FillInIpSegmentForm(IpSegmentObj)
{
	//$("#liKZXX").removeClass("disabled");
    //初始化表单数据///////////////////////////////////////////////
    if(IpSegmentObj!=null)
    {

        //document.getElementById("selectedrowpkid").value=chk_value;
        
        document.getElementById("taskname").value=IpSegmentObj[0];
        document.getElementById("taskclass").value=IpSegmentObj[1];
        document.getElementById("taskgrade").value=IpSegmentObj[3];
        document.getElementById("taskstage").value=IpSegmentObj[4];
        document.getElementById("taskstartdate").value=IpSegmentObj[5];
        document.getElementById("taskdutyusera").value=IpSegmentObj[6];
        document.getElementById("taskdutyuserb").value=IpSegmentObj[7];
        document.getElementById("remark").value=IpSegmentObj[8];

        $('#basic').modal('show');
    }
    
    /////////////////////////////////////////////////////////////////////////////
    
    
}
        $("#limenu_coopwork").addClass("active open");
        $("#spanmenu_select_coopwork").addClass("selected");
        $("#spanmenu_arrow_coopwork").addClass("open");
        $("#limenu_coopwork_taskplan").addClass("active open");
        
        $('a[data-toggle="tab"]').on('click', function(){
        	  if ($(this).parent('li').hasClass('disabled')) {
        	    return false;
        	  };
        	});
        
        $('#datetimepicker').datetimepicker({
            format: 'yyyy-mm-dd hh:ii'
        });
        //alert("AddBtn");
        $("#AddBtn").on('click',function(){
        	//alert("IpSegmentFormAdd");
        	//GetInfoFromTable("sample_1");
        	//return;
        	document.getElementById("selectedrowpkid").value=GetSelectedRowPkid("Add");
        	AddIpSegment();
        	//alert("AddBtn");     	
        });
        
        
        
        
        $("#ModBtn").on('click',function(){
        	var selectedrowpkid=GetSelectedRowPkid("Mod");
        	if(selectedrowpkid=="")
        		return;
        	else
        	{
            	document.getElementById("selectedrowpkid").value=selectedrowpkid;
            	ModIpSegment();   
        	}
  	
        });  
        
        $("#DelBtn").on('click',function(){
        	var selectedrowpkid=GetSelectedRowPkid("Del");
        	if(selectedrowpkid=="")
        		return;
        	else
        	{
            	document.getElementById("selectedrowpkid").value=selectedrowpkid;
            	DelIpSegment();
        	}
        	
        	//alert("DelBtn");     	
        });  
        
        $("#ViewBtn").on('click',function(){
        	var selectedrowpkid=GetSelectedRowPkid("View");
        	if(selectedrowpkid=="")
        		return;
        	else
        	{
            	document.getElementById("selectedrowpkid").value=selectedrowpkid;
            	ViewIpSegment();
        	}
    	
        }); 

        
        
        function AddIpSegment(){
        	IpSegmentFormAdd();
        	document.getElementById("opType").value="Add";
        	
        	$("#formtitle").html('<i class="icon-magnifier"></i>添加[任务项]信息'); //赋值
        	//$("#formtitle").attr("class","modal-title font-blue");
        	//$("#SaveBtn").attr("class","btn blue");
            $("#SaveBtn").attr("value","添加");
            $("#SaveBtn").attr("type","submit");
            $("#SaveBtn").removeAttr("disabled");
            $("#ResetBtn").removeAttr("disabled");
        }
        
        function ModIpSegment(){
        	IpSegmentFormMDV();
        	document.getElementById("opType").value="Mod";
        	$("#formtitle").html('<i class="icon-magnifier"></i>修改[任务项]信息'); //赋值
        	//$("#formtitle").attr("class","modal-title font-purple");
        	//$("#SaveBtn").attr("class","btn purple");
        	$("#SaveBtn").attr("value","修改");
        	$("#SaveBtn").attr("type","submit");
        	$("#SaveBtn").removeAttr("disabled");
        	$("#ResetBtn").removeAttr("disabled");	
        }
        
        function DelIpSegment(){
        	IpSegmentFormMDV();
        	document.getElementById("opType").value="Del";
        	$("#formtitle").html('<i class="icon-magnifier"></i>删除[任务项]信息'); //赋值
 
        	$("#SaveBtn").attr("value","删除");
        	$("#SaveBtn").attr("type","submit");
        	$("#SaveBtn").removeAttr("disabled");
        	$("#ResetBtn").attr("disabled","disabled");     	
        }
       
        function ViewIpSegment(){
        	IpSegmentFormMDV();
        	document.getElementById("opType").value="View";
        	$("#formtitle").html('<i class="icon-magnifier"></i>查看[任务项]信息'); //赋值
        	//$("#formtitle").attr("class","modal-title font-green");
        	//$("#SaveBtn").attr("class","btn green");
        	$("#SaveBtn").attr("value","查看");
        	$("#SaveBtn").attr("type","button");
        	$("#SaveBtn").attr("disabled","disabled");
        	$("#ResetBtn").attr("disabled","disabled");     	    
        }
        
        
        $("#IpPartBtn").on('click',function(){

        	//alert("lll");
        	window.open('resources_ippart.php','Derek','height=768,width=1024,top=60,left=60,status=no,toolbar=no,menubar=no,scrollbars=yes,location=no');
        	//window.location = "resources_ippart.php";

        });
        
        $("#PlanBtn").on('click',function(){

        	//alert("lll");
        	window.open('coopwork_planinfor.php','Derek','height=768,width=1250,top=20,left=20,status=no,toolbar=no,menubar=no,scrollbars=yes,location=no');
        	//window.location = "resources_ippart.php";

        });       
        $("#ImportBtn").on('click',function(){

        	//alert("lll");
        	window.open('coopwork_taskimport.php','Derek','height=500,width=1000,top=60,left=60,status=no,toolbar=no,menubar=no,scrollbars=no,location=no');
        	//window.location = "resources_ippart.php";

        });        
        $("#ResetBtn").on('click',function(){
        	if(document.getElementById("opType").value=="Add")
        	{
        		FormAdd();
        	}
        	if(document.getElementById("opType").value=="Mod")
        	{
        		FormMDV();
        	}
    	
        });
        
        $('#basic').on('hide.bs.modal', function () {
        	var form1 = $('#form_base');
            var error1 = $('.alert-danger', form1);
            var success1 = $('.alert-success', form1);
            error1.hide();
            success1.hide();
         });

        var selectNodeId="";
        var targetNodeId="";
        function myMouseDown(event)
        {
        	//var x=event.clientX;
        	//var y=event.clientY;
        	var tempNodeId=$(event.target).attr('id');
        	if(tempNodeId.indexOf('_anchor')>=0)
        		selectNodeId=tempNodeId.replace("_anchor","");
        	else if(tempNodeId.indexOf('Area')>=0)
        	{
                selectNodeId="";
                targetNodeId="";
        	}
        	//alert(selectNodeId);
        }
        function myMouseUp(event)
        {
        	//var x=event.clientX;
        	//var y=event.clientY;
        	var tempNodeId=$(event.target).attr('id');
        	
        	if(tempNodeId.indexOf('_anchor')>=0)
        	{
        		targetNodeId=tempNodeId.replace("_anchor","");
        	}	
        	else if(tempNodeId.indexOf('Area')>=0)
        	{
                selectNodeId="";
                targetNodeId="";
        	}
        	if(selectNodeId!="" && targetNodeId!="" && selectNodeId!=targetNodeId)
        	{
        		//$('body').trigger("click");
        		CreatePSRelation(targetNodeId,selectNodeId);
        		//alert(selectNodeId + "|" +targetNodeId);
        	    //event.target=null;
                //event.srcElement=null;
            	//event.preventDefault();
            	//event.stopPropagation();
   
                //event.returnValue = true;
                //event.cancelBubble = true;
                //event.target=null;
                //event.srcElement=null;
                
                
        	}
        	else if(selectNodeId!="" && targetNodeId!="" && selectNodeId==targetNodeId)
        	{
                selectNodeId="";
                targetNodeId="";
        	}
        		
        	//alert(selectNodeId);
        }
        $('body').click(function(e){
        	//alert("IPSegment_tree");
        });
        function myBlur(event)
        {
            selectNodeId="";
            targetNodeId="";
            //alert("myBlur");
        }
        /*
        $("#IPSegment_tree").mousedown(function(e) {
        	
        	alert("cc");
        	return;
            e = e || window.event;
            var target = e.target || e.srcElement;
             
            // 如果id不是div2就返回
            if(target.id !== 'div2') {
                return;
            }
            // 执行函数
            func();
             
            // 阻止默认行为并取消冒泡
            if(typeof e.preventDefault === 'function') {
                e.preventDefault();
                e.stopPropagation();
            }else {
                e.returnValue = false;
                e.cancelBubble = true;
            }
        }) ;*/


$(function(){
	
    $.contextMenu({
        selector: '#taskplan_tree', 
        onContextMenu: function(e) {
        	alert("onContextMenu");
        	/*
            if ($(e.target).attr('id') == 'dontShow') return false;
            else return true;*/
          },
          onShowMenu: function(e, menu) {
        	  alert("onShowMenu");
        	  
        	  /*
              if ($(e.target).attr('id') == '') {
                $('#edit,  menu).remove();
              }
              return menu;
              */
        	  
            },
        build: function($trigger, e) {
        	
            // this callback is executed every time the menu is to be shown
            // its results are destroyed every time the menu is hidden
            // e is the original contextmenu event, containing e.pageX and e.pageY (amongst other data)
            //alert($(e.target).attr('id'));
            selectNodeId=$(e.target).attr('id');
            
            selectNodeId=selectNodeId.replace("_anchor","");
            //alert(selectNodeId);
            document.getElementById("selectedrowpkid").value=selectNodeId;
            //alert("ccc");
            //$('#sys_tree').jstree(true).select_node($(e.target).attr('id'));
            return {
                callback: function(key, options) {
                	switch(key)
                	{
            	        case "open":
            	        	//alert("open");
            		        break;                	
                	    case "add":

                	    	//alert("add");
                	    	AddIpSegment();
                		    break;
                	    case "edit":
                	    	//alert("edit");
                	    	ModIpSegment();
                		    break;
                	    case "delete":
                	    	DelIpSegment();
                	    	//alert("delete");
                		    break;
                	    case "view":
                	    	ViewIpSegment();
                	    	//alert("delete");
                		    break;                		    
                	    default:
                	    	alert("default");
                		    break;                		    
                	}
                	//var ref = $('#sys_tree').jstree(true);
                	//newselectNodeId=selectNodeId+"1";
                	//sel = ref.create_node(selectNodeId, {"id":newselectNodeId,"text":"newnode"});
                	
                	//var id = $("#sys_tree").jstree('create_node', CurrentNode, "inside", { "data":"new_node" }, false, true);
                	//var m = "clicked: " + key;
                	//alert(m);
                    //window.console && console.log(m) || alert(m); 
                },

                items: {
                	"add": {name: "添加", icon: "add"},
                    "edit": {name: "修改", icon: "edit"},
                    "delete": {name: "删除", icon: "delete"},
                    "view": {name: "查看", icon: "view"}
                }
            };
        }
    });
});


function UpdateProgress(ProgressPercentage)
{
	progreeStr="";
	progreeStr="<div class='progress progress-striped active' style='height:15px;margin-bottom: 5px;'>";
	progreeStr=progreeStr+"<div class='progress-bar progress-bar-info' role='progressbar' aria-valuenow='"+ProgressPercentage+"' aria-valuemin='0' aria-valuemax='100' style='height:15px;width: "+ProgressPercentage+"%'>";
	//progreeStr=progreeStr+"<span class='sr-only'> 20% Complete </span>";
	progreeStr=progreeStr+ "</div>";   
	progreeStr=progreeStr+ "</div>";  
	SelectDT.eq(4).html(progreeStr);
}

function GetProgress()
{
	//alert("GetProgress");
	$.ajax({
    	cache: false,
  	    type: "POST",
  	    //async: false,
        url: "http://localhost/FormData/mtools/discovery.php",
        data: {mydate:[{'datatype':'base','method':'Get_Pregress','formdata':ProgressPkid}]},     
        success: function(data){
        	try
        	{
        		//alert(data);
            	var dataObj = eval("("+data+")");
            	
            	if(dataObj["status"]=="1")
            	{
            		
            		if(dataObj["code"]=="100")
            		{
            			//结束定时器
            			$('body').stopTime();
            			UpdateProgress(dataObj["code"]);
            			SelectDT.eq(6).html("空闲中");
            			$('body').oneTime('1s','D',function(){
                   			var Currtent=new Date();
                			//alert(Currtent.getYear());
                			SelectDT.eq(4).html(Currtent.toLocaleTimeString());
            				});
 
            		}
            		else
            		{
            			UpdateProgress(dataObj["code"]);
            		}

            	}

        	}
        	catch(err)
        	{
        		//alert("手动调用["+$td.eq(1).text()+"]设备自动发现规则异常！"+err.message);
        	}

        
        },//success
        error: function(){
        	alert("手动调用["+$td.eq(1).text()+"]设备自动发现规则失败失败，请检查服务端运行是否正常。");
        }
     });
}

function IsExistDiscoveryTask()
{
	var IsExist="false";
	$("#sample_1 tr").each(function(trindex,tritem){
		var $td = $(tritem).children('td');
		if($td.eq(6).text()=="执行中")
		{
			IsExist= "true";
		}

	});  
	return IsExist;
}

/*
$(document).ready(function() {
	$("#sample_1 tr").each(function(trindex,tritem){
		var $td = $(tritem).children('td');
		if($td.eq(6).text()=="执行中")
		{
			//alert($td.eq(6).text());
			var $selectcheckbox = $(tritem).find('input');
			ProgressPkid=$selectcheckbox.val();
			SelectDT=$td;
			GetProgress();
			$('body').everyTime('10s',GetProgress);
			return;
			//var $selectcheckbox = $td.eq(0).find('input');
			//alert($selectcheckbox.value)
		}
		else
		{
			//alert($td.eq(6).text());
			//var $selectcheckbox = $(tritem).find('input');
			//var $selectcheckbox = $td.eq(0).find('label').find('input');
			//alert($selectcheckbox.val())
		}
		//alert($td.eq(6).text());
	});
    
	// 任何需要执行的js特效
	//$("table tr:nth-child(even)").addClass("even");
}); 
*/
/////////////////////////////////////////////////////////////////////////////////////
//开始执行
/////////////////////////////////////////////////////////////////////////////////////
$("#handaction").on('click',function(){
    
    
    $.ajax({
    	cache: false,
  	    type: "POST",
  	    //async: false,
        url: "/FormData/mtools/discovery.php",
        data: {mydate:[{'datatype':'base','method':'handaction_discoveryipsegment','formdata':''}]},     
        success: function(data){
        	try
        	{
        		//alert(data);
            	var dataObj = eval("("+data+")");
            	
            	if(dataObj["status"]=="1")
            	{
            		alert("手动调用自动发现IP网段、地址成功！");
            	}
            	else if(dataObj["status"]=="0") 
            	{
            		alert("手动调用自动发现IP网段、地址失败！");
            	}
        	}
        	catch(err)
        	{
        		alert("手动调用自动发现IP网段、地址出现异常！"+err.message);
        	}

        
        },//success
        error: function(){
        	alert("手动调用自动发现IP网段、地址失败，请检查服务端运行是否正常。");
        }
     });
});