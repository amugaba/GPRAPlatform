<?php

class TestingResult
{
    public $previous_test;
    public $hiv_result;
    public $hiv_result_received;
    public $hiv_referred;
    public $hep_b_result;
    public $hep_c_result;
    public $hep_result_received;
    public $hep_referred;
    public $hep_vaccination;

    public function fill($dbobj)
    {
        $this->previous_test = isset($dbobj->previous_test) ? $dbobj->previous_test : null;
        $this->hiv_result = isset($dbobj->hiv_result) ? $dbobj->hiv_result : null;
        $this->hiv_result_received = isset($dbobj->hiv_result_received) ? $dbobj->hiv_result_received : null;
        $this->hiv_referred = isset($dbobj->hiv_referred) ? $dbobj->hiv_referred : null;
        $this->hep_b_result = isset($dbobj->hep_b_result) ? $dbobj->hep_b_result : null;
        $this->hep_c_result = isset($dbobj->hep_c_result) ? $dbobj->hep_c_result : null;
        $this->hep_result_received = isset($dbobj->hep_result_received) ? $dbobj->hep_result_received : null;
        $this->hep_referred = isset($dbobj->hep_referred) ? $dbobj->hep_referred : null;
        $this->hep_vaccination = isset($dbobj->hep_vaccination) ? $dbobj->hep_vaccination : null;
    }
}