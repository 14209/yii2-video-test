<?php

declare(strict_types=1);

namespace app\dto\video;

/**
 * DTO для работы с параметрами запроса к списку видео
 */
final class VideoSearchParamsDto
{
    private string $column;

    private string $order;

    private ?string $columnOffset;

    private ?int $idOffset;

    private int $limit;

    public function __construct(
        string $column,
        string $order,
        int $limit,
        ?string $columnOffset = null,
        ?int $idOffset = null
    )
    {
        $this->column = $column;
        $this->order = $order;
        $this->limit = $limit;
        $this->columnOffset = $columnOffset;
        $this->idOffset = $idOffset;
    }

    /**
     * @return string
     */
    public function getColumn(): string
    {
        return $this->column;
    }

    /**
     * @return string
     */
    public function getOrder(): string
    {
        return $this->order;
    }

    /**
     * @return string|null
     */
    public function getColumnOffset(): ?string
    {
        return $this->columnOffset;
    }

    /**
     * @return int|null
     */
    public function getIdOffset(): ?int
    {
        return $this->idOffset;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }
}
