<?php $titleSite = 'Graphiste au Japon'; ?>
<?php ob_start(); ?>
<div id="background-home">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="my-4 display-3 home-banner--titles title-white-shadow">GRAPHISTE AU JAPON</h1>
                <h2 class="home-banner--titles home--h2 title-white-shadow">Récit d'un humble voyage</h2>
                <img src="web/images/11043.jpg" class="img-fluid rounded mx-auto d-block image-home-hero" alt="stylo et dessin">
                <blockquote class="blockquote">
                    <p class="mb-0">L'homme ne peut découvrir de nouveaux océans sans avoir le courage de perdre de vue le rivage</p>
                    <footer class="blockquote-footer">Citation d'<cite title="Source Title">André Gide</cite>, écrivain français </footer>
                </blockquote>
            </div>
        </div>
    </div>
</div>
<div class="container home-page">
    <div class="row">
        <div class="col-md-12">
            <h2 class="my-4 title-gray-shadow">Dernière publication</h2>
            <?php
            while ($data = $lastPost->fetch())
            {
                ?>
                <div class="card mb-4 news">
                    <div class="card">
                        <h5 class="card-header"><?= $data['title'] ?></h5>
                        <img src="public/uploads/<?= $data['picture'];?>" class="card-img-top postsView--img-chapter" alt="<?= $data['picture'];?>">
                        <div class="card-body">
                            <p class="card-text"><?= $data['sample'] ?></p><br/>
                            <div  class="d-flex justify-content-between flex-wrap">
                                <a href="index.php?action=post&amp;id=<?= $data['id'] ?>" class="btn btn-primary d-flex mb-2">Lire le chapitre &rarr;</a>
                                <em><a href="index.php?action=post&amp;id=<?= $data['id'] ?> #post-comment" class="btn btn-outline-secondary d-flex mb-2" >Commentaires</a></em>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        Posté le <?= $data['creation_date_fr'] ?>
                    </div>
                </div>
                <?php
            }
            $lastPost->closeCursor();
            ?>
            <div>
                <img src="web/images/200115_0019.jpg" class="img-fluid rounded mx-auto d-block home--center--picture" alt="...">
            </div>
            <div class="card home--pitch-card">
                <h5 class="card-header text-uppercase">JE VAIS PARTIR UN AN AU JAPON</h5>
                <div class="card-body">
                    <h5 class="card-title">"Pourquoi ?"</h5>
                    <p class="card-text text-justify">Après deux années de recherche d'emploi, l'homme que j'étais avait perdu complètement espoir de pouvoir s'intégrer dans la société en tant que graphiste. Je me suis alors demandé "Qu'est ce que j'aimerai qu'un voyant me dise ? " C'est alors que je me suis imaginé partir à l'étranger, à l'autre bout du monde tout en souriant puis j'ai ouvert les yeux et mon choix était fait. </p>
                    <a href="index.php?action=listPosts" class="btn btn-primary">Visiter la page des posts</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
