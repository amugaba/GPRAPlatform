<?php
require_once __DIR__.'/Validator.php';

class GPRAValidator extends Validator {

    /**
     * @var GPRA
     */
    private $gpra; //GPRA

    /**
     * @param $gpra GPRA
     * @param $questions Question[]
     * @param $option_sets array
     * @param $section int
     * @return ValidationError[]
     * @throws Exception
     */
    public function validate($gpra, $questions, $option_sets, $section)
    {
        $this->gpra = $gpra;

        foreach($questions as $question) {
            $code = $question->code;

            //for null/empty values, add error if required otherwise replace with default value
            if($this->gpra->$code == null || $this->gpra->$code == '') {
                if($question->required) {
                    $this->addError($code, 'Required');
                }
                else {
                    $this->gpra->$code = $question->default_value;
                }
            }
            //for option-based questions, ensure they are using a valid option
            else if($question->option_set != null) {
                if(!Validator::isValidOption($this->gpra->$code, $option_sets[$question->option_set])) {
                    $this->addError($code, 'Invalid option');
                }
            }
            //for text responses, trim whitespace
            else {
                $this->gpra->$code = trim($this->gpra->$code);
            }
        }

        //do custom validation based on section
        switch ($section) {
            case 1: $this->validateSection1(); break;
            case 2: $this->validateSection2(); break;
            case 3: $this->validateSection3(); break;
            case 4: $this->validateSection4(); break;
            case 5: $this->validateSection5(); break;
            case 6: $this->validateSection6(); break;
            case 7: $this->validateSection7(); break;
            case 8: $this->validateSection8(); break;
            case 9: $this->validateSection9(); break;
            case 10: $this->validateSection10(); break;
            case 11: $this->validateSection11(); break;
            case 12: $this->validateSection12(); break;
            case 13: $this->validateSection13($questions); break;
            default: throw new Exception('Error while validating. Section ID invalid.');
        }

        return $this->errors;
    }

    public function getProcessedGPRA() {
        return $this->gpra;
    }
    
    private function validateSection1()
    {
        //date must be in the correct format and not in the future
        $dateObj = DateTime::createFromFormat('m#d#Y',$this->gpra->InterviewDate);
        if($dateObj) {
            $now = new DateTime('now');
            if($dateObj->getTimestamp() - $now->getTimestamp() > 0)
                $this->addError('InterviewDate', 'Date cannot be in the future');
            $this->gpra->InterviewDate = $dateObj->format('m/d/Y');
        }
        else {
            $this->addError('InterviewDate', 'Invalid date');
        }

        //at least one ICD Code must be specified
        if($this->gpra->ICD10CodeOne == null && $this->gpra->ICD10CodeTwo == null && $this->gpra->ICD10CodeThree == null) {
            $this->addError('ICD10CodeOne', 'At least one code must be chosen');
        }
        //the same code cannot be chosen multiple times
        if($this->gpra->ICD10CodeTwo != null && $this->gpra->ICD10CodeTwo == $this->gpra->ICD10CodeOne) {
            $this->addError('ICD10CodeTwo', 'The same code cannot be chosen more than once');
        }
        if($this->gpra->ICD10CodeThree != null && ($this->gpra->ICD10CodeThree == $this->gpra->ICD10CodeOne || $this->gpra->ICD10CodeThree == $this->gpra->ICD10CodeTwo)) {
            $this->addError('ICD10CodeThree', 'The same code cannot be chosen more than once');
        }

        //if opioid or alcohol disorder is not Yes, set days of use to null
        //otherwise check that days is an integer between 0 and 30
        $opioid_codes = ['MethadoneMedicationDays','BuprenorphineMedicationDays','NaltrexoneMedicationDays','NaltrexoneXRMedicationDays'];
        foreach($opioid_codes as $code) {
            if($this->gpra->OpioidDisorder == 1) {
                $this->checkIntegerInRange($code, 0, 30);
            }
            else
                $this->gpra->$code = null;
        }
        $alcohol_codes = ['NaltrexoneAlcMedicationDays','NaltrexoneXRAlcMedicationDays','DisulfiramMedicationDays','AcamprosateMedicationDays'];
        foreach($alcohol_codes as $code) {
            if($this->gpra->AlcoholDisorder == 1) {
                $this->checkIntegerInRange($code, 0, 30);
            }
            else
                $this->gpra->$code = null;
        }

        //set null if skipped
        if($this->gpra->ClientIntake_CooccurringScreen != 1)
            $this->gpra->ClientIntake_CooccurringScreenStatus = null;
    }

