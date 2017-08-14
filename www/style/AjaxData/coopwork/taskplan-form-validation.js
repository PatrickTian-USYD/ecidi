
function TableModRow()
{
	
	//定位选中的记录///////////////////////////////////////////////
    var trobj=null;
    var chk_value =[];
    var equipmentname="";
    $('input[type="checkbox"]:checked').each(function(){
    	if($(this).attr("name")!="EnableFlag")
    	{
    		chk_value.push($(this).val());
    		trobj=$(this).parents('tr');
    	}
    });
    
    if(trobj==null)
    {
    	var SelectedRowPkid=document.getElementById("selectedrowpkid").value;
    	selectedarray=SelectedRowPkid.split("-");
    	//alert(SelectedRowPkid);
    	if(selectedarray.length==2)
    	{
        	SelectedRowPkid=selectedarray[1];
        	trobj=GetRowByPkid(SelectedRowPkid);
    	}
    	else
    		return;
    }
    
    //alert(chk_value);
    if(trobj!=null)
    {
        var $td = trobj.children('td');
        $td.eq(1).html(document.getElementById("taskname").value);
        
        TaskClass=$("#taskclass").find("option:selected").text();
        TaskGrade=$("#taskgrade").find("option:selected").text();
        TaskStage=$("#taskstage").find("option:selected").text();
        
        $td.eq(2).html(TaskClass);
        $td.eq(3).html(TaskGrade);
        $td.eq(4).html(TaskStage);
        
        $td.eq(5).html(document.getElementById("taskstartdate").value);
        $td.eq(6).html(document.getElementById("taskdutyusera").value);
        $td.eq(7).html(document.getElementById("taskdutyuserb").value);
    }


    //alert("TableUpdate");
    /////////////////////////////////////////////////////////////////////////////
}
var tempObj;
function GetRowByPkid(SelectedRowPkid) {
	
	tempObj=null;
   $('input[type="checkbox"]').each(function(){
   	if($(this).attr("name")!="EnableFlag")
   	{
   		if($(this).val()==SelectedRowPkid)
   		{
   			//alert("find");
   			tempObj = $(this).parents('tr');
   		}
   	}
   });
   
   return tempObj;
}

function TableAddRow(newrowPkid)
{
	var rowdata;
	var equipmentname="";
    var myDate = new Date();

    rowdata="<tr>";
    rowdata=rowdata+"<td style='text-align: center;'><label class='mt-checkbox mt-checkbox-single mt-checkbox-outline'><input type='checkbox' class='checkboxes' value='"+newrowPkid+"' /><span></span></label></td>";    
    rowdata=rowdata+"<td style='word-wrap:break-word;'>"+document.getElementById("taskname").value+"</td>";
    TaskClass=$("#taskclass").find("option:selected").text();
    TaskGrade=$("#taskgrade").find("option:selected").text();
    TaskStage=$("#taskstage").find("option:selected").text();
    rowdata=rowdata+"<td style='text-align: center;word-wrap:break-word;'>"+TaskClass+"</td>";
    rowdata=rowdata+"<td style='text-align: center;word-wrap:break-word;'>"+TaskGrade+"</td>";
    rowdata=rowdata+"<td style='text-align: center;word-wrap:break-word;'>"+TaskStage+"</td>";
    rowdata=rowdata+"<td style='text-align: center;word-wrap:break-word;'>"+document.getElementById("taskstartdate").value+"</td>";
    rowdata=rowdata+"<td style='text-align: center;word-wrap:break-word;'>"+document.getElementById("taskdutyusera").value+"</td>";
    rowdata=rowdata+"<td style='text-align: center;word-wrap:break-word;display:none;'>"+document.getElementById("taskdutyuserb").value+"</td>";
    rowdata=rowdata+"</tr>"; 
    $("#sample_1").prepend(rowdata);
    //$("#sample_1").resetView();
    //$("#sample_1").append(rowdata);
    //$(rowdata).insertAfter($("#sample_1 tr:eq(0)"));   
    
    //var data = {"id": newrowPkid, "name": document.getElementById("segmentname").value,"segment":document.getElementById("netaddress").value,equipment:'',"vlan":'',"location":'', "remark": ''}; //define a new row data，certainly it's empty 
    //$('#sample_1').bootstrapTable('prepend', data); 
}
function TableDelRow()
{
	//定位选中的记录///////////////////////////////////////////////
    var trobj=null;
    var chk_value =[];
    
    $('input[type="checkbox"]:checked').each(function(){
         chk_value.push($(this).val());
         trobj=$(this).parents('tr');
         trobj.remove();
    });
    
    if(trobj==null)
    {
    	var SelectedRowPkid=document.getElementById("selectedrowpkid").value;
    	trobj=GetRowByPkid(SelectedRowPkid);
    	trobj.remove();
    }
 
}



