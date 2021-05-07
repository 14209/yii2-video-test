<?php

declare(strict_types=1);

namespace app\services;

use app\dto\video\VideoDto;
use app\dto\video\VideoSearchParamsDto;
use app\repositories\video\VideoRepositoryInterface;

final class VideoService
{
    public const SORT_DEFAULT_ORDER = 'desc';

    private const SORT_DEFAULT_COLUMN_NAME = 'added_at';
    private const PAGINATION_DEFAULT_LIMIT = 10;
    private const ONE_HOUR_IN_SECONDS = 3600;

    private VideoRepositoryInterface $videosRepository;

    public function __construct(VideoRepositoryInterface $videosRepository)
    {
        $this->videosRepository = $videosRepository;
    }

    /**
     * @param array $params
     *
     * @return VideoDto[]
     */
    public function getVideosByParams(array $params): array
    {
        $idOffset = isset($params['id_offset'])
            ? (int) $params['id_offset']
            : null;
        $videoSearchParamsDto = new VideoSearchParamsDto(
            $params['column'] ?? self::SORT_DEFAULT_COLUMN_NAME,
            $params['order'] ?? self::SORT_DEFAULT_ORDER,
            $params['limit'] ?? self::PAGINATION_DEFAULT_LIMIT,
            $params['column_offset'] ?? null,
            $idOffset,
        );

        return $this->videosRepository->getAll($videoSearchParamsDto);
    }

    /**
     * На вход получает секунды.
     * Если длительность больше часа - то в формате указываем часы, иначе только минуты и секунды
     *
     * @param int $duration
     *
     * @return string
     */
    public static function getPrettyDuration(int $duration): string
    {
        if ($duration < self::ONE_HOUR_IN_SECONDS) {
            return gmdate("i:s", $duration);
        }

        return gmdate("H:i:s", $duration);
    }
}
