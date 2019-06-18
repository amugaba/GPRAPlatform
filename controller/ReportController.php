<?php

class ReportController extends Controller
{
    public function getIndex()
    {
        $view = new View('report/index.php');
        return $view->render();
    }
}