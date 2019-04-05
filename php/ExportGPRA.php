<?php

/**
 * @param $gpra GPRA
 */
function exportGPRA($gpra) {
    //ICD
    //Convert null values to -7 None of the Above

    //if ICD10CodeOne is null, shift the other ones upwards and change the category to match
    if($gpra->ICD10CodeOne == null) {
        if($gpra->ICD10CodeTwo != null) {
            $gpra->ICD10CodeOne = $gpra->ICD10CodeTwo;
            $gpra->ICD10CodeTwo = $gpra->ICD10CodeThree;
            $gpra->ICD10CodeThree = "-7";
            $gpra->ICD10CodeOneCategory = 2;
            $gpra->ICD10CodeTwoCategory = 3;
            $gpra->ICD10CodeThreeCategory = 1;
        }
        //If both One and Two are null
        else if($gpra->ICD10CodeThree != null) {
            $gpra->ICD10CodeOne = $gpra->ICD10CodeThree;
            $gpra->ICD10CodeTwo = "-7";
            $gpra->ICD10CodeThree = "-7";
            $gpra->ICD10CodeOneCategory = 3;
            $gpra->ICD10CodeTwoCategory = 1;
            $gpra->ICD10CodeThreeCategory = 2;
        }
    }

    //Medication days
    //if medication days is listed, used medication is Yes, otherwise No
    $gpra->MethadoneMedication = $gpra->MethadoneMedicationDays > 0 ? 1 : 0;
    $gpra->BuprenorphineMedication = $gpra->BuprenorphineMedicationDays > 0 ? 1 : 0;
    $gpra->NaltrexoneMedication = $gpra->NaltrexoneMedicationDays > 0 ? 1 : 0;
    $gpra->NaltrexoneXRMedication = $gpra->NaltrexoneXRMedicationDays > 0 ? 1 : 0;
    $gpra->NaltrexoneAlcMedication = $gpra->NaltrexoneAlcMedicationDays > 0 ? 1 : 0;
    $gpra->NaltrexoneXRAlcMedication = $gpra->NaltrexoneXRAlcMedicationDays > 0 ? 1 : 0;
    $gpra->DisulfiramMedication = $gpra->DisulfiramMedicationDays > 0 ? 1 : 0;
    $gpra->AcamprosateMedication = $gpra->AcamprosateMedicationDays > 0 ? 1 : 0;
}