    private function validateSection2() {
        //at least one modality must be chosen
        if($this->gpra->SvcCaseManagement == 0 && $this->gpra->SvcDayTreatment == 0 && $this->gpra->SvcInpatient == 0 && $this->gpra->SvcOutpatient == 0 &&
            $this->gpra->SvcOutreach == 0 && $this->gpra->SvcIntensiveOutpatient == 0 && $this->gpra->SvcMethadone == 0 && $this->gpra->SvcResidentialRehab == 0 &&
            $this->gpra->SvcHospitalInpatient == 0 && $this->gpra->SvcFreeStandingRes == 0 && $this->gpra->SvcAmbulatoryDetox == 0 && $this->gpra->SvcAfterCare == 0 &&
            $this->gpra->SvcRecoverySupport == 0 && $this->gpra->SvcOtherModalities == 0) {
            $this->addError('SvcCaseManagement','At least one modality must be chosen');
        }

        //only one detox can be chosen
        if($this->gpra->SvcFreeStandingRes == 1 && $this->gpra->SvcHospitalInpatient == 1) {
            $this->addError('SvcFreeStandingRes','At most one detox can be chosen');
        }
        if($this->gpra->SvcAmbulatoryDetox == 1 && ($this->gpra->SvcFreeStandingRes == 1 || $this->gpra->SvcHospitalInpatient == 1)) {
            $this->addError('SvcAmbulatoryDetox','At most one detox can be chosen');
        }

        $this->validateOtherSpecify('SvcOtherModalities',1, 'SvcOtherModalitesSpec');
        $this->validateOtherSpecify('SvcOtherClinicalCouns',1, 'SvcOtherClinicalCounsSpec');
        $this->validateOtherSpecify('SvcOtherCaseMgmt',1, 'SvcOtherCaseMgmtSpec');
        $this->validateOtherSpecify('SvcOtherMedical',1, 'SvcOtherMedicalSpec');
        $this->validateOtherSpecify('SvcOtherAfterCare',1, 'SvcOtherAfterCareSpec');
        $this->validateOtherSpecify('SvcOtherEdu',1, 'SvcOtherEduSpec');
        $this->validateOtherSpecify('SvcOtherRecovery',1, 'SvcOtherRecoverySpec');
    }

