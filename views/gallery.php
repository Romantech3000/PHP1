<h2 class="gallery-heading">Image Gallery</h2>
<div class="gallery">
    <? foreach($images as $img): ?>
        <div class="gallery__img-block">
            <? echo "<a href=\"{$img['image']}\" target='_blank'><img  src=\"{$img['thumbnail']}\" alt=\"{$img['alt']}\"></a>"; ?>
        </div>
    <? endforeach; ?>
</div>

<div class="file-form">
    <form method="post" enctype="multipart/form-data">
        <label for="file-name" class="file-form__file-label">Выбрать файл ...</label>
        <input type="text" id="sel-file-tag" class="file-form__sel-file-tag">
        <input type="file" class="file-form__file" id="file-name" name="img_file">
        <button class="file-form__btn" type="submit" name="upload">загрузить</button>
    </form>
</div>

<script>
    let selFileEl = document.querySelector('#file-name');
    selFileEl.addEventListener('change', () => {
        let selFileTagEl = document.querySelector('#sel-file-tag');
        selFileTagEl.value = selFileEl.value;
    });
</script>