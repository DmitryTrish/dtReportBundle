<?php

namespace DmitryTrish\ReportBundle\Core\Exception;

use Symfony\Component\HttpFoundation\Response;

class FailPersistException extends \Exception
{
    public function __construct($message = 'Fail persist')
    {
        parent::__construct($message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}