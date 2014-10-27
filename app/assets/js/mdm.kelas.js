Kelas = (function() {
    function Extend(dst, src) {
        for (var i in src) {
            try {
                dst[i] = src[i];
            } catch (e) {
            }
        }
        return dst;
    }

    var fn = function() {
        var c = function() {
            if (this.initialize) {
                this.initialize.apply(this, arguments);
            }
        }
        c.prototype = Object.create(Kelas.prototype);
        for (var i = 0; i < arguments.length; i++) {
            var a = arguments[i];
            if (a.prototype) {
                c.prototype = new a();
            } else {
                Extend(c.prototype, a);
            }
        }
        c.prototype.constructor = c;
        Extend(c, c.prototype);
        return c;
    }

    return fn;
})();