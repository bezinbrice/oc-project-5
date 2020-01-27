<?php $titleSite = 'Graphiste au Japon - Galerie d\'images'; ?>
<?php ob_start(); ?>
<div class="banner-galleryView jumbotron">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <img class="chevrons" id="chevrons-left" src="web/css/assets/chevron-left.svg" alt="#" />
                <img class="chevrons pause" id="pauseBtn" src="web/css/assets/pause.svg" alt="#"/>
                <div id="galleryView-section">
                    <section id="slider-container">
                        <div class="slider-container--block">
                            <img src="web/images/slider1.png" class="galleryView-slider--img galleryView-slider--img-1" alt="spectacle deux samouraïs"/>
                        </div>
                        <div class="slider-container--block">
                            <img src="web/images/slider2.png" class="galleryView-slider--img galleryView-slider--img-2" alt="spectacle deux samouraïs"/>
                        </div>
                        <div class="slider-container--block">
                            <img src="web/images/slider3.png" class="galleryView-slider--img galleryView-slider--img-3" alt="spectacle deux samouraïs"/>
                        </div>
                        <div class="slider-container--block">
                            <img src="web/images/slider4.png" class="galleryView-slider--img galleryView-slider--img-4" alt="spectacle deux samouraïs"/>
                        </div>
                    </section>
                </div>
                <img class="chevrons" id="chevrons-right" src="web/css/assets/chevron-right.svg" alt="#"/>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="my-4 galleryView-slider--text">GALERIE D'IMAGES</h1>
            <h2 class="my-4 galleryView-slider--text">VOYAGE AU JAPON</h2>
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
