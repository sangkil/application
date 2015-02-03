<script>
    biz.movement = (function($) {
        var pub = {
            onReady: function() {
                $('#save,#create').on('click', function() {
                    $("#goodsmovement-form").submit();
                });
            }
        };
        return pub;
    })(window.jQuery);
</script>