(function(){
    $('.jstree a[href$="' + window.location.pathname + '"]').parent().attr('data-jstree', '{"opened":true,"selected":true}');

    $('.jstree').jstree().on('select_node.jstree', function(node, selected, e){
        window.location = selected.node.a_attr.href;
    });
})(jQuery);
