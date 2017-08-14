var TableDatatablesResponsive = function () {
	var initTable1 = function () {

        var table = $('#sample_1');

        // begin first table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
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
                  ],
            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "columnDefs": [ {
                "targets": 0,
                "orderable": false,
                "searchable": false
            }],

            "lengthMenu": [
                [15, 20, 30,50, -1],
                [15, 20, 30,50, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 15,            
            "pagingType": "bootstrap_full_number",
            "columnDefs": [{  // set default column settings
                'orderable': false,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }]/*,
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
            */
        });
        
        $('#sample_1_tools > li > a.tool-action').on('click', function() {
        	
            var action = $(this).attr('data-action');
            //alert(action);
            table.DataTable().button(action).trigger();
        });
        //var tableWrapper = jQuery('#sample_1_wrapper');

        table.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).prop("checked", true);
                    $(this).parents('tr').addClass("active");
                } else {
                    $(this).prop("checked", false);
                    $(this).parents('tr').removeClass("active");
                }
            });
        });

        table.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
        });
    }
	
    return {

        //main function to initiate the module
        init: function () {

            if (!jQuery().dataTable) {
                return;
            }

            initTable1();
        }

    };

}();

jQuery(document).ready(function() {
    TableDatatablesResponsive.init();
});