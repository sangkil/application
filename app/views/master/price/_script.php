<script>
    biz.price = (function($) {
        var local = {
            onProductChange: function() {
                var item = biz.master.searchProductByCode(this.value);
                if (item !== false) {
                    local.addItem(item);
                }
                this.value = '';
                $(this).autocomplete("close");
            }
        }
        
        var pub = {
            onReady: function() {   
            $('#product').change(local.onProductChange);
                $('#product').focus();
                $('#product').data('ui-autocomplete')._renderItem = biz.global.renderItem;             
            },
            onProductSelect: function(event, ui) {
                //local.addItem(ui.item);
            }
        };
        return pub;
    })(window.jQuery);
</script>