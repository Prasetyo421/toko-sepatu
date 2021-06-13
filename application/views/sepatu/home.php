<!-- <?php var_dump(APPPATH) ?> -->
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

                <div class="pref" onclick="pref(this)" data-type="<?= $type[$i] ?>"><i class="fas fa-arrow-left"></i></div>

                <h3 class="type"><?= $type[$i] ?></h3>

                <div class="show">

                    <div class="list-sepatu list-sepatu-<?= $type[$i] ?>">

                        <?php foreach ($data_sepatu[$type[$i]] as $item) : ?>
                            <div class="item">
                                <img src="<?= base_url(); ?>asset/image/sepatu/<?= $item['images'][0]['image_name']; ?>" alt="<?= $item['shoes_name'] ?>">
                                <p><?= $item['shoes_name'] ?></p>
                                <a href="<?= base_url(); ?>home/detailSepatu/<?= $item['id']; ?>"></a>
                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>

                <div class="next" onclick="next(this)" data-type="<?= $type[$i] ?>"><i class="fas fa-arrow-right"></i></div>

            </div>
        <?php endfor; ?>


        <div class="spesifikasi" id="spec">
            <div class="row">
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

        <div id="size-chart" class="size-chart">
            <img src="./asset/img/size-chart.png" alt="">
        </div>

        <div class="about" id="about">
            <h1>About</h1>
            <p>Patrobas adalah brand sepatu casual yang telah berdiri sejak tahun 2014.</p>
            <p>Merek asal kota Tangerang Selatan ini memiliki logo "PB", yang merupakan singkatan dari "price" dan "benefit". Tentu saja, sepatu buatan mereka mempunyai banderol harga yang terjangkau, tapi berkualitas.</p>
        </div>
    </div>
</div>