    private function validateSection3() {
        $this->validateOtherSpecify('GenderCode',4, 'GenderOtherSpecify');

        //if not Hispanic, set ethnicity to null
        if($this->gpra->HispanicLatino != 1) {
            $this->gpra->EthnicCentralAmerican = null;
            $this->gpra->EthnicCuban = null;
            $this->gpra->EthnicDominican = null;
            $this->gpra->EthnicMexican = null;
            $this->gpra->EthnicPuertoRican = null;
            $this->gpra->EthnicSouthAmerican = null;
            $this->gpra->EthnicOther = null;
        }
        $this->validateOtherSpecify('EthnicOther',1, 'EthnicOtherSpec');

        //birth year must be in last 100 years
        $now = new DateTime('now');
        $year = intval($now->format('Y'));
        $this->checkIntegerInRange('BirthYear', $year-100, $year);

        //if didn't serve in military, set skipped questions to null
        if($this->gpra->MilitaryServed == null || $this->gpra->MilitaryServed < 1) {
            $this->gpra->ActiveDuty = null;
            $this->gpra->IraqAfghanistan = null;
            $this->gpra->PersianGulf = null;
            $this->gpra->VietnamSoutheastAsia = null;
            $this->gpra->Korea = null;
            $this->gpra->WWII = null;
            $this->gpra->DeployedCombatZone = null;
        }

        for($i=1; $i<=6; $i++) {
            //clear answers that should be skipped
            //skip column 1 if FamilyActiveDuty is not Yes only one or Yes more than one
            $skip_one = $i == 1 && $this->gpra->FamilyActiveDuty != 1 && $this->gpra->FamilyActiveDuty != 2;
            //skip columns 2-6 if FamilyActiveDuty is not Yes more than one
            $skip_rest = $i > 1 && $this->gpra->FamilyActiveDuty != 2;
            if($skip_one || $skip_rest) {
                $code = 'ServiceMemRelationship'.$i;
                $this->gpra->$code = null;
                $code = 'ServiceMemExpDeployed'.$i;
                $this->gpra->$code = null;
                $code = 'ServiceMemExpInjured'.$i;
                $this->gpra->$code = null;
                $code = 'ServiceMemExpCombatStress'.$i;
                $this->gpra->$code = null;
                $code = 'ServiceMemExpDeceased'.$i;
                $this->gpra->$code = null;
            }
            $this->validateOtherSpecify('ServiceMemRelationship'.$i,8, 'ServiceMemExpOther'.$i);
        }
    }

    private function validateSection4() {
        $this->checkIntegerInRange('DAUseAlcoholDays',0,30);

        if($this->gpra->DAUseAlcoholDays > 0) {
            $this->checkIntegerInRange('DAUseAlcoholIntox4Days',0,30);
            $this->checkIntegerInRange('DAUseAlcoholIntox5Days',0,30);

            //their sum must be less than total alcohol use
            if($this->gpra->DAUseAlcoholIntox4Days !== false && $this->gpra->DAUseAlcoholIntox5Days !== false &&
                $this->gpra->DAUseAlcoholIntox4Days + $this->gpra->DAUseAlcoholIntox5Days > $this->gpra->DAUseAlcoholDays)
                $this->addError('DAUseAlcoholDays','Days of alcohol use to intoxication ('
                    .$this->gpra->DAUseAlcoholIntox5Days.'+'.$this->gpra->DAUseAlcoholIntox4Days.') cannot be greater than days of alcohol use ('
                    .$this->gpra->DAUseAlcoholDays.')');
        }
        else {
            $this->gpra->DAUseAlcoholIntox4Days = null;
            $this->gpra->DAUseAlcoholIntox5Days = null;
        }

        //hold off on checking drug days until we know if drugs were used
        $this->checkIntegerInRange('DAUseIllegDrugsDays',0,30);
        if($this->gpra->DAUseAlcoholDays > 0 && $this->gpra->DAUseIllegDrugsDays > 0) {
            $this->checkIntegerInRange('DAUseBothDays',0,30);
            //days of using both must be less than either individual days of use
            if($this->gpra->DAUseBothDays > $this->gpra->DAUseAlcoholDays)
                $this->addError('DAUseBothDays','Days of using alcohol and drugs cannot be greater than days of using alcohol');
            if($this->gpra->DAUseBothDays > $this->gpra->DAUseIllegDrugsDays)
                $this->addError('DAUseBothDays','Days of using alcohol and drugs cannot be greater than days of using drugs');
        }
        else {
            $this->gpra->DAUseBothDays = null;
        }

        //for each substance, check that days of use is a valid integer between 0 and 30. If use==0 days, clear route
        $substances = ['CocaineCrack','MarijuanaHash','OpiatesHeroin','OpiatesMorphine','OpiatesDiluadid','OpiatesDemerol','OpiatesPercocet',
            'OpiatesDarvon','OpiatesCodeine','OpiatesTylenol','OpiatesOxyco','NonPresMethadone','HallucPsych','Metham','Benzodiazepines',
            'Barbituates','NonPrescGhb','Ketamine','OtherTranquilizers','Inhalants','OtherIllegalDrugs'];
        $maxDrugDays = 0;
        $injected = false;
        foreach($substances as $substance) {
            $days_code = $substance.'Days';
            $route_code = $substance.'Route';
            $this->checkIntegerInRange($days_code,0,30);
            if($this->gpra->$days_code > 0)
                $maxDrugDays = max($maxDrugDays, $this->gpra->$days_code);
            else
                $this->gpra->$route_code = null;
            if($this->gpra->$route_code >= 4)
                $injected = true;
        }

        //now check drug days
        if($this->gpra->DAUseIllegDrugsDays < $maxDrugDays) {
            $this->addError('DAUseIllegDrugsDays','Days of drug use cannot be less than the days of use for any individual substance ('.$maxDrugDays.')');
        }

        //have to check other specify without using function since it's a range of values
        if($this->gpra->OtherIllegalDrugsDays > 0) {
            if($this->gpra->OtherIllegalDrugsSpec == null || $this->gpra->OtherIllegalDrugsSpec == '')
                $this->addError('OtherIllegalDrugsSpec', 'Required');
        }
        else {
            $this->gpra->OtherIllegalDrugsSpec = null;
        }

        if($injected && $this->gpra->InjectedDrugs != 1)
            $this->addError('InjectedDrugs','Injected drugs must be Yes because an injection route was chosen above');
        //set null if skipped
        if($this->gpra->InjectedDrugs != 1)
            $this->gpra->ParaphenaliaUsedOthers = null;
    }

