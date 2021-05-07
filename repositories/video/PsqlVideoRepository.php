<?php

declare(strict_types=1);

namespace app\repositories\video;

use app\dto\video\VideoDto;
use app\dto\video\VideoSearchParamsDto;
use app\services\VideoService;
use Yii;
use yii\db\Connection;
use yii\db\Exception;

/**
 * Репозиторий для работы с данными из postgresql
 */
final class PsqlVideoRepository implements VideoRepositoryInterface
{
    private Connection $db;

    public function __construct()
    {
        $this->db = Yii::$app->db;
    }

    /**
     * @param VideoSearchParamsDto $videoSearchParamsDto
     *
     * @return VideoDto[]
     * @throws Exception
     */
    public function getAll(VideoSearchParamsDto $videoSearchParamsDto): array
    {
        $videosDto = [];
        $columnOffset = $videoSearchParamsDto->getColumnOffset();
        $idOffset = $videoSearchParamsDto->getIdOffset();
        $sql = $this->prepareGetAllSql($videoSearchParamsDto);

        $command = $this->db
            ->createCommand($sql)
            ->bindValue(':limit', $videoSearchParamsDto->getLimit());

        if ($columnOffset !== null) {
            $command->bindValue(':column_offset', $columnOffset);
        }

        if ($idOffset !== null) {
            $command->bindValue(':id_offset', $idOffset);
        }

        $videos = $command->queryAll();

        foreach ($videos as $video) {
            $videosDto[] = new VideoDto(
                $video['title'],
                $video['thumbnail'],
                $video['duration'],
                $video['added_at'],
                $video['views_count'],
                $video['id'],
            );
        }

        return $videosDto;
    }

    private function prepareGetAllSql(VideoSearchParamsDto $videoSearchParamsDto): string
    {
        $columnOffset = $videoSearchParamsDto->getColumnOffset();
        $idOffset = $videoSearchParamsDto->getIdOffset();
        $sortColumn = $videoSearchParamsDto->getColumn();
        $sortOrder = $videoSearchParamsDto->getOrder();
        $compareSign = $sortOrder === VideoService::SORT_DEFAULT_ORDER ? '<' : '>';

        $firstSelectCondition = $columnOffset !== null
            ? "where {$sortColumn} = :column_offset and id {$compareSign} :id_offset"
            : '';
        $secondSelectCondition = $idOffset !== null
            ? "where {$sortColumn} {$compareSign} :column_offset"
            : '';

        return sprintf("
            (select
                *
            from videos
            inner join videos_views
                on video_id = id
            %s
            order by {$sortColumn} {$sortOrder}, id {$sortOrder}
            limit :limit)
            
            union
            
            (select
                *
            from videos
            inner join videos_views
                on video_id = id
            %s
            order by {$sortColumn} {$sortOrder}, id {$sortOrder}
            limit :limit)
            
            order by {$sortColumn} {$sortOrder}, id {$sortOrder}
            limit :limit;
            ",
            $firstSelectCondition,
            $secondSelectCondition
        );
    }
}
