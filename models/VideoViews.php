<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $video_id
 * @property int $views_count
 */
final class VideoViews extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'videos_views';
    }
}