    private function validateSection5() {
        if($this->gpra->LivingWhere != 4)
            $this->gpra->LivingHoused = null;
        $this->validateOtherSpecify('LivingHoused',5,'LivingHousedSpec');

        if($this->gpra->DAUseAlcoholDays == 0 && $this->gpra->DAUseIllegDrugsDays == 0) {
            $this->gpra->ImpactStress = null;
            $this->gpra->ImpactActivity = null;
            $this->gpra->ImpactEmotional = null;
        }

        if($this->gpra->GenderCode == 1)
            $this->gpra->Pregnant = null;

        if($this->gpra->Children == 1) {
            $this->checkIntegerInRange('ChildrenNr',1,99, true);
            $num_children = $this->gpra->ChildrenNr > 0 ? $this->gpra->ChildrenNr : 99; //get number of children, if validation error, just use 99
            if($this->gpra->ChildrenCustody == 1) {
                $this->checkIntegerInRange('ChildrenCustodyNr',0, $num_children, true);
            }
            else {
                $this->gpra->ChildrenCustodyNr = null;
            }
            $this->checkIntegerInRange('ChildrenCustodyLost',0, $num_children, true);
        }
        else {
            $this->gpra->ChildrenNr = null;
            $this->gpra->ChildrenCustody = null;
            $this->gpra->ChildrenCustodyNr = null;
            $this->gpra->ChildrenCustodyLost = null;
        }
    }

    private function validateSection6() {
        $this->validateOtherSpecify('TrainingProgram',4,'TrainingProgramSpec');
        $this->validateOtherSpecify('EmployStatus',0,'EmployStatusSpec');

        $this->checkIntegerInRange('IncomeWages',0,999999);
        $this->checkIntegerInRange('IncomePubAssist',0,999999);
        $this->checkIntegerInRange('IncomeRetirement',0,999999);
        $this->checkIntegerInRange('IncomeDisability',0,999999);
        $this->checkIntegerInRange('IncomeNonLegal',0,999999);
        $this->checkIntegerInRange('IncomeFamFriends',0,999999);
        $this->checkIntegerInRange('IncomeOther',0,999999);

        //have to check other specify without using function since it's a range of values
        if($this->gpra->IncomeOther > 0) {
            if($this->gpra->IncomeOtherSpec == null || $this->gpra->IncomeOtherSpec == '')
                $this->addError('IncomeOtherSpec', 'Required');
        }
        else {
            $this->gpra->IncomeOtherSpec = null;
        }
    }

