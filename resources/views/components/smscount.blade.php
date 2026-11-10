<script>
    (function ($) {
        "use strict";
        $(document).ready(function () {
            $('textarea[name="message"]').on('input propertychange', function () {
                var len = $(this).val().length;
                var count = Math.ceil(len / 160) || 1;
                $('.sms-length-count').text(len);
                $('.sms-part-count').text(count);
            });
        });
    })(jQuery);
</script>

