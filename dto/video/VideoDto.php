<?php

declare(strict_types=1);

namespace app\dto\video;

/**
 * DTO для удобной работы с объектом одного видео
 */
final class VideoDto
{
    private ?int $id;

    private string $title;

    private string $thumbnail;

    private int $duration;

    private string $addedAt;

    private int $viewsCount;

    public function __construct(
        string $title,
        string $thumbnail,
        int $duration,
        string $addedAt,
        int $viewsCount,
        ?int $id
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->thumbnail = $thumbnail;
        $this->duration = $duration;
        $this->addedAt = $addedAt;
        $this->viewsCount = $viewsCount;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function getAddedAt(): string
    {
        return $this->addedAt;
    }

    /**
     * @return int
     */
    public function getViewsCount(): int
    {
        return $this->viewsCount;
    }
}
