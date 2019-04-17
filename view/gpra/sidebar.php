<?php
//display all pages up to and including the current section of the assessment
$current_section = $this->section; //from controller
$max_section = $this->assessment->progress;
$id = $this->assessment->id;
$section_list = GPRA::SECTIONS[$this->assessment->assessment_type];
$max_index = array_search($max_section, $section_list);
$displayed_sections = array_slice($section_list, 0, $max_section+1);

//display assessment front page
$type_labels = [AssessmentTypes::GPRAIntake => 'GPRA Intake', AssessmentTypes::GPRADischarge => 'GPRA Discharge',
    AssessmentTypes::GPRA3MonthFollowup => 'GPRA 3-Month Followup', AssessmentTypes::GPRA6MonthFollowup => 'GPRA 6-Month Followup'];
$label = $type_labels[$this->assessment->assessment_type];
echo "
    <li class='nav-item'>
        <a class='nav-link' href='/gpra?id=$id'>
            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-file-text'><path d='M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z'></path><polyline points='14 2 14 8 20 8'></polyline><line x1='16' y1='13' x2='8' y2='13'></line><line x1='16' y1='17' x2='8' y2='17'></line><polyline points='10 9 9 9 8 9'></polyline></svg>
            $label
        </a>
    </li>";

//then add all of the displayed sections
$section_labels = [1 => 'A. Record Management', 2 => 'A. Planned Services', 3 => 'A. Demographics', 4 => 'B. Drug and Alcohol Use',
    5 => 'C. Family and Living Conditions', 6 => 'D. Education and Employment', 7 => 'E. Crime and Criminal Status',
    8 => 'F. Health and Treatment/Recovery', 9 => 'F. Violence and Trauma', 10 => 'G. Social Connectedness',
    11 => 'I. Followup Status', 12 => 'J. Discharge Status', 13 => 'K. Services Provided'];
foreach ($displayed_sections as $section) {
    $label = $section_labels[$section];
    echo "
    <li class='nav-item'>
        <a class='nav-link nav-sublink' href='/gpra?id=$id&section=$section'>$label</a>
    </li>";
}