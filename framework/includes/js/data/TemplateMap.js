(function($) {
    TemplateMap = {
        Template: {},
        WidgetList: ['flow', 'form', 'display', 'header', 'list', 'nav', 'query_criteria',
                    'table', 'tab', 'tree', 'box', 'slide'],
        GetTemplate : function(widget) {
            if($.inArray(widget, this.WidgetList) >= 0) {
                if(this.Template[widget]) {
                    return this.Template[widget];
                } else {
                    return 'default';
                }
            } else {
                return 'default';
            }
        },
        SetTemplate : function(widget, name) {
            if($.inArray(widget, this.WidgetList) >= 0) {
                if(typeof name === 'string') { this.Template[widget] = name; }
            }
        }
    };
})(jQuery);