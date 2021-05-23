<?php

declare(strict_types=1);

namespace app\models\tasks;

use yii\web\Request;
use yii\base\BaseObject;
use yii\web\NotFoundHttpException;

class TaskService extends BaseObject
{
    private $request;

    public function __construct(Request $request, array $config = [])
    {
        parent::__construct($config);
        $this->request = $request;
    }

    public function getTasks(TaskSearchForm $form): array
    {
        //  $this->request->isGet ? $this->getFiltering($form) : $this->postFiltering($form);
        // if (array_filter($form->attributes)) {
        return Tasks::getNewTasksByDate();
        // }

        //    return Users::getDoersByDate();
    }

    private function getFiltering(TaskSearchForm $form)
    {
        $id = $this->request->get('categories_id');

        if (key_exists($id, $form->getAdditionalOptions())) {
            $form->categoriesFilter[$id] = $id;
        }
    }

    private function postFiltering(TaskSearchForm $form)
    {
        $form->load($this->request->post());
    }
}
