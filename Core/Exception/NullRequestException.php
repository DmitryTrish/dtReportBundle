<?php

namespace DmitryTrish\ReportBundle\Core\Exception;

use Symfony\Component\HttpFoundation\Response;

class NullRequestException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Null request detected.', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}