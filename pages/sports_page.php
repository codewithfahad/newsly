<!DOCTYPE html>
<html lang="en">
<?php
$title = "Sports";
include_once('../inc/header.php');
?>

<body>
<div class="container">
    <?php
    include_once('../inc/navbar.html')
    ?>
    <main class="container">
        <?php
        include_once('../functions/db_functions.php');
        include_once('../config/config.php');

        $db_instance = new DBClass();
        $trending = $db_instance->getCategorySubCategory($pdo, 'sports', 'trending', 4);
        ?>

        <?php
        $news_article = $db_instance->getCategorySubCategory($pdo, 'sports', 'featured', 1);
        $all_news = $db_instance->getCategoryBasedNews($pdo, 'sports');
        $latest_news = $db_instance->getCategorySubCategory($pdo, 'sports', 'latest', 3);

        include_once('../inc/featured_card.php')
        ?>

        <!-- Latest Sports News -->
        <div class="row mb-2">
            <div class="section-heading d-flex justify-content-between align-items-center py-4">
                <h3 class="font-italic">Trending News</h3>
            </div>
            <?php foreach ($trending as $trending_news): ?>
                <div class="col-lg-3 col-md-6">
                    <div class="card mb-4">
                        <img src="/newsly/assets/<?php echo $trending_news->cover_image ?>" class="card-img-top"
                             alt="..."/>
                        <div class="card-body">
                            <strong class="d-inline-block mb-2 text-primary"><?php echo $trending_news->name ?></strong>
                            <h5 class="card-title"><?php echo $trending_news->title ?></h5>
                            <div class="mb-1 text-muted"><?php
                                include_once('../functions/utils.php');
                                echo getFormattedDateTime($trending_news->created_at);
                                ?></div>
                            <div class="card-text">
                                <?php

                                $htmlContent = json_decode($trending_news->content, true)['data'];
                                echo substr(getUnformattedTextFromHtml($htmlContent), 0, 500);
                                ?>
                            </div>
                            <?php foreach (getTagsList($trending_news->tags) as $t) : ?>

                                <a href="./all_tag_posts_page.php?tag=<?php echo $t; ?>" class="text-muted fst-italic text-decoration-none me-1">#<?php echo $t ?></a>

                            <?php endforeach; ?>
                        </div>

                        <div class="card-body">
                            <a href="/newsly/pages/layouts/article_page_layout.php?id=<?php echo $trending_news->n_id; ?>"
                               class="card-link">Read More</a>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>

        <!-- Best Articles -->
        <div class="row mt-4">
            <div class="section-heading d-flex justify-content-between align-items-center py-4">
                <h3 class="font-italic">Latest</h3>
            </div>
            <?php for ($x = 0; $x <= 1; $x++): ?>
                <?php if ($x == 0): ?>
                    <div class="big-card col-lg-8 col-md-12">
                        <div class="card mb-4">
                            <img src="../assets/<?php echo $latest_news[$x]->cover_image; ?>" class="card-img-top"
                                 alt="..."/>
                            <div class="card-body">
                                <strong class="d-inline-block mb-2 text-success"><?php echo $latest_news[$x]->name; ?></strong>
                                <h5 class="card-title"><?php echo $latest_news[$x]->title; ?></h5>
                                <div class="mb-1 text-muted"><?php include_once('../functions/utils.php');
                                    echo getFormattedDateTime($latest_news[$x]->created_at); ?></div>
                                <p class="card-text">
                                    <?php $htmlContent = json_decode($latest_news[$x]->content, true)['data'];
                                    echo substr(getUnformattedTextFromHtml($htmlContent), 0, 500)."..."; ?>
                                </p>
                                <?php foreach (getTagsList($latest_news[$x]->tags) as $t) : ?>

                                    <a href="./all_tag_posts_page.php?tag=<?php echo $t; ?>" class="text-muted fst-italic text-decoration-none me-1">#<?php echo $t ?></a>

                                <?php endforeach; ?>
                                <a href="/newsly/pages/layouts/article_page_layout.php?id=<?php echo $latest_news[$x]->n_id; ?>"
                                   class="card-link">Read More</a>
                            </div>
                            <div class="card-body"></div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
            <div class="row col-lg-4 col-md-12 px-0 mx-0">
                <?php for ($x = 0; $x <= count($latest_news)-1; $x++): ?>
                    <?php if ($x != 0): ?>
                        <div class="col-lg-12 col-md-6 mb-3">
                            <div class="card mb-4">
                                <img src="../assets/<?php echo $latest_news[$x]->cover_image; ?>" class="card-img-top"
                                     alt="..."/>
                                <div class="card-body">
                                    <strong class="d-inline-block mb-2 text-success"><?php echo $latest_news[$x]->name; ?></strong>
                                    <h5 class="card-title"><?php echo $latest_news[$x]->title; ?></h5>
                                    <div class="mb-1 text-muted"><?php include_once('../functions/utils.php');
                                        echo getFormattedDateTime($latest_news[$x]->created_at); ?></div>
                                    <p class="card-text">
                                        <?php $htmlContent = json_decode($latest_news[$x]->content, true)['data'];
                                        echo substr(getUnformattedTextFromHtml($htmlContent), 0, 500)."..."; ?>
                                    </p>
                                    <?php foreach (getTagsList($latest_news[$x]->tags) as $t) : ?>

                                        <a href="./all_tag_posts_page.php?tag=<?php echo $t; ?>" class="text-muted fst-italic text-decoration-none me-1">#<?php echo $t ?></a>

                                    <?php endforeach; ?>
                                </div>

                                <div class="card-body">
                                    <a href="/newsly/pages/layouts/article_page_layout.php?id=<?php echo $latest_news[$x]->n_id; ?>"
                                       class="card-link">Read More</a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>

        </div>

        <!-- All Stories Section -->
        <div class="row mb-2">
            <div class="section-heading d-flex justify-content-between align-items-center py-4">
                <h3 class="font-italic">All Stories</h3>
            </div>
            <?php foreach ($all_news as $a_news): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="../assets/<?php echo $a_news->cover_image ?>" class="card-img-top" alt="..."/>
                        <div class="card-body">
                            <strong class="d-inline-block mb-2 text-success"><?php echo $a_news->name ?></strong>
                            <h5 class="card-title"><?php echo $a_news->title ?></h5>
                            <div class="mb-1 text-muted"><?php include_once('../functions/utils.php');
                                echo getFormattedDateTime($a_news->created_at); ?></div>
                            <p class="card-text">
                                <?php

                                $htmlContent = json_decode($a_news->content, true)['data'];
                                echo substr(getUnformattedTextFromHtml($htmlContent), 0, 500)."...";
                                ?>
                            </p>
                            <?php foreach (getTagsList($a_news->tags) as $t) : ?>

                                <a href="./all_tag_posts_page.php?tag=<?php echo $t; ?>" class="text-muted fst-italic text-decoration-none me-1">#<?php echo $t ?></a>

                            <?php endforeach; ?>
                        </div>

                        <div class="card-body">
                            <a href="/newsly/pages/layouts/article_page_layout.php?id=<?php echo $a_news->n_id; ?>"
                               class="card-link">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Upcoming writers -->
            <?php
            $category = "sports";
            include_once('../inc/upcoming_writers.php')
            ?>
    </main>
</div>

<?php include_once('../inc/footer.html') ?>

</body>

</html>