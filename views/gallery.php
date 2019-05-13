<h2 class="gallery-heading">Image Gallery</h2>
<div class="gallery">
    <? foreach($images as $img): ?>
        <div class="gallery__item">
            <a class="gallery__item-link" href="<?= $img['image'] ?>" target='_blank'>
                <img class="gallery__item-img"  src="<?=$img['thumbnail']?>" alt="<?=$img['alt']?>">
            </a>
            <div class='gallery__quick-view-pane'>
                <a href='#' data-image="<?= $img['image'] ?>" class='gallery__quick-view-btn'>Quick View</a>
            </div>
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
<? if ($message !== ''): ?>
<div class="message"><?=$message?></div>
<? endif; ?>

<div id="modal" class="modal">
    <div class="modal__central-pane">
        <div class="modal__close-btn" title="Закрыть"></div>
        <h3 class="modal__title">Image Name</h3>
        <div class="modal__img-block">
            <img class="modal__img" src="">
        </div>
    </div>

</div>

<script>
    let selFileEl = document.querySelector('#file-name');
    selFileEl.addEventListener('change', () => {
        let selFileTagEl = document.querySelector('#sel-file-tag');
        selFileTagEl.value = selFileEl.value;
    });

    let galleryEl = document.querySelector('.gallery');
    galleryEl.addEventListener('click', handleQuickViewClick);

    let modalCloseEl = document.querySelector('.modal__close-btn');
    modalCloseEl.addEventListener('click', handleModalCloseClick);


    // Show "modal window" with an image for the clicked item. The handler is expected to be attached
    // to gallery block
    function handleQuickViewClick(e) {
        if (e.target.classList.contains('gallery__quick-view-btn')) {
            let modalEl = document.getElementById('modal');

            let imgEl = document.querySelector('.modal__img');
            imgEl.src = e.target.dataset.image;

            let titleEl = document.querySelector('.modal__title');
            titleEl.textContent = e.target.dataset.image;

            // set the dialog panel title to product name
            modalEl.classList.toggle('shown');
        }
    }

    function handleModalCloseClick() {
        let modalDlg = document.getElementById('modal');
        modalDlg.classList.remove('shown');
    }
</script>