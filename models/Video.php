<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $title
 * @property string $thumbnail
 * @property int $duration
 * @property string $added_at
 */
final class Video extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'videos';
    }
}
