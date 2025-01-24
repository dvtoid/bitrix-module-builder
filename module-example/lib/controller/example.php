<?php

namespace Dvtoid\Example\Controller;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Error;
use Exception;

class Example extends Controller
{
    public function exampleAction(array $fields): ?array
    {
        try {

            return [];

        } catch (Exception $e) {
            $this->addError(new Error($e->getMessage()));
            return null;
        }
    }
}