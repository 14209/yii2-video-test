<?php

declare(strict_types=1);

namespace app\repositories\video;

use app\dto\video\VideoSearchParamsDto;

interface VideoRepositoryInterface
{
    public function getAll(VideoSearchParamsDto $videoSearchParamsDto): array;
}
