<?php
/* Smarty version 3.1.29, created on 2017-08-13 13:08:34
  from "E:\wamp\www\Smarty\templates\coopwork\taskplan.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_598fded25c8738_34277390',
  'file_dependency' => 
  array (
    '03e3184b143aace45212db92d6afd957aa2a8283' => 
    array (
      0 => 'E:\\wamp\\www\\Smarty\\templates\\coopwork\\taskplan.html',
      1 => 1502182561,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:mainmenu.html' => 1,
    'file:footer2.html' => 1,
  ),
),false)) {
function content_598fded25c8738_34277390 ($_smarty_tpl) {
$_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:mainmenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<link href="style/jQuery-contextMenu/dist/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
            <meta charset="utf-8" />
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    
                    <!-- BEGIN PAGE BAR -->
                    <div id="page-bar1" name="page-bar1" class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="index.php">首页</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="mtools_discovery.php">协同办公</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span>任务计划</span>
                            </li>
                        </ul>
                        <!-- <a class="pull-right" style="margin-top:10px" data-toggle="tooltip" title="Example tooltip"><i class="fa fa-random"></i>切换到发现的设备</a> -->
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <!-- <h3 class="page-title"> Dashboard
                        <small>dashboard & statistics</small>
                    </h3> -->
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->
                    <!-- BEGIN DASHBOARD STATS 1-->
                    <div class="row" id="DiscoveryRules" name="DiscoveryRules" style="margin-top:5px">
                         <div class="col-md-3" >
                         <div class="portlet light bordered" style="margin-left:-5px">
                                <div class="portlet-body" style="margin-left:-10px">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#equip_1_1" data-toggle="tab">任务项目录树 </a>
                                        </li>
                                      
                                    </ul>
                                    <div  class="tab-content">
                                        <div class="tab-pane fade active in" id="equip_1_1">
                                        <div class="portlet-body">
                                             <div id="taskplan_tree" class="ipsegmenttree" onmousedown="myMouseDown(event);" onmouseup="myMouseUp(event);"> </div><!--  onblur="myBlur(event);" -->
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9" >
                        
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet   ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        
                                        <span class="caption-subject font-green sbold uppercase"><i class="icon-equalizer font-green"></i> 任务项列表</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided" ><!-- 
                                            <a id="AddBtn" class="btn blue btn-outline sbold" data-toggle="modal" href=""><i class="fa fa-plus"></i> 添加 </a>
                                            <a id="ModBtn" class="btn purple btn-outline sbold" data-toggle="modal" href=""><i class="fa fa-pencil"></i> 修改 </a>
                                            <a id="DelBtn" class="btn red btn-outline sbold" data-toggle="modal" href=""><i class="fa fa-remove"></i> 删除 </a>
                                            <a id="ViewBtn" class="btn green btn-outline sbold" data-toggle="modal" href=""><i class="fa fa-road"></i> 查看 </a> -->
                                            <a id="PlanBtn" name="PlanBtn" class="btn blue btn-outline sbold" data-toggle="tooltip" title="管理任务分解、计划和 执行情况"><i class="fa fa-random"></i> 任务分解、计划 </a>
                                            <a id="ImportBtn" name="ImportBtn" class="btn green-jungle btn-outline sbold" data-toggle="tooltip" title="导入任务项"><i class="fa fa-random"></i> 导入任务项 </a>
                                        </div>

                                        <div class="btn-group">
                                            <a class="btn yellow btn-outline " href="javascript:;" data-toggle="dropdown">
                                                <i class="fa fa-share"></i>
                                                <span class="hidden-xs"> 数据导出工具 </span>
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right" id="sample_1_tools">
                                                <li>
                                                    <a href="javascript:;" data-action="0" class="tool-action">
                                                        <i class="fa fa-print"></i> 打印</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-action="1" class="tool-action">
                                                        <i class="fa fa-copy"></i> 复制</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-action="2" class="tool-action">
                                                        <i class="fa fa-file-pdf-o"></i> PDF文件</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-action="3" class="tool-action">
                                                        <i class="fa fa-file-excel-o"></i> Excel文件</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-action="4" class="tool-action">
                                                        <i class="fa fa-file-archive-o"></i> CSV文件</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1" name="sample_1">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center" data-field="id">
                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                        <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                                        <span></span>
                                                    </label>
                                                </th>
                                                <th class="all" style="text-align: center" data-field="name">任务项名称</th>
                                                <th class="min-tablet" style="text-align: center" data-field="segment">分类</th>
                                                <th class="min-phone-l"style="text-align: center" data-field="equipment">等级</th>                                                
                                                <th class="min-phone-l" style="text-align: center"  data-field="vlan">阶段</th>
                                                <th class="min-phone-l" style="text-align: center"  data-field="location">开始日期</th>
                                                <th class="min-phone-l" style="text-align: center"  data-field="createdate">负责人A</th>
                                                <th class="none" style="text-align: center"  data-field="remark">负责人B</th> 
                                                <!-- <th class="none">下次执行时间</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo $_smarty_tpl->tpl_vars['tabledata']->value;?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->

                        </div>
                    </div>                  
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->

               

                                    <!--  draggable-modal -->
                                    <div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>           
                                                    <h4 id="formtitle" class="modal-title font-green"><i class="icon-magnifier"></i>添加设备自动发现规则</h4>
                                                </div>
                                                <div class="modal-body"> 
                                                
                                                
                                                

                   <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN VALIDATION STATES-->
                            <!-- 
                                   <div class="portlet light " style="margin-top:-15px">
                                        <div class="portlet-title tabbable-line light">
                                            <ul class="nav nav-tabs">
                                                <li class="active">
                                                    <a href="#portlet_tab_1_1" data-toggle="tab" > 基本信息 </a>
                                                </li>
                                                
                                                <li id="liKZXX" type="hidden">
                                                    <a href="#portlet_tab_1_2" data-toggle="tab"> 扩展信息 </a>
                                                </li> 
                                            </ul>
                                        </div>
                                    </div>-->
         
                   <div class="portlet-body form" style="margin-top:-10px"> <!--  style="margin-top:-40px" -->
                        <div class="tab-content">
                             <div class="tab-pane active" id="portlet_tab_1_1" >
                                          
                                    <!-- BEGIN FORM-->
                                    <form action="#" id="form_base" class="form-horizontal"  >
                                        <div class="form-body" >
                                            <div class="alert alert-danger display-hide">
                                                <button class="close" data-close="alert"></button> <label id="alertdangerlabel" name="alertdangerlabel">任务项信息输入有问题， 请确认。</label> </div>
                                            <div class="alert alert-success display-hide">
                                                <button class="close" data-close="alert"></button> <label id="alertsuccesslabel" name="alertsuccesslabel">任务项信息保存成功!</label>  
                                                <input type="hidden" name="selectedrowpkid"  id="selectedrowpkid" value="">
                                                <input type="hidden" name="opType"  id="opType" value="">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">任务项名称
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="text" name="taskname" id="taskname" data-required="1" class="form-control" /> 
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">分类
                                                </label>
                                                <div class="col-md-8">
                                                    <select class="form-control" id="taskclass"  name="taskclass" > <!--  onchange="RefreshTypeSelect(this.value)"-->
                                                        <option value="1" selected='true'>日常工作</option>
                                                        <option value="2" >系统集成</option>
                                                        <option value="3" >经营项目</option>
                                                        <option value="4" >科研项目</option>
                                                        <option value="5" >前瞻课题</option>
                                                        <option value="6" >临时任务</option>
                                                        <option value="9" >其他</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="control-label col-md-3">级别
                                                </label>
                                                <div class="col-md-8">
                                                    <select class="form-control" id="taskgrade"  name="taskgrade" > <!--  onchange="RefreshTypeSelect(this.value)"-->
                                                        <option value="1" >重点</option>
                                                        <option value="2" selected='true'>常规</option>
                                                        <option value="9" >其他</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="control-label col-md-3">阶段
                                                </label>
                                                <div class="col-md-8">
                                                    <select class="form-control" id="taskstage"  name="taskstage" > <!--  onchange="RefreshTypeSelect(this.value)"-->
                                                        <option value="1" selected='true'>立项</option>
                                                        <option value="2" >可研</option>
                                                        <option value="3" >建设</option>
                                                        <option value="4" >完成</option>
                                                        <option value="5" >运维</option>
                                                        <option value="6" >下线</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="control-label col-md-3">启动日期
                                                   
                                                </label>
                                                <div class="col-md-8">
                                                    <div id="systemtimepicker" class="input-group input-medium date" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                        <input id="taskstartdate" name="taskstartdate" class="form-control" readonly type="text">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="control-label col-md-3">管理A角
                                                    
                                                </label>
                                                <div class="col-md-8">
                                                    <select class="form-control" id="taskdutyusera" name="taskdutyusera" > <!--  onchange="RefreshTypeSelect(this.value)"-->
                                                        <option value="">请选择负责人A角...</option> 
                                                        <?php echo $_smarty_tpl->tpl_vars['userlist']->value;?>

                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="control-label col-md-3">管理B角
                                                   
                                                </label>
                                                <div class="col-md-8">
                                                    <select class="form-control" id="taskdutyuserb" name="taskdutyuserb" > <!--  onchange="RefreshTypeSelect(this.value)"-->
                                                        <option value="">请选择负责人B角...</option> 
                                                        <?php echo $_smarty_tpl->tpl_vars['userlist']->value;?>

                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="control-label col-md-3" name="remarklabel" id="remarklabel">备注

                                                </label>
                                                <div class="col-md-8">
                                                    <input name="remark" id="remark" type="text" class="form-control" placeholder="请输入备注信息" />
                                                </div>
                                            </div>                         
                                        </div>
                                        <!-- <div class="form-actions"> -->
                                            <div class="row">
                                            <!--  
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="submit" class="btn green">Submit</button>
                                                    <button type="button" class="btn grey-salsa btn-outline">Cancel</button>
                                                </div>-->
                                                <div class=" col-md-11">
                                                    <div style="float:right;margin-top:-14px;margin-right:16px">
                                                        <input id="SaveBtn" name="SaveBtn" type="submit" class="btn green" value="保存"></input>
                                                        <input id="ResetBtn" name="ResetBtn" type="button" class="btn yellow" value="重置"></input>
                                                    	<input id="CloseBtn" name="CloseBtn" type="button" class="btn red" data-dismiss="modal" value="关闭"></input>
                                                    	
                                                    </div>
                                                </div>
                                            </div>
                                        <!--</div>-->
                                    </form>
                                    <!-- END FORM-->
                            </div>
                            <div class="tab-pane active" id="portlet_tab_1_2">
                            </div>
 
                        </div> 
                                    
                                </div>
                             
                            <!-- END VALIDATION STATES-->
                        </div>
                    </div>    
                                                
                                                </div>

                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>

        <style>
<!--

-->
</style>

<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer2.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<!-- BEGIN PAGE LEVEL SCRIPTS -->
    <?php echo '<script'; ?>
 src="style/AjaxData/coopwork/taskplan-form-validation.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="style/AjaxData/coopwork/taskplan-datatables-responsive.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="style/AjaxData/coopwork/taskplan-tree.js" type="text/javascript"><?php echo '</script'; ?>
>

    <!--<?php echo '<script'; ?>
 src="style/assets/pages/scripts/ui-modals.js" type="text/javascript"><?php echo '</script'; ?>
> -->
        <!-- END PAGE LEVEL SCRIPTS -->

        <!-- BEGIN PAGE LEVEL PLUGINS -->

        <?php echo '<script'; ?>
 src="style/assets/global/plugins/moment.min.js" type="text/javascript"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="style/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="style/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="style/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="style/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="style/assets/global/plugins/clockface/js/clockface.js" type="text/javascript"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="style/assets/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" type="text/javascript"><?php echo '</script'; ?>
>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        
        <?php echo '<script'; ?>
 src="style/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"><?php echo '</script'; ?>
>
        <!-- END PAGE LEVEL SCRIPTS -->
        <?php echo '<script'; ?>
 src="style/AjaxData/jquery.timers.js" type="text/javascript"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="style/AjaxData/coopwork/taskplan-custom.js" type="text/javascript"><?php echo '</script'; ?>
>
        <!-- END THEME LAYOUT SCRIPTS -->
        <?php echo '<script'; ?>
 src="style/jQuery-contextMenu/src/jquery.contextMenu.js" type="text/javascript"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="style/jQuery-contextMenu/dist/jquery.ui.position.min.js" type="text/javascript"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="style/jQuery-contextMenu/documentation/website/js/main.js" type="text/javascript"><?php echo '</script'; ?>
>
        
       
<?php echo '<script'; ?>
>
$('#systemtimepicker').datepicker({ 
	　　//minView: "month", //选择日期后，不会再跳转去选择时分秒 
	　　format: "yyyy-mm-dd", //选择日期后，文本框显示的日期格式 
	　　language: 'zh-CN', //汉化 
	　　autoclose:true //选择日期后自动关闭 
	});


$('#project_tree').on('dblclick',function(event){
	event.preventDefault();
	//alert("Hello World!");
	//alert(JSON.stringify(node));
	//var inst = $.jstree.reference(node.reference),
	//obj = inst.get_node(node.reference);
	//inst.edit(obj);
	var paraStr = $(event.target).parents('li').attr('id');
	//var textstr = $(event.target).parents('li').attr('text');
	//var eventNodeName = event.target.nodeName;
	//alert(paraStr);
	
	window.open('resources_ipaddressinfor.php?ipsegmentpkid='+paraStr,'Derek','height=768,width=1024,top=60,left=60,status=no,toolbar=no,menubar=no,scrollbars=yes,location=no');
	/*
	var paraArray=paraStr.split("|-|");
	if(paraArray.length>0)
	{
		if(paraArray[0]=="equipment")
		{

			document.getElementById("equipmentlist").style.display="none";//显示
			document.getElementById("equipmentinforpage").style.display="";//显示
			DealDBLEquipment(paraArray[1],paraArray[2]);
		}
	}*/
	//alert("Double Click id->:"+id);
	//alert("Double Click text->:"+eventNodeName);
	
});

