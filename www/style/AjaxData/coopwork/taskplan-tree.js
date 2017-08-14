var UITree = function () {

    


     var ajaxProjectTree = function() {

         $("#taskplan_tree").jstree({
             "core" : {
                 "themes" : {
                     "responsive": false
                 }, 
                 // so that create works
                 "check_callback" : true,
                 'data' : {
                     'url' : function (node) {
                       return 'FormData/coopwork/jstree_ajax_taskplan.php';
                     },
                     'data' : function (node) {
                       return { 'parent' : node.id };
                     }
                 }
             },
             "types" : {
                 "default" : {
                     "icon" : "fa fa-folder icon-state-warning icon-lg"
                 },
                 "file" : {
                     "icon" : "fa fa-file icon-state-warning icon-lg"
                 }
             },
             "state" : { "key" : "demo3" },
             //"plugins" : [ "search" ]
             "plugins" : [ "dnd", "state", "types" ]
         });
     
     }
    return {
        //main function to initiate the module
        init: function () {

            //handleSample1();
            //handleSample2();
            //contextualMenuSample();
        	ajaxProjectTree();
        }

    };

}();



if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {    
       UITree.init();
    });
}

function showtext(texts)
{ alert(texts);}