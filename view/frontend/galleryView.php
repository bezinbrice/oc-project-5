<?php $titleSite = 'Graphiste au Japon - Galerie d\'images'; ?>
<?php ob_start(); ?>
<div class="galleryView--container">
    <div class="banner-galleryView jumbotron">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <img class="chevrons" id="chevrons-left" src="web/css/assets/chevron-left.svg" alt="#" /><!-- Icons made by <a href="https://www.flaticon.com/authors/fps-web-agency" title="fps web agency">fps web agency</a> from <a href="https://www.flaticon.com/" title="Flaticon"> www.flaticon.com</a> -->
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
                <div class="d-flex  justify-content-between flex-wrap">
                    <?php
                    while ($data = $pictures->fetch())
                    {
                        ?>
                        <div class="galleryView--container--pictures">
                            <a href="index.php?action=post&amp;id=<?= $data['id'] ?>"><img src="public/uploads/<?= $data['picture'];?>" class="card-img-top galleryView--container--pictures--image" alt="<?= $data['picture'];?>"></a>
                        </div>
                        <?php
                    }
                    $pictures->closeCursor();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
