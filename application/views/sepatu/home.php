<div class="content">
    <div class="hero-image">
        <picture>
            <source class="hero" media="(max-width: 640px)" srcset="<?= base_url(); ?>asset/img/potrait.png">
            <img class="hero" src="<?= base_url(); ?>asset/img/landscape.png" alt="">
        </picture>
    </div>
    <hr>
    <div class="sepatu">

        <?php for ($i = 0; $i < count($type); $i++) : ?>
            <div class="type-sepatu">

                <h3 class="type"><?= $type[$i] ?></h3>

                <div class="list-sepatu">

                    <div class="left-arrow">=</div>

                    <?php foreach ($dataSepatu[$type[$i]] as $item) : ?>
                        <div class="item">
                            <img src="<?= base_url(); ?>asset/image/sepatu/crop/<?= $item['gambar']->image[0]; ?>" alt="">
                            <p><?= $item['nama'] ?></p>
                            <a href="<?= base_url(); ?>sepatu/detail/<?= $item['id']; ?>"></a>
                        </div>

                    <?php endforeach; ?>

                    <div class="right-arrow">>></div>
                </div>

            </div>
        <?php endfor; ?>


        <div class="spesifikasi" id="spec">
            <div class="item-spec">
                <h3>Patrofoam tech insole</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero, atque esse ad vero nihil ducimus voluptates voluptatibus aliquid quod corrupti. Error earum voluptate nihil asperiores, tempora perferendis adipisci repellat consequuntur.</p>
            </div>
            <div class="item-spec">
                <h3>Breathable mesh linning</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam deleniti, aperiam similique, illo quidem voluptates repellendus ipsa cum at tenetur quasi possimus voluptatum nemo, eos laboriosam eum eligendi iste dolor.</p>
            </div>
            <div class="item-spec">
                <h3>Rubber sole</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis magnam nemo qui, repellat est aliquam? Fugiat, recusandae? Modi ut quae, temporibus earum recusandae, praesentium, exercitationem rerum porro doloremque ipsum maxime.</p>
            </div>
        </div>
    </div>