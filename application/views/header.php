<img class="background-img" src="<?php echo asset_url('/images/head/top-panel.png'); ?>">
<div class="language-switch">

    <?php
        $ge = asset_url('/images/head/lang-geo-sel.png');
        $en = asset_url('/images/head/lang-eng.png');

        $lang = get_language($this);
        if ($lang == 'en') {
            $ge = asset_url('/images/head/lang-geo.png');
            $en = asset_url('/images/head/lang-eng-sel.png');
        }
    ?>

    <ul class="lang-bar">
        <li>
            <a href="/home/lang?id=1">
                <img src="<?php echo $ge; ?>">
            </a>
        </li>
        <li>
            <a href="/home/lang?id=2">
                <img src="<?php echo $en; ?>">
            </a>
        </li>
    </ul>
</div>
<div class="header-container">
    <div class="header-content">
        <div class="logo-menu-search">
            <div class="logo">
                <a href="/">
                    <?php
                        $logo = asset_url('/images/head/logo_ka.png');

                        if ($lang == 'en') {
                            $logo = asset_url('/images/head/logo_en.png');
                        }
                    ?>
                    <img src="<?php echo $logo; ?>">
                </a>
            </div>
            <div class="menu-search">

                <?php
                    $menuKa = '<div class="menu-ka">';
                    if ($lang == 'en') {
                        $menuKa = '<div class="menu-en">';
                    }
                    echo $menuKa;
                ?>

                    <nav class="menu">
                        <?php echo $menuH; ?>
                    </nav>
                </div>
                <div class="search">
                    <form method="GET" action="/home/search" role="form" class="search-form">
                        <input type="text" name="text" class="search-input" placeholder="Search">
                        <input type="submit" class="submit-btn" value="">
                    </form>
                </div>
            </div>
        </div>
        <div class="slider-news-feed">
            <div class="slider">
                <div id="carousel-example-generic" class="carousel slide carouser-size" data-ride="carousel">
                    <?php
                        if ($images) {
                            echo '<div class="carousel-inner carouser-size" role="listbox">';
                            $id = 1;
                            foreach ($images as $image) {
                                $cont = '<div class="item';
                                if ($id == 1) {
                                    $cont .= ' active">';
                                } else {
                                    $cont .= '">';
                                }
                                $cont .= '<img src="'.$image.'">';
                                $cont .= '</div>';
                                $id++;

                                echo $cont;
                            }
                            echo '</div>';
                        }
                    ?>
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
            <div class="news-feed">
                <img class="nf-background" src="<?php echo asset_url('/images/head/blogs-bg.png'); ?>">
                <div class="nf-container">
                    <ul class="nf">
                        <?php
                        if (isset($news_feed)) {
                            foreach ($news_feed as $key => $news) {
                                echo '<li>';
                                echo '<a href="'.'/home/content?content_id='.$news['id'].'">'.$news['title'].'</a>';
                                // echo '<p class="nf-timestamp">'.date('d/m/Y G:i:s', strtotime($news['create_time'])).'</p>';
                                echo '</li>';
                            }
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>