    private function validateSection7() {
        $this->checkIntegerInRange('ArrestedDays',0,99, true);
        if($this->gpra->ArrestedDays > 0) {
            $this->checkIntegerInRange('ArrestedDrugDays',0,$this->gpra->ArrestedDays, true);
        }
        else {
            $this->gpra->ArrestedDrugDays = null;
        }
        $this->checkIntegerInRange('ArrestedConfineDays',0,30, true);
        $this->checkIntegerInRange('NrCrimes',0,999, true);
    }

    private function validateSection8() {
        $this->checkIntegerInRange('InpatientPhysicalNights',0,30);
        $this->checkIntegerInRange('InpatientMentalNights',0,30);
        $this->checkIntegerInRange('InpatientAlcoholSANights',0,30);
        $this->checkIntegerInRange('OutpatientPhysicalTimes',0,99);
        $this->checkIntegerInRange('OutpatientMentalTimes',0,99);
        $this->checkIntegerInRange('OutpatientAlcoholSATimes',0,99);
        $this->checkIntegerInRange('ERPhysicalTimes',0,99);
        $this->checkIntegerInRange('ERMentalTimes',0,99);
        $this->checkIntegerInRange('ERAlcoholSATimes',0,99);

        if($this->gpra->SexActivity == 1) {
            $this->checkIntegerInRange('SexContacts',1,999);
            $this->checkIntegerInRange('SexUnprot',0,$this->gpra->SexContacts);
            if($this->gpra->SexUnprot > 0) {
                $this->checkIntegerInRange('SexUnprotHIVAids',0,$this->gpra->SexUnprot);
                $this->checkIntegerInRange('SexUnprotInjDrugUser',0,$this->gpra->SexUnprot);
                $this->checkIntegerInRange('SexUnprotHigh',0,$this->gpra->SexUnprot);
            }
            else {
                $this->gpra->SexUnprotHIVAids = null;
                $this->gpra->SexUnprotInjDrugUser = null;
                $this->gpra->SexUnprotHigh = null;
            }
        }
        else {
            $this->gpra->SexContacts = null;
            $this->gpra->SexUnprot = null;
            $this->gpra->SexUnprotHIVAids = null;
            $this->gpra->SexUnprotInjDrugUser = null;
            $this->gpra->SexUnprotHigh = null;
        }

        if($this->gpra->fHIVTest != 1)
            $this->gpra->fHIVTestResult = null;

        $this->checkIntegerInRange('Depression',0,30);
        $this->checkIntegerInRange('Anxiety',0,30);
        $this->checkIntegerInRange('Hallucinations',0,30);
        $this->checkIntegerInRange('BrainFunction',0,30);
        $this->checkIntegerInRange('ViolentBehavior',0,30);
        $this->checkIntegerInRange('Suicide',0,30);
        $this->checkIntegerInRange('PsycholEmotMedication',0,30);

        if($this->gpra->Depression == 0 && $this->gpra->Anxiety == 0 && $this->gpra->Hallucinations == 0 && $this->gpra->BrainFunction == 0 &&
            $this->gpra->ViolentBehavior == 0 && $this->gpra->Suicide == 0 && $this->gpra->PsycholEmotMedication == 0) {
            $this->gpra->PsycholEmotImpact = null;
        }
    }

    private function validateSection9() {
        if($this->gpra->AnyViolence != 1) {
            $this->gpra->Nightmares = null;
            $this->gpra->TriedHard = null;
            $this->gpra->ConstantGuard = null;
            $this->gpra->NumbAndDetach = null;
        }
    }

    private function validateSection10() {
        $this->checkIntegerInRange('AttendVoluntaryTimes',0,99,true);
        $this->checkIntegerInRange('AttendReligiousTimes',0,99,true);
        $this->checkIntegerInRange('AttendOtherOrgTimes',0,99,true);

        $this->validateOtherSpecify('WhomInTrouble',5, 'WhomInTroubleSpec');
    }

    private function validateSection11() {
        $this->validateOtherSpecify('FLWPStatus',32, 'FLWPStatusSpec');
    }

