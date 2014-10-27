/**
 * Function Kelas, use to inheritance emulation
 * Inspiration https://code.google.com/p/cakejs/
 * 
 * Rectangle = Kelas({
 *     initialize: function(x,y){
 *         this.x = x;
 *         this.y = y;
 *     },
 *     getArea: function(){
 *         return this.x * this.y;
 *     }
 * });
 * 
 * Square = Klass(Rectangle, {
 *     initialize : function(s) {
 *         Rectangle.initialize.call(this, s, s);
 *     }
 * });
 * 
 * var sq = new Square(5);
 * 
 * console.log(sq instanceof Square);
 * console.log(sq instanceof Rectangle);
 * console.log(sq.getArea());
 * 
 * 
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 */

Kelas = function() {
    var c = function() {
        if (this.initialize) {
            this.initialize.apply(this, arguments);
        }
    }

    function Extend(dst, src) {
        for (var i in src) {
            try {
                dst[i] = src[i];
            } catch (e) {
            }
        }
        return dst;
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