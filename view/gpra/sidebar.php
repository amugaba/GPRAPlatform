<?php
//display all pages up to and including the current section of the assessment
$current_section = $this->section; //from controller
$max_section = $this->assessment->progress;
$id = $this->assessment->id;
$section_list = GPRA::getSections($this->assessment->assessment_type, $this->assessment->interview_conducted);
$max_index = array_search($max_section, $section_list);
$displayed_sections = array_slice($section_list, 0, $max_index+2);

//display assessment front page
$type_labels = [GPRA::INTAKE => 'GPRA Intake', GPRA::DISCHARGE => 'GPRA Discharge',
    GPRA::FOLLOWUP_3MONTH => 'GPRA 3-Month Followup', GPRA::FOLLOWUP_6MONTH => 'GPRA 6-Month Followup'];

//then add all of the displayed sections
$section_labels = [1 => 'A. Record Management', 2 => 'A. Planned Services', 3 => 'A. Demographics', 4 => 'B. Drug and Alcohol Use',
    5 => 'C. Living Conditions', 6 => 'D. Education/Employment', 7 => 'E. Criminal Status',
    8 => 'F. Health and Treatment', 9 => 'F. Violence and Trauma', 10 => 'G. Social Connectedness',
    11 => 'I. Followup Status', 12 => 'J. Discharge Status', 13 => 'K. Services Provided'];

foreach ($displayed_sections as $section) {
    $active = $section == $current_section ? 'active' : '';
    if($section == 0) {
        $label = $type_labels[$this->assessment->gpra_type];
        echo "
        <li class='nav-item'>
            <a class='nav-link $active' href='/gpra?id=$id'>
                <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-file-text'><path d='M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z'></path><polyline points='14 2 14 8 20 8'></polyline><line x1='16' y1='13' x2='8' y2='13'></line><line x1='16' y1='17' x2='8' y2='17'></line><polyline points='10 9 9 9 8 9'></polyline></svg>
                $label
            </a>
        </li>";
    }
    else {
        $label = $section_labels[$section];
        echo "
        <li class='nav-item'>
            <a class='nav-link nav-sublink $active' href='/gpra?id=$id&section=$section'>$label</a>
        </li>";
    }
}