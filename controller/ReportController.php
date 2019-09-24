<?php

class ReportController extends Controller
{
    public function getIndex()
    {
        $view = new View('report/index.php');
        return $view->render();
    }

    /**
     * @throws Exception
     */
    public function getExport()
    {
        $ds = DataService::getInstance();
        $gpras = $ds->getAssessmentsNotExported();
        $view = new View('report/export.php');
        $view->gpras = $gpras;
        return $view->render();
    }

    /**
     * @throws Exception
     */
    public function postSearchGPRAs() {
        $data = ajax_input();
        $assessment_id = $data[0];
        $client_id = $data[1];
        $start_date = $data[2];
        $end_date = $data[3];
        $unexported_only = $data[4];
        $ds = DataService::getInstance();
        $gpras = $ds->searchGPRAs($assessment_id, $client_id, $start_date, $end_date, $unexported_only);
        ajax_output(true, $gpras);
    }

    /**
     * @throws Exception
     */
    public function postExportGPRAs() {
        $data = ajax_input();
        $assessment_ids = $data[0];
        $ds = DataService::getInstance();
        $gpras = $ds->exportGPRAs($assessment_ids);
        ajax_output(true, $gpras);
    }
}