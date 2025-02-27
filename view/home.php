
<div class="manga">
    <img src="./asset/public/img/<?php echo $mangas->getThumbnail() ?>.jpg" alt="<?php echo $mangas->getName() ?>">
    <h2><?php echo $mangas->getName() ?></h2>
    <p><?php echo $mangas->getDescription() ?></p>
    <p>Published on: &nbsp;<?php echo $mangas->getPublished_date()->format('d-m-Y') ?></p>
</div>