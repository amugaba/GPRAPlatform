<?php
//when adding a new GPRA, only display the top level and use the /gpra/add link
$type = $this->assessment->assessment_type;
$id = $this->assessment->episode_id;

$type_labels = [GPRA::INTAKE => 'GPRA Intake', GPRA::DISCHARGE => 'GPRA Discharge',
    GPRA::FOLLOWUP_3MONTH => 'GPRA 3-Month Followup', GPRA::FOLLOWUP_6MONTH => 'GPRA 6-Month Followup'];
$label = $type_labels[$this->assessment->gpra_type];

echo "
    <li class='nav-item'>
        <a class='nav-link' href='/gpra/add?episode=$id&type=$type'>
            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-file-text'><path d='M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z'></path><polyline points='14 2 14 8 20 8'></polyline><line x1='16' y1='13' x2='8' y2='13'></line><line x1='16' y1='17' x2='8' y2='17'></line><polyline points='10 9 9 9 8 9'></polyline></svg>
            $label
        </a>
    </li>";