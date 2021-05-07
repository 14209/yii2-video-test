<?php

/* @var $this yii\web\View */
/* @var $videos VideoDto[] */

/* @var $pagination yii\data\Pagination */

use app\dto\video\VideoDto;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\services\VideoService;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="sorting">
                <p>Сортировать по:</p>
                <a href="<?php echo Url::to(['video/list', 'column' => 'added_at', 'order' => 'asc', 'page' => $pagination->getPage()]) ?>">
                    added_at asc
                </a>
                <a href="<?php echo Url::to(['video/list', 'column' => 'added_at', 'order' => 'desc', 'page' => $pagination->getPage()]) ?>">
                    added_at desc
                </a>
                <a href="<?php echo Url::to(['video/list', 'column' => 'views_count', 'order' => 'asc', 'page' => $pagination->getPage()]) ?>">
                    views asc
                \</a>
                <a href="<?php echo Url::to(['video/list', 'column' => 'views_count', 'order' => 'desc', 'page' => $pagination->getPage()]) ?>">
                    views desc
                </a>
            </div>
            <?php
            foreach ($videos as $video) {
                ?>
                <div class="item">
                    <div class="title"><?php echo $video->getTitle() ?></div>
                    <div class="thumbnail">
                        <img
                                src="<?php echo Yii::getAlias('@web') . '/' . $video->getThumbnail() ?>"
                                alt="<?php echo $video->getTitle() ?>">
                    </div>
                    <div class="duration">
                        Продолжительность: <?php echo VideoService::getPrettyDuration($video->getDuration()) ?></div>
                    <div class="views">Количество просмотров: <?php echo $video->getViewsCount() ?></div>
                    <div class="added-at">Дата добавления: <?php echo $video->getAddedAt() ?></div>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
        echo LinkPager::widget([
            'pagination' => $pagination,
        ]);
        ?>
    </div>
</div>