    private function validateSection12() {
        //date must be in the correct format and not in the future
        $dateObj = DateTime::createFromFormat('m#d#Y',$this->gpra->DischargeDate);
        if($dateObj) {
            $now = new DateTime('now');
            if($dateObj->getTimestamp() - $now->getTimestamp() > 0)
                $this->addError('DischargeDate', 'Date cannot be in the future');
            $this->gpra->DischargeDate = $dateObj->format('m/d/Y');
        }
        else {
            $this->addError('DischargeDate', 'Invalid date');
        }

        if($this->gpra->DischargeStatusCompl == 2) {
            if($this->gpra->DischargeStatusTermReason == null)
                $this->addError('DischargeStatusTermReason', 'Required');
        }
        else {
            $this->gpra->DischargeStatusTermReason = null;
        }
        $this->validateOtherSpecify('DischargeStatusTermReason',13, 'OtherDischargeStatTermRsnSpec');

        if($this->gpra->jHIVTest != 1)
            $this->gpra->jHIVTestResult = null;
    }

    /**
     * @param $questions Question[]
     */
    private function validateSection13($questions) {
        //for each question except Other Specify, check integer in range
        foreach ($questions as $question) {
            if(strpos($question->code, 'Spec') === false)
                $this->checkIntegerInRange($question->code, 0, 999);
        }
        $this->validateOtherSpecifyRange('SvcOtherModalitiesDis',1, null, 'SvcOtherModalitesSpecDis');
        $this->validateOtherSpecifyRange('SvcOtherCaseMgmtDis',1, null, 'SvcOtherCaseMgmtSpecDis');
        $this->validateOtherSpecifyRange('SvcOtherMedicalDis',1, null, 'SvcOtherMedicalSpecDis');
        $this->validateOtherSpecifyRange('SvcOtherClinicalCounsDis',1, null, 'SvcOtherClinicalCounsSpecDis');
        $this->validateOtherSpecifyRange('SvcOtherAfterCareDis',1, null, 'SvcOtherAfterCareSpecDis');
        $this->validateOtherSpecifyRange('SvcOtherEduDis',1, null, 'SvcOtherEduSpecDis');
        $this->validateOtherSpecifyRange('SvcOtherRecoveryDis',1, null, 'SvcOtherRecoverySpecDis');
    }

    /**
     * If Other question has the given value (i.e. is chosen) and Specify is blank, add error. If Other is not chosen, clear Specify value
     * @param $other_code string
     * @param $other_value int
     * @param $specify_code string
     */
    private function validateOtherSpecify($other_code, $other_value, $specify_code) {
        if($this->gpra->$other_code == $other_value) {
            if($this->gpra->$specify_code == null || $this->gpra->$specify_code == '')
                $this->addError($specify_code, 'Required');
        }
        else {
            $this->gpra->$specify_code = null;
        }
    }

    /**
     * If Other question has a value in the given range and Specify is blank, add error. If Other is not chosen, clear Specify value
     * @param $other_code string
     * @param $min int
     * * @param $max int
     * @param $specify_code string
     */
    private function validateOtherSpecifyRange($other_code, $min, $max, $specify_code) {
        $max = $max ?? 99999;
        $min = $min ?? -99999;
        if($this->gpra->$other_code >= $min && $this->gpra->$other_code <= $max) {
            if($this->gpra->$specify_code == null || $this->gpra->$specify_code == '')
                $this->addError($specify_code, 'Required');
        }
        else {
            $this->gpra->$specify_code = null;
        }
    }

    /**
     * @param $code string
     * @param $min int
     * @param $max int
     * @param $allow_null bool
     */
    private function checkIntegerInRange($code, $min, $max, $allow_null = false) {
        if($allow_null && ($this->gpra->$code == null || $this->gpra->$code == '')) {
            $this->gpra->$code = null;
        }
        else {
            $value = filter_var($this->gpra->$code, FILTER_VALIDATE_INT);
            $this->gpra->$code = $value;
            if ($value === false || $value < $min || $value > $max)
                $this->addError($code, 'Must be an integer between ' . $min . ' and ' . $max);
        }
    }
}