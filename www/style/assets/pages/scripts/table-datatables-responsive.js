var TableDatatablesResponsive = function () {

    
    var initTable2 = function () {
        var table = $('#sample_3');

        var oTable = table.dataTable({
            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "没有记录！",
                "info": "显示 _START_ 到 _END_ 总共 _TOTAL_ 条记录",
                "infoEmpty": "没有找到对象！",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "lengthMenu": "_MENU_ 条记录",
                "search": "搜索:",
                "zeroRecords": "没有匹配到任何记录！"
            },

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},

            // setup buttons extentension: http://datatables.net/extensions/buttons/
            buttons: [
                { extend: 'print', className: 'btn dark btn-outline', text: '打印' },
                { extend: 'copy', className: 'btn red btn-outline' , text: '复制'},
                { extend: 'pdf', className: 'btn green btn-outline', text: '输出到PDF' },
                { extend: 'excel', className: 'btn yellow btn-outline ', text: '输出到EXCEL' },
                { extend: 'csv', className: 'btn purple btn-outline ', text: '输出到CSV' }
            ],
           
            // setup responsive extension: http://datatables.net/extensions/responsive/
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
            columnDefs: [ {
                className: 'control',
                orderable: false,
                targets:   0
            } ],

            order: [ 1, 'asc' ],
            
            // pagination control
            "lengthMenu": [
                [10, 20, 30, 50, -1],
                [10, 20, 30, 50, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,
            "pagingType": 'bootstrap_extended', // pagination type

            "dom": "<'row' ><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
            //"dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        });
        
        // handle datatable custom tools
        $('#sample_3_tools > li > a.tool-action').on('click', function() {
            var action = $(this).attr('data-action');
            oTable.DataTable().button(action).trigger();
        });
    }


    return {

        //main function to initiate the module
        init: function () {

            if (!jQuery().dataTable) {
                return;
            }

            //initTable1();
            initTable2();
            //initTable3();
            //initTable4();
        }

    };

}();

jQuery(document).ready(function() {
    TableDatatablesResponsive.init();
});