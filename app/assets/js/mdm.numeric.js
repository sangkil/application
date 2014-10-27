(function($) {
    function getCaret(element) {
        if (element.selectionStart)
            return element.selectionStart;

        else if (document.selection) { //IE specific
            element.focus();
            var r = document.selection.createRange();
            if (r == null)
                return 0;

            var re = element.createTextRange(), rc = re.duplicate();
            re.moveToBookmark(r.getBookmark());
            rc.setEndPoint('EndToStart', re);
            return rc.text.length;
        }

        return 0;
    }

    var keypress = function(event) {
        var allowFloat = event.data.allowFloat !== undefined ? event.data.allowFloat : true;
        var allowNegative = event.data.allowNegative !== undefined ? event.data.allowNegative : false;

        var inputCode = event.which;
        var currentValue = $(this).val();

        if (inputCode > 0 && (inputCode < 48 || inputCode > 57)) {	// Checks the if the character code is not a digit
            if (allowFloat == true && inputCode == 46) {	// Conditions for a period (decimal point)
                //Disallows a period before a negative
                if (allowNegative == true && getCaret(this) == 0 && currentValue.charAt(0) == '-')
                    return false;

                //Disallows more than one decimal point.
                if (currentValue.match(/[.]/))
                    return false;
            }

            else if (allowNegative == true && inputCode == 45) {	// Conditions for a decimal point
                if (currentValue.charAt(0) == '-')
                    return false;

                if (getCaret(this) != 0)
                    return false;
            }

            else if (inputCode == 8) 	// Allows backspace
                return true;
            else								// Disallow non-numeric
                return false;
        }

        else if (inputCode > 0 && (inputCode >= 48 && inputCode <= 57)) {	// Disallows numbers before a negative.
            if (allowNegative == true && currentValue.charAt(0) == '-' && getCaret(this) == 0)
                return false;
        }
    }

    var focus = function() {
        if (this.value.indexOf(',') >= 0) {
            this.value = this.value.replace(/,/g, '');
        }
    }

    var blur = function() {
        var n = this.value;
        if (n.toString().indexOf(',') == -1) {
            var s = [];
            while (n > 0) {
                s.push(n % 1000);
                n = Math.floor(n / 1000);
            }
            this.value = s.reverse().join(',');
        }
    }

    $.fn.mdmNumericInput = function(opt) {
        return this.each(function() {
            opt = opt || {};
            var selector = undefined;
            if (typeof opt == 'string') {
                selector = opt;
                opt = {};
            } else if (opt.selector) {
                selector = opt.selector;
                opt.selector = undefined;
            }
            opt = $.extend({}, {
                allowFloat: true,
                allowNegative: false,
            }, opt);

            if (selector !== undefined) {
                $(this).on('keypress.mdmNumericInput', selector, opt, keypress);
            } else {
                $(this).on('keypress.mdmNumericInput', opt, keypress);
            }
        });
    }

    $.fn.mdmNumericFormat = function(sel) {
        return this.each(function() {
            if (sel) {
                $(this).on('focus.mdmNumericFormat', sel, focus)
                    .on('blur.mdmNumericFormat', sel, blur);
            } else {
                $(this).on('focus.mdmNumericFormat', focus)
                    .on('blur.mdmNumericFormat', blur);
            }
        });
    }
})(window.jQuery);