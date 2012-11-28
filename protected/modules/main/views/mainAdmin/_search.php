<form id="form-search" class="form-search quick_search">
    <input type="text" placeholder="<? echo t('Быстрый поиск'); ?>" class="input-medium search-query">
</form>
<script type="text/javascript">
    $(document).ready(function () {
        $('#form-search input').keyup(function(){
            var duration = 300,
                val = $(this).val().toLowerCase(),
                menu = $('#admin_menu'),
                header_hendler = function (){
                    var parent = $(this).closest('ul');
                    var header = parent.prev();
                    parent.find('a:visible').length > 0 ? header.show(duration) : header.hide(duration);
                };

            $('ul li a', menu).each(function() {
                var self = $(this);
                if (val.length == 0)
                {
                    self.show(duration, header_hendler);
                    return true;
                }

                self.text().toLowerCase().search(val) > -1 ? self.show(duration, header_hendler) : self.hide(duration, header_hendler);
            });

        });
    });
</script>