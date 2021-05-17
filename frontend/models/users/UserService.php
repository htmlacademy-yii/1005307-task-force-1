<?php

declare(strict_types=1);

namespace app\models\users;

use yii\web\Request;
use yii\base\BaseObject;
use yii\web\NotFoundHttpException;

class UserService extends BaseObject
{
    private $request;

    public function __construct(Request $request, array $config = [])
    {
        parent::__construct($config);
        $this->request = $request;
    }

    public function getUsers(UserSearchForm $form): array
    {
       return Users::getDoersByDate();
    }

    private function getFiltering(UserSearchForm $form)
    {
        $id = $this->request->get('category_id');

        if (key_exists($id, $form->getCategoriesFilter())) {
            $form->categoriesFilter[$id] = $id;
        }
    }

    private function postFiltering(UserSearchForm $form)
    {
        $form->load($this->request->post());
    }
}
