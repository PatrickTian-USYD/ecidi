var TableDatatablesEditable = function () {

    var handleTable = function () {

        function restoreRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);

            for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                oTable.fnUpdate(aData[i], nRow, i, false);
            }

            oTable.fnDraw();
        }

        function editRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            jqTds[0].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[0] + '">';
            jqTds[1].innerHTML = '<input type="text" readonly="readonly" class="form-control input-small" value="' + aData[1] + '">';
            jqTds[2].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[2] + '">';
            jqTds[3].innerHTML =gettypehtml(aData[3]);
            jqTds[4].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[4] + '">';
            jqTds[5].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[5] + '">';
            jqTds[6].innerHTML = '<a class="edit" href="" data-toggle="tooltip" title="Save"><i class="fa fa-save"></i></a>';
            jqTds[7].innerHTML = '<a class="cancel" href="" data-toggle="tooltip" title="Cancel"><i class="fa fa-undo"></i></a>';
        }

        function addRow(oTable, nRow) {
        	alert("ccc");
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            <td style='text-align: center'></td>
            jqTds[0].innerHTML = '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"><input type="checkbox" class="checkboxes" value="'+Plan_Pkid+'" /><span></span></label>';
            jqTds[1].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[1] + '">';
            jqTds[2].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[2] + '">';
            jqTds[3].innerHTML =gettypehtml("");
            jqTds[4].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[4] + '">';
            jqTds[5].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[5] + '">';
            jqTds[6].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[6] + '">';
            jqTds[7].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[7] + '">';
            jqTds[8].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[8] + '">';
            jqTds[9].innerHTML = '<a class="edit" href="" data-toggle="tooltip" title="Save"><i class="fa fa-save"></i></a>';
            jqTds[10].innerHTML = '<a class="cancel" href="" data-toggle="tooltip" title="Cancel"><i class="fa fa-undo"></i></a>';
        }
        
        function gettypehtml(showValue)
        {
        	//alert(showValue);
        	var FixedFlagStr="selected='true'";
        	var DHCPFlagStr="";
        	var StaticFlagStr="";
        	if(showValue=="固定分配")
        		FixedFlagStr="selected='true'";        	
        	if(showValue=="动态分配")
        		DHCPFlagStr="selected='true'";
        	if(showValue=="手工分配")
        		StaticFlagStr="selected='true'";        	
        	var typehtml="";
        	typehtml=typehtml+"<select class='form-control' id='iptype' name='iptype' style='width:100px'>";
        	//typehtml="<option value='' selected='true'>请选择IP地址段类型...</option>";
        	typehtml=typehtml+"<option value='0' "+FixedFlagStr+">固定分配</option>";
        	typehtml=typehtml+"<option value='1' "+DHCPFlagStr+">动态分配</option>";
        	typehtml=typehtml+"<option value='2' "+StaticFlagStr+">手工分配</option>";
        	typehtml=typehtml+"</select>";
        	//alert(typehtml);
        	return typehtml;
        }
        function GetTypeShowValue(typeValue)
        {
        	if(typeValue=="0")
        		return "固定分配";
        	if(typeValue=="1")
        		return "动态分配";
        	if(typeValue=="2")
        		return "手工分配";
        }
        function saveRow(oTable, nRow) {
            var jqInputs = $('input', nRow);
            var jqSelects = $('select', nRow);
            
            //////////////////////////////////////////////////////////////////////
            
            var ParaList=""
            ParaList = ParaList +"name="+jqInputs[0].value;	
            ParaList = ParaList +"&ipaddress="+jqInputs[1].value;
            ParaList = ParaList +"&mac="+jqInputs[2].value;
            ParaList = ParaList +"&type="+jqSelects[0].value;
            ParaList = ParaList +"&date="+jqInputs[3].value;            
            SaveIpAddress(ParaList);
            //////////////////////////////////////////////////////////////////////
            oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
            oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
            oTable.fnUpdate(GetTypeShowValue(jqSelects[0].value), nRow, 3, false);
            oTable.fnUpdate(jqInputs[3].value, nRow, 4, false);
            oTable.fnUpdate(jqInputs[4].value, nRow, 5, false);
            oTable.fnUpdate('<a class="edit" href=""><i class="fa fa-pencil"></i></a>', nRow, 6, false);
            oTable.fnUpdate('<a class="delete" href=""><i class="fa fa-remove"></i></a>', nRow, 7, false);
            oTable.fnDraw();
        }

        function cancelEditRow(oTable, nRow) {
            var jqInputs = $('input', nRow);
            oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
            oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
            oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
            oTable.fnUpdate(jqInputs[4].value, nRow, 4, false);
            oTable.fnUpdate(jqInputs[5].value, nRow, 5, false);
            oTable.fnUpdate('<a class="edit" href=""><i class="fa fa-pencil"></i></a>', nRow, 6, false);
            oTable.fnDraw();
        }
        
        function SaveIpAddress(Paralist)
        {
        	$.ajax({
            	cache: false,
          	    type: "POST",
                url: "FormData/resources/ipaddressinfor.php",
                data: {mydate:[{'datatype':'base','method':'save_ipaddress','formdata':Paralist}]},     
                success: function(data){
                	
                	try
                	{
                		//alert(data);
                    	var dataObj = eval("("+data+")");
                    	
                    	if(dataObj["status"]=="1")
                    	{
                    		alert('保存[Ip地址信息]成功。');
                    		//$("#alertsuccesslabel1").html();
                    	}
                    	else if(dataObj["status"]=="0") 
                    	{
                    		alert('保存[Ip地址信息]失败，请检查服务端运行是否正常。');
                    		//$("#alertsuccesslabel1").html('保存[Ip地址信息]失败，请检查服务端运行是否正常。');

                    	}
                	}
                	catch(err)
                	{
                		alert('添加[Ip地址信息]异常，异常信息如下：'+err.message +"|" + err.description);
                		//$("#alertsuccesslabel1").html('添加[设备信息]异常，异常信息如下：'+err.message +"|" + err.description);
                	}
                },//success
                error: function(){alert("失败");}
             });
        }
        function DealIpAddress(Paralist)
        {
        	$.ajax({
            	cache: false,
          	    type: "POST",
                url: "FormData/resources/ipaddressinfor.php",
                data: {mydate:[{'datatype':'base','method':'del_ipaddress','formdata':Paralist}]},     
                success: function(data){
                	
                	try
                	{
                		//alert(data);
                    	var dataObj = eval("("+data+")");
                    	
                    	if(dataObj["status"]=="1")
                    	{
                    		alert('删除[Ip地址信息]成功。');
                    		//$("#alertsuccesslabel1").html();
                    	}
                    	else if(dataObj["status"]=="0") 
                    	{
                    		alert('删除[Ip地址信息]失败，请检查服务端运行是否正常。');
                    		//$("#alertsuccesslabel1").html('保存[Ip地址信息]失败，请检查服务端运行是否正常。');

                    	}
                	}
                	catch(err)
                	{
                		alert('删除[Ip地址信息]异常，异常信息如下：'+err.message +"|" + err.description);
                		//$("#alertsuccesslabel1").html('添加[设备信息]异常，异常信息如下：'+err.message +"|" + err.description);
                	}
                },//success
                error: function(){alert("失败");}
             });
        }
        var table = $('#sample_editable_1');

        var oTable = table.dataTable({

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
/*
            "lengthMenu": [
                [15, 25, 50, -1],
                [15, 25, 50, "All"] // change per page values here
            ],
*/
            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},

            // set the initial value
            "pageLength": 25,
            "searching": false,
            "bLengthChange" : false,
            "bInfo":false,
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "没有记录！",
                "info": "显示 _START_ 到 _END_ 总共 _TOTAL_ 条记录",
                "infoEmpty": "没有找到对象！",
                "infoFiltered": "(从1 到 _MAX_ 条记录进行搜索的结果)",
                "lengthMenu": "_MENU_ 条记录",
                "search": "搜索:",
                "zeroRecords": "没有匹配到任何记录！",
                "paginate": {
                    "previous":"上一页",
                    "next": "下一页",
                    "last": "最后一页",
                    "first": "第一页"
                }
            }, 
            buttons: [
                      { extend: 'print', className: 'btn dark btn-outline', text: '打印' },
                      { extend: 'copy', className: 'btn red btn-outline' , text: '复制'},
                      { extend: 'pdf', className: 'btn green btn-outline', text: '输出到PDF' },
                      { extend: 'excel', className: 'btn yellow btn-outline ', text: '输出到EXCEL' },
                      { extend: 'csv', className: 'btn purple btn-outline ', text: '输出到CSV' }
                  ]
                  /*
            "columnDefs": [{ // set default column settings
                'orderable': true,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [0, "asc"]
            ] */// set first column as a default sort by asc
        });

        var tableWrapper = $("#sample_editable_1_wrapper");

        var nEditing = null;
        var nNew = false;
        // handle datatable custom tools
        $('#sample_1_tools > li > a.tool-action').on('click', function() {
        	
            var action = $(this).attr('data-action');
            //alert(action);
            table.DataTable().button(action).trigger();
        });
        
        $('#sample_editable_1_new').click(function (e) {
            e.preventDefault();
            alert("ccc");
            if (nNew && nEditing) {
                if (confirm("Previose row not saved. Do you want to save it ?")) {
                    saveRow(oTable, nEditing); // save
                    $(nEditing).find("td:first").html("Untitled");
                    nEditing = null;
                    nNew = false;

                } else {
                    oTable.fnDeleteRow(nEditing); // cancel
                    nEditing = null;
                    nNew = false;
                    
                    return;
                }
            }

            var aiNew = oTable.fnAddData(['','', '', '','','', '', '', '','']);
            var nRow = oTable.fnGetNodes(aiNew[0]);
            addRow(oTable, nRow);
            nEditing = nRow;
            nNew = true;
        });

        table.on('click', '.delete', function (e) {
            e.preventDefault();
            var nRow = $(this).parents('tr')[0];
            
            if (confirm("你确定要删除该IP["+nRow.cells[0].innerText+"]记录吗 ?") == false) {
                return;
            }

            
            DealIpAddress(nRow.cells[0].innerText);
            oTable.fnDeleteRow(nRow);
            //alert("Deleted! Do not forget to do some ajax to sync with backend :)");
        });

        table.on('click', '.cancel', function (e) {
            e.preventDefault();
            if (nNew) {
                oTable.fnDeleteRow(nEditing);
                nEditing = null;
                nNew = false;
            } else {
                restoreRow(oTable, nEditing);
                nEditing = null;
            }
        });

        table.on('click', '.edit', function (e) {
            e.preventDefault();
            nNew = false;
            
            /* Get the row as a parent of the link that was clicked on */
            var nRow = $(this).parents('tr')[0];
            /*
            if(nEditing == nRow)
            {
            	alert("lll");
            	alert($(this).attr('title'));
            }
               */
            if (nEditing !== null && nEditing != nRow) {
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                restoreRow(oTable, nEditing);
                editRow(oTable, nRow);
                nEditing = nRow;
            } else if (nEditing == nRow && $(this).attr('title') == "Save") {//this.innerHTML 
                /* Editing this row and want to save it */
                saveRow(oTable, nEditing);


                /*
                var ParaList="ipaddress="+nEditing.cells[0].innerText;
                ParaList = ParaList +"&name="+nEditing.cells[1].innerText;
                ParaList = ParaList +"&type="+nEditing.cells[2].innerText;
                ParaList = ParaList +"&date="+nEditing.cells[3].innerText;
                
                SaveIpAddress(ParaList);
               for (var j = 0; j < nEditing.cells.length; j++) {  //遍历Row中的每一列
            	   alert(nEditing.cells[j].innerText);  //获取Table中单元格的内容

               }
                alert(nEditing);*/
                //var $td = nEditing.children('td');
                //document.getElementById("Name").value=;
                //alert($td.eq(1).text());
                nEditing = null;
                //alert("Updated! Do not forget to do some ajax to sync with backend :)");
            } else {
                /* No edit in progress - let's start one */
                editRow(oTable, nRow);
                nEditing = nRow;
            }
        });
    }

    return {

        //main function to initiate the module
        init: function () {
            handleTable();
        }

    };

}();

jQuery(document).ready(function() {
	alert("ccc");
    TableDatatablesEditable.init();
    
});