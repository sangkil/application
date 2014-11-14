biz = (function($) {
    var pub = {
        config: {
            limit: 20,
        },
        log: function(data) {
            if (biz.config.debug) {
                console.log(data);
            }
        },
        format: function(n) {
            if (n.toString().indexOf('.') == -1) {
                return n.toLocaleString('id');
            }
        },
        unformat: function(n) {
            if (n.toString().indexOf('.') >= 0) {
                return n.toString().replace(/./g, '');
            }
        },
        init: function() {

        },
        initModule: function(module) {
            if (module.isActive === undefined || module.isActive) {
                if ($.isFunction(module.init)) {
                    module.init();
                }
                $.each(module, function() {
                    if ($.isPlainObject(this)) {
                        pub.initModule(this);
                    }
                });
            }
        },
        configure: function(config) {
            $.extend(pub.config, config || {});
        }
    }
    return pub;
})(window.jQuery);

jQuery(document).ready(function() {
    biz.initModule(biz);
});

