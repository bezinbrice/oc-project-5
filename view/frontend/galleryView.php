<?php $titleSite = 'Graphiste au Japon - Galerie d\'images'; ?>
<?php ob_start(); ?>
<div class="banner-listPostsView jumbotron">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="my-4 banner-listPostsView--text">GALERIE D'IMAGES</h1>
                <h2 class="my-4 banner-listPostsView--text">VOYAGE AU JAPON</h2>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex flex-wrap">
                <?php
                while ($data = $pictures->fetch())
                {
                    ?>
                    <div class="galleryView--container--pictures">
                        <a href="index.php?action=post&amp;id=<?= $data['id'] ?>"><img src="public/uploads/<?= $data['picture'];?>" class="card-img-top img-thumbnail" alt="<?= $data['picture'];?>"></a>
                    </div>
                    <?php
                }
                $pictures->closeCursor();
                ?>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
