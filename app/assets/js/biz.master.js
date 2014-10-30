biz.master = (function($) {
    var local = {};
    var storageClass;
    var pub = {
        init: function() {
            // initialize storage class
            if (biz.config.storageClass) {
                storageClass = biz.config.storageClass;
            } else {
                storageClass = DStorage;
            }

            // initialize masters
            if (biz.config.masters) {
                var masters = [];
                $.each(biz.config.masters, function() {
                    var name = this;
                    var s = pub.create(name);
                    pub[name] = s.all();
                    if (pub[name] === undefined) {
                        masters.push(name);
                    }
                });

                if (masters.length > 0) {
                    pub.pull(masters);
                }
                pub.pull(biz.config.masters);
            }
        },
        pull: function(masters, url) {
            if (url === undefined) {
                url = biz.config.pullUrl;
            }
            if (url) {
                $.getJSON(url, {masters: masters}, function(result) {
                    $.each(result, function(name, val) {
                        pub.create(name, val);
                        pub[name] = val;
                    });
                });
            }
        },
        create: function(name, value) {
            if (local[name] === undefined) {
                local[name] = new storageClass(name);
            }
            if (value !== undefined) {
                local[name].save(value);
            }
            return local[name];
        },
        sourceProduct: function(request, callback) {
            var result = [];
            var limit = biz.config.limit;
            var checkStock = biz.config.checkStock && pub.product_stock !== undefined;
            var checkSupp = biz.config.checkSupp && pub.product_supplier !== undefined;

            var term = request.term.toLowerCase();
            var whse = biz.config.whse;
            if (checkStock && (whse == undefined || pub.product_stock[whse] == undefined)) {
                callback([]);
                return;
            }
            var supp = biz.config.supplier;
            if (checkSupp && (supp == undefined || pub.product_supplier[supp] == undefined)) {
                callback([]);
                return;
            }

            var price = biz.config.price_ct && pub.prices !== undefined;

            $.each(pub.products, function() {
                var product = this;
                if (product.text.toLowerCase().indexOf(term) >= 0 || product.cd.toLowerCase().indexOf(term) >= 0) {
                    var id = product.id + '';
                    if ((!checkStock || pub.product_stock[whse][id] > 0) && (!checkSupp || pub.product_supplier[supp].indexOf(id) >= 0)) {
                        if (price && pub.prices[id]) {
                            result.push($.extend(product, {price: pub.prices[id][biz.config.price_ct]}));
                        } else {
                            result.push(product);
                        }
                        limit--;
                        if (limit <= 0) {
                            return false;
                        }
                    }
                }
            });
            callback(result);
        },
        searchProductByCode: function(cd) {
            var checkStock = biz.config.checkStock && pub.product_stock !== undefined;
            var checkSupp = biz.config.checkSupp && pub.product_supplier !== undefined;
            var whse = biz.config.whse;
            if (checkStock && (whse == undefined || pub.product_stock[whse] == undefined)) {
                return false;
            }
            var supp = biz.config.supplier;
            if (checkSupp && (supp == undefined || pub.product_supplier[supp] == undefined)) {
                return false;
            }

            var id = pub.barcodes[cd] + '';
            var product = pub.products[id];
            if (product && (!checkStock || pub.product_stock[whse][id] > 0) && (!checkSupp || pub.product_supplier[supp].indexOf(id) >= 0)) {
                return product;
            }
            return false;
        },
    }
    return pub;
})(window.jQuery);