var FormValidation = function () {

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#form_base');
            var error1 = $('.alert-danger', form1);
            var success1 = $('.alert-success', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                messages: {
                    select_multi: {
                        maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                        minlength: jQuery.validator.format("At least {0} items must be selected")
                    }
                },
                rules: {
                    taskname: {
                        minlength: 2,
                        maxlength: 30,
                        required: true
                    },
                    taskclass: {
                        required: true
                    },
                    taskgrade: {
                    	required: true
                    },
                    taskstage: {
                    	required: true
                    },
                    taskdutyusera: {
                    	required: true
                    },
                    taskdutyuserb: {
                    	required: true
                    },
                    remark: {
                        maxlength: 300
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success1.hide();
                    error1.show();
                    App.scrollTo(error1, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
                },

                submitHandler: function (form) {
                    
                    error1.hide();
                    var formdata=$('#form_base').serialize();
                    formdata=decodeURIComponent(formdata,true);
                    

                    //alert("lll");
                	if(document.getElementById("opType").value=="Add")
                	{
                		$.ajax({
                        	cache: false,
                      	    type: "POST",
                            url: "FormData/coopwork/taskplan.php",
                            data: {mydate:[{'datatype':'base','method':'add_taskplan','formdata':formdata}]},     
                            success: function(data){
                            	try
                            	{
                            		//alert(data);
                                	var dataObj = eval("("+data+")");
                                	
                                	if(dataObj["status"]=="1")
                                	{
                                		$("#alertsuccesslabel").html('添加[任务项]成功。');
                                		//To add a row of records in a table
                                		TableAddRow(dataObj["result"]);
                                		//Add a node to the tree
                                		var newPkid=dataObj["result"];
                                		var showname="";
                                		showname = document.getElementById("taskname").value;
                                		
                                		
                                		selectedRowPkid=document.getElementById("selectedrowpkid").value;
                                    	var ref = $('#taskplan_tree').jstree(true);
                                    	//alert(selectedRowPkid);
                                    	if(selectedRowPkid=="")
                                    	{
                                    		sel = ref.create_node(null, {"id":newPkid,"text":showname});
                                    	}
                                    	else
                                    	{
                                        	var selectednode= ref.get_node({"id":selectedRowPkid});
                                        	if(ref.is_loaded(selectednode))
                                        	{
                                            	sel = ref.create_node(selectednode, {"id":newPkid,"text":showname});
                                        	}
                                    	}

                                		
                                		
                                	}
                                	else if(dataObj["status"]=="0") 
                                	{
                                		$("#alertsuccesslabel").html('添加[任务项]失败，请检查服务端运行是否正常。');
                                	}
                            	}
                            	catch(err)
                            	{
                            		$("#alertsuccesslabel").html('添加[任务项]异常，异常信息如下：');
                            		alert(err.message +"|" + err.description);
                            	}

                            
                            },//success
                            error: function(){
                            	$("#alertsuccesslabel").html('添加[任务项]失败，请检查服务端运行是否正常。');
                            }
                         });
                	}
                	if(document.getElementById("opType").value=="Mod")
                	{
                		$.ajax({
                        	cache: false,
                      	    type: "POST",
                            url: "FormData/coopwork/taskplan.php",
                            data: {mydate:[{'datatype':'base','method':'mod_taskplan','formdata':formdata}]},     
                            success: function(data){
                            	try
                            	{
                                	var dataObj = eval("("+data+")");
                                	//alert(dataObj["status"]);
                                	if(dataObj["status"]=="1")
                                	{
                                		$("#alertsuccesslabel").html('修改[任务项]成功。');
                                		//Update row record information
                                		TableModRow();
                                		//Update node in tree
                                		var showname="";
                                		showname = document.getElementById("taskname").value;

                                		var selectedRowPkid="";
                                		selectedRowPkid=document.getElementById("selectedrowpkid").value;
                                    	var ref = $('#taskplan_tree').jstree(true);
                                    	var selectednode= ref.set_text(selectedRowPkid,showname);
                                    	/*
                                    	var selectednode= ref.get_node({"id":selectedRowPkid});
                                    	var parentPkid = document.getElementById("parentipsegment").value;
                                    	if(parentPkid=="")
                                    	{
                                    		ref.move_node(selectednode,null);
                                    	}
                                    	else
                                    	{
                                    		var parentnode= ref.get_node({"id":parentPkid});
                                    		ref.move_node(selectednode,parentnode);
                                    	}*/
                                    	
                                	}
                                	else if(dataObj["status"]=="0") 
                                	{
                                		$("#alertsuccesslabel").html('修改[任务项]失败，请检查服务端运行是否正常。');
                                	}
                            	}
                            	catch(err)
                            	{
                            		$("#alertsuccesslabel").html('修改[任务项]异常，异常信息如下：'+err.message +"|" + err.description);
                            		//alert(err.message +"|" + err.description);
                            	}
                            	//alert(data);
                            	
                            
                            },//success
                            
                            error: function(){$("#alertsuccesslabel").html('修改[任务项]失败，请检查服务端运行是否正常。'); }
                         });
                	}
                	if(document.getElementById("opType").value=="Del")
                	{
                		$.ajax({
                        	cache: false,
                      	    type: "POST",
                            url: "FormData/coopwork/taskplan.php",
                            data: {mydate:[{'datatype':'base','method':'del_taskplan','formdata':document.getElementById("selectedrowpkid").value}]},     
                            success: function(data){
                            	try
                            	{
                                	var dataObj = eval("("+data+")");
                                	//alert(dataObj["status"]);
                                	if(dataObj["status"]=="1")
                                	{
                                		$("#alertsuccesslabel").html('删除[任务项]成功。');
                                		//Delete row record information from Table
                                		TableDelRow();
                                		//Delete node in tree
                                		var selectedRowPkid="";
                                		selectedRowPkid=document.getElementById("selectedrowpkid").value;
                                    	var ref = $('#taskplan_tree').jstree(true);
                                    	var deletenode= ref.delete_node({"id":selectedRowPkid});
                                		
                                	}
                                	else if(dataObj["status"]=="0") 
                                	{
                                		$("#alertsuccesslabel").html('删除[任务项]失败，请检查服务端运行是否正常。');
                                	}
                            	}
                            	catch(err)
                            	{
                            		$("#alertsuccesslabel").html('删除[任务项]异常，异常信息如下：');
                            		//alert(err.message +"|" + err.description);
                            	}
                            	//var i = setTimeout('$('#basic').close()',2000);
                            	
                            	//alert(data);
                            
                            },//success
                            error: function(){$("#alertsuccesslabel").html('修改[任务项]失败，请检查服务端运行是否正常。'); }
                         });
                	}
                    
                    success1.show();
                }
            });


    }

    // validation using icons
    var handleValidation2 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form2 = $('#form_sample_2');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);

            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    name: {
                        minlength: 2,
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    url: {
                        required: true,
                        url: true
                    },
                    number: {
                        required: true,
                        number: true
                    },
                    digits: {
                        required: true,
                        digits: true
                    },
                    creditcard: {
                        required: true,
                        creditcard: true
                    },
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success2.hide();
                    error2.show();
                    App.scrollTo(error2, -200);
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    var icon = $(element).parent('.input-icon').children('i');
                    icon.removeClass('fa-check').addClass("fa-warning");  
                    icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    success2.show();
                    error2.hide();
                    form[0].submit(); // submit the form
                }
            });


    }

    // advance validation
    var handleValidation3 = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation

            var form3 = $('#form_sample_3');
            var error3 = $('.alert-danger', form3);
            var success3 = $('.alert-success', form3);

            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })

            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                rules: {
                    name: {
                        minlength: 2,
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },  
                    options1: {
                        required: true
                    },
                    options2: {
                        required: true
                    },
                    select2tags: {
                        required: true
                    },
                    datepicker: {
                        required: true
                    },
                    occupation: {
                        minlength: 5,
                    },
                    membership: {
                        required: true
                    },
                    service: {
                        required: true,
                        minlength: 2
                    },
                    markdown: {
                        required: true
                    },
                    editor1: {
                        required: true
                    },
                    editor2: {
                        required: true
                    }
                },

                messages: { // custom messages for radio buttons and checkboxes
                    membership: {
                        required: "Please select a Membership type"
                    },
                    service: {
                        required: "Please select  at least 2 types of Service",
                        minlength: jQuery.validator.format("Please select  at least {0} types of Service")
                    }
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    if (element.parent(".input-group").size() > 0) {
                        error.insertAfter(element.parent(".input-group"));
                    } else if (element.attr("data-error-container")) { 
                        error.appendTo(element.attr("data-error-container"));
                    } else if (element.parents('.radio-list').size() > 0) { 
                        error.appendTo(element.parents('.radio-list').attr("data-error-container"));
                    } else if (element.parents('.radio-inline').size() > 0) { 
                        error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
                    } else if (element.parents('.checkbox-list').size() > 0) {
                        error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
                    } else if (element.parents('.checkbox-inline').size() > 0) { 
                        error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
                    } else {
                        error.insertAfter(element); // for other inputs, just perform default behavior
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit   
                    success3.hide();
                    error3.show();
                    App.scrollTo(error3, -200);
                },

                highlight: function (element) { // hightlight error inputs
                   $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
                },

                submitHandler: function (form) {
                    success3.show();
                    error3.hide();
                    form[0].submit(); // submit the form
                }

            });

             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });

            //initialize datepicker
            $('.date-picker').datepicker({
                rtl: App.isRTL(),
                autoclose: true
            });
            $('.date-picker .form-control').change(function() {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input 
            })
    }

    var handleWysihtml5 = function() {
        if (!jQuery().wysihtml5) {
            
            return;
        }

        if ($('.wysihtml5').size() > 0) {
            $('.wysihtml5').wysihtml5({
                "stylesheets": ["../assets/global/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
            });
        }
    }

    return {
        //main function to initiate the module
        init: function () {
            //alert("lll");
            handleWysihtml5();
            handleValidation1();
            //handleValidation2();
            //handleValidation3();

        }

    };

}();

jQuery(document).ready(function() {
    FormValidation.init();
});