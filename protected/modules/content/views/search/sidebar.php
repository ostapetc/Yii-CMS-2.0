<form action="#" id="search-full">
    <select name="index">
        <option value="pages">Посты</option>
        <option value="video">Видео</option>
        <option value="audio">Аудио</option>
        <option value="albums">Альбомы</option>
    </select>
    <input type="text" name="q" />
</form>
<script type="text/javascript">
$(document).ready(function() {
    $('#search-full').submit(function() {
        var form = $('#search-full');
        $.fn.yiiListView.update('search-result', {
            url: '/content/search/index?index=' + $('[name="index"]', form).val() + '&q=' + $('[name="q"]',form).val()
        });
        return false;
    });
});
</script>