$('#handaction').on('click',function(event){
	
    var formdata="";
	$.ajax({
		cache: false,
		    type: "POST",
		    //async: false,
	    url: "FormData/resources/ipsegment.php",
	    data: {mydate:[{'datatype':'base','method':'discovery_ipsegment','formdata':formdata}]},     
	    success: function(data){
	    	try
	    	{
	    		//alert(data);
	        	var dataObj = eval("("+data+")");
	        	
	        	if(dataObj["status"]=="1")
	        	{
	        		alert("手动调用自动发现网段任务成功！该任务在后台需要执行一段时间，请勿频繁执行！");
	        	}
	        	else if(dataObj["status"]=="0") 
	        	{
	        		alert("手动调用自动发现网段任务失败！");
	        	}
	    	}
	    	catch(err)
	    	{
	    		alert("手动调用自动发现网段任务异常！"+err.message);
	    	}

	    
	    },//success
	    error: function(){
	    	alert("手动调用自动发现网段任务异常，请检查服务端运行是否正常。");
	    }
	 });
});

$('#rebuildipsegmenttree').on('click',function(event){
	
    var formdata="";
	$.ajax({
		cache: false,
		    type: "POST",
		    //async: false,
	    url: "FormData/resources/ipsegment.php",
	    data: {mydate:[{'datatype':'base','method':'rebuild_ipsegmenttree','formdata':formdata}]},     
	    success: function(data){
	    	try
	    	{
	    		//alert(data);
	        	var dataObj = eval("("+data+")");
	        	
	        	if(dataObj["status"]=="1")
	        	{
	        		alert("手动调用重建IP网段目录树任务成功！该任务在后台需要执行一段时间，请勿频繁执行！");
	        	}
	        	else if(dataObj["status"]=="0") 
	        	{
	        		alert("手动调用重建IP网段目录树任务失败！");
	        	}
	    	}
	    	catch(err)
	    	{
	    		alert("手动调用重建IP网段目录树任务异常！"+err.message);
	    	}

	    
	    },//success
	    error: function(){
	    	alert("手动调用重建IP网段目录树任务异常，请检查服务端运行是否正常。");
	    }
	 });
});

<?php echo '</script'; ?>
><?php }
}
