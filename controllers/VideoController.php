<?php

declare(strict_types=1);

namespace app\controllers;

use app\services\VideoService;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;

final class VideoController extends Controller
{
    private VideoService $videoService;

    public function __construct(
        $id,
        $module,
        VideoService $videoService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);

        $this->videoService = $videoService;
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionList(): string
    {
        $requestParams = Yii::$app->request->get();
        // @todo тут нужно вызвать свой пагинатор, что бы он мог работать с курсором записи, а не offset страницы
        $pagination = new Pagination();
        $requestParams['limit'] = $pagination->getLimit();
        $videos = $this->videoService->getVideosByParams($requestParams);

        return $this->render('list',
            [
                'videos' => $videos,
                'pagination' => $pagination,
            ]
        );
    }
}
