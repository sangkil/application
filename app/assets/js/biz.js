biz = (function($) {
    var pub = {
        config: {
            limit:20,
            
        },
        renderItem: function(ul, item) {
            var $a = $('<a>')
                .append($('<b>').text(item.text)).append('<br>')
                .append($('<i>').text(item.cd).css({color: '#999999'}));
            return $("<li>").append($a).appendTo(ul);
        },
        renderItemPos: function(ul, item) {
            var $a = $('<a>')
                .append($('<b>').text(item.text)).append('<br>')
                .append($('<i>').text(item.cd).css({color: '#999999'}));
            if (item.price) {
                $a.append($('<i>').text(' - @ Rp' + $.number(item.price, 0)).css({color: '#799979'}));
            }
            return $("<li>").append($a).appendTo(ul);
        },
        log: function(data) {
            if (biz.config.debug) {
                console.log(data);
            }
        },
        format: function(n) {
            if (n.indexOf(',') == -1) {
                return numeral(n).format('0,0');
            }
        },
        unformat: function(n) {
            if (n.indexOf(',') >= 0) {
                return numeral().unformat(n);
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

