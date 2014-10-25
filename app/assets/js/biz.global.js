biz.global = (function($) {
    var pub = {
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
    }
    return pub;
})(window.jQuery);