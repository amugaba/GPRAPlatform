/**
 * This file, when run locally on a web browser accessing SPARS, automates the entry CSAT GPRAs
 * 1. Go to GPRA Platform > Export and export new GPRAs to a JSON text file
 * 2. Navigate to the SPARS CSAT web page
 * 3. Open console or Scratchpad
 * 4. Open this script
 * 5. Paste the JSON into the beginning of the script to save it under gpras variable
 * 6. Run script
 */

gpras = [];
//set gpras variable in console with actual JSON
index = -1; //index of current GPRA
MV = -9; //missing value
RF = -7;

//This has to be run on the SPARS page because otherwise browser blocks it as XSS
function runUpload() {
    log('Staring upload');
    index = -1;
    spars = window.open("https://spars-csat.samhsa.gov/System.aspx", "test");
    setTimeout(function () {
        spars.document.getElementById('ProgramSelection').click();
    }, 1000);
    setTimeout(function () {
        spars.document.getElementById('Tce').click();
    }, 2000);
    setTimeout(function () {
        startNextGPRA();
    }, 3000);
}

function log(text) {
    console.log(text);
}
function assert(condition, message) {
    if(condition) {
        console.error(message, this);
        throw new Error('Stopping');
    }
}

//if value is empty, replace it with missing value code like -9
//then set value and trigger change function
function setValue(inputID, value, missingValue = null, triggerChange = true) {
    if((value == null || value === "") && missingValue != null) {
        value = missingValue;
    }
    if (triggerChange)
        spars.$('#' + inputID).val(value).trigger('change');
    else
        spars.$('#' + inputID).val(value);
}
function clickButton(elementID) {
    spars.$('#'+elementID).click();
}

//call this function whenever it's time to start the next GPRA
function startNextGPRA() {
    index++;
    if(index < gpras.length) {
        data = gpras[index];
        log('GPRA #' + index + " " + data.client_uid);
        assert(spars.document.title !== "Interview Selection", "Incorrect page");
        if(data.gpra_type === 1) {
            log("Type == Intake");
            spars.document.getElementById('NewIntake').click();
            setTimeout(inputPage1, 1000, data);
        }
        else {
            setValue("ClientID", data.client_uid); //search for record by client ID
            clickButton("ToolBar_Query");
            setTimeout(function() {
                if(data.gpra_type === 2) {
                    log("Type == Discharge");
                    spars.document.getElementById('AddDischarge').click();
                    setTimeout(function () {
                        clickButton('Yes');
                        setTimeout(recordManagementFD, 1000, data);
                    }, 1000, data);
                }
                else if(data.gpra_type === 3) {
                    log("Type == 3 Month Followup");
                    spars.document.getElementById('Add3Month').click();
                    setTimeout(function () {
                        clickButton('Yes');
                        setTimeout(recordManagementFD, 1000, data);
                    }, 1000, data);
                }
                else if(data.gpra_type === 4) {
                    log("Type == 6 Month Followup");
                    spars.document.getElementById('Add6Month').click();
                    setTimeout(function () {
                        clickButton('Yes');
                        setTimeout(recordManagementFD, 1000, data);
                    }, 1000, data);
                }
            }, 1000, data);
        }
    }
    else
        log('GPRA upload finished');
}

function recordManagementFD(data) {
    console.log("page 1");
    assert(spars.$('#ClientIntake_ClientID').length === 0, "Incorrect page");
    setValue('ConductedInterview', data.ConductedInterview);
    setTimeout(function() {
        if(data.ConductedInterview === "0") {
            clickButton('ToolBar_Next');
            //skip to J Discharge Status
            if(data.gpra_type === 2)
                setTimeout(dischargeSectionJ, 1000, data);
            else if(data.gpra_type === 3 || data.gpra_type === 4)
                setTimeout(followupSectionI, 1000, data);
        }
        else {
            setValue('InterviewDate', data.InterviewDate, null, false);
            clickButton('ToolBar_Next');
            setTimeout(dischargeExtraScreen, 1000, data);
        }
    }, 1000, data);
}

function dischargeExtraScreen(data) {
    console.log("Discharge confirm page");
    if(spars.$('#ConfirmMessage').length === 0) {
        inputPage2(data);
    }
    else {
        clickButton('No');
        setTimeout(inputPage2, 1000, data);
    }
}

function inputPage1(data) {
    console.log("page 1");
    assert(spars.$('#ClientIntake_ClientID').length === 0, "Incorrect page");
    setValue('ClientIntake_ClientID', data.client_uid);
    setValue('ClientIntake_ClientType', data.ClientType);
    setValue('InterviewDate', data.InterviewDate, null, false);
    clickButton('ToolBar_Next');
    setTimeout(inputPage2, 1000, data);
}

function inputPage2(data) {
    console.log("page 2");
    assert(spars.$('#Icd10CodeOne').length === 0, "Incorrect page");
    //for each ICD code starting from One, if it is not blank, set current ICD Box to its value and set the category that corresponds
    //to that box to primary/secondary/tertiary depending on whether it is One/Two/Three. Then progress to next box
    let icdDiagnoses = ["#Icd10CodeOne", "#Icd10CodeTwo", "#Icd10CodeThree"];
    let icdCategories = ["Icd10CodeOneCategory", "Icd10CodeTwoCategory", "Icd10CodeThreeCategory"];
    let currentICD = 0;
    if(data.ICD10CodeOne > 0) {
        spars.$(icdDiagnoses[currentICD]).data('selectize').setValue(data.ICD10CodeOne);
        setValue(icdCategories[currentICD], 1); //Primary
        currentICD++;
    }
    if(data.ICD10CodeTwo > 0) {
        spars.$(icdDiagnoses[currentICD]).data('selectize').setValue(data.ICD10CodeTwo);
        setValue(icdCategories[currentICD], 2); //Secondary
        currentICD++;
    }
    if(data.ICD10CodeThree > 0) {
        spars.$(icdDiagnoses[currentICD]).data('selectize').setValue(data.ICD10CodeThree);
        setValue(icdCategories[currentICD], 3); //Tertiary
        currentICD++;
    }
    if(currentICD === 0)
        spars.$("input:checkbox").eq(0).trigger('click');//click the Don't Know checkbox

    setValue('OpioidDisorder', data.OpioidDisorder, MV);
    setValue('OpioidMedicationMethadone', data.MethadoneMedicationDays > 0 ? 1 : 0);
    if(data.MethadoneMedicationDays > 0)
        setValue('OpioidMedicationMethadoneDays', data.MethadoneMedicationDays);
    setValue('OpioidMedicationBuprenorphine', data.BuprenorphineMedicationDays > 0 ? 1 : 0);
    if(data.BuprenorphineMedicationDays > 0)
        setValue('OpioidMedicationBuprenorphineDays', data.BuprenorphineMedicationDays);
    setValue('OpioidMedicationNaltrexone', data.NaltrexoneMedicationDays > 0 ? 1 : 0);
    if(data.NaltrexoneMedicationDays > 0)
        setValue('OpioidMedicationNaltrexoneDays', data.NaltrexoneMedicationDays);
    setValue('OpioidMedicationExtendedReleaseNaltrexone', data.NaltrexoneXRMedicationDays > 0 ? 1 : 0);
    if(data.NaltrexoneXRMedicationDays > 0)
        setValue('OpioidMedicationExtendedReleaseNaltrexoneDays', data.NaltrexoneXRMedicationDays);

    //if all medications are No, answer two redundant questions based on previous data
    if(data.MethadoneMedicationDays == 0 && data.BuprenorphineMedicationDays == 0
        && data.NaltrexoneMedicationDays == 0 && data.NaltrexoneXRMedicationDays == 0) {
        if(data.OpioidDisorder === "1")
            setValue('OpioidMedicationNotFdaApprovedDiagnosed', 1);
        else {
            setValue('OpioidMedicationNotFdaApprovedDiagnosed', 0);
            setValue('OpioidMedicationNotFdaApprovedNotDiagnosed', 1);
        }
    }

    setValue('AlcoholDisorder', data.AlcoholDisorder, MV);
    setValue('AlcoholMedicationNaltrexone', data.NaltrexoneAlcMedicationDays > 0 ? 1 : 0);
    if(data.NaltrexoneAlcMedicationDays > 0)
        setValue('AlcoholMedicationNaltrexoneDays', data.NaltrexoneAlcMedicationDays);
    setValue('AlcoholMedicationExtendedReleaseNaltrexone', data.NaltrexoneXRAlcMedicationDays > 0 ? 1 : 0);
    if(data.NaltrexoneXRAlcMedicationDays > 0)
        setValue('AlcoholMedicationExtendedReleaseNaltrexoneDays', data.NaltrexoneXRAlcMedicationDays);
    setValue('AlcoholMedicationDisulfiram', data.DisulfiramMedicationDays > 0 ? 1 : 0);
    if(data.DisulfiramMedicationDays > 0)
        setValue('AlcoholMedicationDisulfiramDays', data.DisulfiramMedicationDays);
    setValue('AlcoholMedicationAcamprosate', data.AcamprosateMedicationDays > 0 ? 1 : 0);
    if(data.AcamprosateMedicationDays > 0)
        setValue('AlcoholMedicationAcamprosateDays', data.AcamprosateMedicationDays);

    //if all medications are No, answer two redundant questions based on previous data
    if(data.NaltrexoneAlcMedicationDays == 0 && data.NaltrexoneXRAlcMedicationDays == 0
        && data.DisulfiramMedicationDays == 0 && data.AcamprosateMedicationDays == 0) {
        if(data.AlcoholDisorder === "1")
            setValue('AlcoholMedicationNotFdaApprovedDiagnosed', 1);
        else {
            setValue('AlcoholMedicationNotFdaApprovedDiagnosed', 0);
            setValue('AlcoholMedicationNotFdaApprovedNotDiagnosed', 1);
        }
    }

    setValue('ClientIntake_CooccurringScreen', data.ClientIntake_CooccurringScreen, MV);
    setValue('ClientIntake_CooccurringScreenStatus', data.ClientIntake_CooccurringScreenStatus, MV);

    clickButton('ToolBar_Next');
    if(data.gpra_type === 1)
        setTimeout(inputPage3, 1000, data);
    else if(data.gpra_type === 2 || data.gpra_type === 3 || data.gpra_type === 4)
        setTimeout(inputPage9, 1000, data);
}

function inputPage3(data) {
    console.log("page 3");
    assert(spars.$('#Modality1CaseManagement').length === 0, "Incorrect page");
    setValue('Modality1CaseManagement', data.SvcCaseManagement);
    setValue('Modality2DayTreatment', data.SvcDayTreatment);
    setValue('Modality3InpatientHospital', data.SvcInpatient);
    setValue('Modality4Outpatient', data.SvcOutpatient);
    setValue('Modality5Outreach', data.SvcOutreach);
    setValue('Modality6IntensiveOutpatient', data.SvcIntensiveOutpatient);
    setValue('Modality7Methadone', data.SvcMethadone);
    setValue('Modality8ResidentialRehabilitation', data.SvcResidentialRehab);
    setValue('ModalityDetoxification9AHospital', data.SvcHospitalInpatient);
    setValue('ModalityDetoxification9BFree', data.SvcFreeStandingRes);
    setValue('ModalityDetoxification9CAmbulatory', data.SvcAmbulatoryDetox);
    setValue('Modality10AfterCare', data.SvcAfterCare);
    setValue('Modality11RecoverySupport', data.SvcRecoverySupport);
    setValue('Modality12Other', data.SvcOtherModalities);
    setValue('Modality12OtherSpec', data.SvcOtherModalitesSpec);
    clickButton('ToolBar_Next');
    setTimeout(inputPage4, 1000, data);
}

function inputPage4(data) {
    console.log("page 4");
    assert(spars.$('#Treatment1Screening').length === 0, "Incorrect page");
    setValue('Treatment1Screening', data.SvcScreening);
    setValue('Treatment2BriefIntervention', data.SvcBriefIntervention);
    setValue('Treatment3BriefTreatment', data.SvcBriefTreatment);
    setValue('Treatment4ReferralToTreatment', data.SvcReferralTreatment);
    setValue('Treatment5Assessment', data.SvcAssessment);
    setValue('Treatment6RecoveryPlanning', data.SvcTreatmentPlanning);
    setValue('Treatment7IndividualCounseling', data.SvcIndividualCouns);
    setValue('Treatment8GroupCounseling', data.SvcGroupCouns);
    setValue('Treatment9FamilyCounseling', data.SvcFamilyMarriageCouns);
    setValue('Treatment10CoOccurringTreatment', data.SvcCoOccurring);
    setValue('Treatment11PharmacologicalInterventions', data.SvcPharmacological);
    setValue('Treatment12AIDSCounseling', data.SvcHIVAIDSCouns);
    setValue('Treatment13Other', data.SvcOtherClinicalCouns);
    setValue('Treatment13OtherSpec', data.SvcOtherClinicalCounsSpec);
    clickButton('ToolBar_Next');
    setTimeout(inputPage5, 1000, data);
}

function inputPage5(data) {
    console.log("page 5");
    assert(spars.$('#CaseManagement1FamilyServices').length === 0, "Incorrect page");
    setValue('CaseManagement1FamilyServices', data.SvcFamilyServices);
    setValue('CaseManagement2ChildCare', data.SvcChildCare);
    setValue('CaseManagement3APreEmployment', data.SvcPreEmployment);
    setValue('CaseManagement3BEmploymentCoaching', data.SvcEmploymentCoaching);
    setValue('CaseManagement4IndividualCoordination', data.SvcIndividualCoord);
    setValue('CaseManagement5Transportation', data.SvcTransportation);
    setValue('CaseManagement6AIDSService', data.SvcHIVAIDSServices);
    setValue('CaseManagement7SupportiveTransitional', data.SvcDrugFreeHousing);
    setValue('CaseManagement8Other', data.SvcOtherCaseMgmt);
    setValue('CaseManagement8OtherSpec', data.SvcOtherCaseMgmtSpec);
    setValue('Medical1Care', data.SvcMedicalCare);
    setValue('Medical2AlcoholDrugTesting', data.SvcAlcoholDrugTesting);
    setValue('Medical3AIDSMedicalSupport', data.SvcHIVAIDSMedical);
    setValue('Medical4Other', data.SvcOtherMedical);
    setValue('Medical4OtherSpec', data.SvcOtherMedicalSpec);
    setValue('AfterCare1ContinuingCare', data.SvcContinuingCare);
    setValue('AfterCare2RelapsePrevention', data.SvcRelapsePrevention);
    setValue('AfterCare3RecoveryCoaching', data.SvcRecoveryCoaching);
    setValue('AfterCare4SelfHelp', data.SvcSelfHelpSupport);
    setValue('AfterCare5SpiritualSupport', data.SvcSpiritualSupport);
    setValue('AfterCare6Other', data.SvcOtherAfterCare);
    setValue('AfterCare6OtherSpec', data.SvcOtherAfterCareSpec);
    clickButton('ToolBar_Next');
    setTimeout(inputPage6, 1000, data);
}

function inputPage6(data) {
    console.log("page 6");
    assert(spars.$('#Education1SubstanceAbuse').length === 0, "Incorrect page");
    setValue('Education1SubstanceAbuse', data.SvcSubstanceAbuseEdu);
    setValue('Education2AIDSEducation', data.SvcHIVAIDSEdu);
    setValue('Education3Other', data.SvcOtherEdu);
    setValue('Education3OtherSpec', data.SvcOtherEduSpec);
    setValue('PeerToPeer1Coaching', data.SvcPeerCoaching);
    setValue('PeerToPeer2HousingSupport', data.SvcHousingSupport);
    setValue('PeerToPeer3DrugFreeActivities', data.SvcDrugFreeSocial);
    setValue('PeerToPeer4InformationAndReferral', data.SvcInformationReferral);
    setValue('PeerToPeer5Other', data.SvcOtherRecovery);
    setValue('PeerToPeer5OtherSpec', data.SvcOtherRecoverySpec);
    clickButton('ToolBar_Next');
    setTimeout(inputPage7, 1000, data);
}

function inputPage7(data) {
    console.log("page 7");
    assert(spars.$('#ClientIntake_IsHispanicLatino').length === 0, "Incorrect page");
    setValue('ClientIntake_IsHispanicLatino', data.HispanicLatino, MV);
    setValue('ClientIntake_HispanicLatino_CentralAmerican', data.EthnicCentralAmerican);
    setValue('ClientIntake_HispanicLatino_Cuban', data.EthnicCuban);
    setValue('ClientIntake_HispanicLatino_Dominican', data.EthnicDominican);
    setValue('ClientIntake_HispanicLatino_Mexican', data.EthnicMexican);
    setValue('ClientIntake_HispanicLatino_PuertoRican', data.EthnicPuertoRican);
    setValue('ClientIntake_HispanicLatino_SouthAmerican', data.EthnicSouthAmerican);
    setValue('ClientIntake_HispanicLatino_Other', data.EthnicOther);
    setValue('ClientIntake_HispanicLatino_OtherSpec', data.EthnicOtherSpec);
    setValue('ClientIntake_Race_Black', data.RaceBlack);
    setValue('ClientIntake_Race_Asian', data.RaceAsian);
    setValue('ClientIntake_Race_NativeHawaiian', data.RaceNativeHawaiian);
    setValue('ClientIntake_Race_AlaskaNative', data.RaceAlaskaNative);
    setValue('ClientIntake_Race_White', data.RaceWhite);
    setValue('ClientIntake_Race_AmericanIndian', data.RaceAmericanIndian);
    setValue('DemoBirthDate_BirthMonthTextBox', Math.ceil(Math.random()*12));
    setValue('DemoBirthDate_BirthYearTextBox', data.BirthYear);

    //this causes page to reload, so wait
    setValue('ClientIntake_GenderCode', data.GenderCode, MV);
    setTimeout(function() {
        setValue('ClientIntake_GenderOtherSpecify', data.GenderOtherSpecify);
        clickButton('ToolBar_Next');
        setTimeout(inputPage8, 1000, data);
    }, 1000, data);
}

function inputPage8(data) {
    console.log("page 8");
    assert(spars.$('#ClientIntake_MilitaryServed').length === 0, "Incorrect page");
    setValue('ClientIntake_MilitaryServed', data.MilitaryServed, MV);
    if(data.MilitaryServed > 0) {
        setValue('ClientIntake_ActiveDuty', data.ActiveDuty, MV);

        setValue('ClientIntake_NeverDeployed', 0); //have to set it to No first to set all other inputs to No
        if (data.IraqAfghanistan == 0 && data.PersianGulf == 0 && data.VietnamSoutheastAsia == 0 && data.Korea == 0
            && data.WWII == 0 && data.DeployedCombatZone == 0) {
            setValue('ClientIntake_NeverDeployed', 1);
        }
        else { //can't set any to No or it resets everything for some reason
            if (data.IraqAfghanistan == 1)
                setValue('ClientIntake_IraqAfghanistan', data.IraqAfghanistan);
            if (data.PersianGulf == 1)
                setValue('ClientIntake_PersianGulf', data.PersianGulf);
            if (data.VietnamSoutheastAsia == 1)
                setValue('ClientIntake_VietnamSoutheastAsia', data.VietnamSoutheastAsia);
            if (data.Korea == 1)
                setValue('ClientIntake_Korea', data.Korea);
            if (data.WWII == 1)
                setValue('ClientIntake_WWII', data.WWII);
            if (data.DeployedCombatZone == 1)
                setValue('ClientIntake_DeployedCombatZone', data.DeployedCombatZone);
        }
    }

    setValue('ClientIntake_FamilyActiveDuty', data.FamilyActiveDuty, MV);
    let maxPeople = 0;
    let minPeople = 0;
    if(data.FamilyActiveDuty == 1) {
        maxPeople = 1;
        minPeople = 1;
    }
    else if(data.FamilyActiveDuty == 2) {
        maxPeople = 6;
        minPeople = 2;
    }
    let sparsSlot = 0;
    //for each valid person entered in GPRA platform (i.e. has a relationship value), enter it into SPARS until maxPeople is reached
    for(let mySlot = 1; mySlot <= 6; mySlot++) {
        if(sparsSlot >= maxPeople)
            break;
        if(data['ServiceMemRelationship'+mySlot]) {
            setValue('ClientIntake_SerMemRelationship'+sparsSlot+'_ServiceMemRelationship', data['ServiceMemRelationship'+mySlot]);
            setValue('ClientIntake_SerMemRelationship'+sparsSlot+'_ServiceMemExpOther', data['ServiceMemExpOther'+mySlot]);
            setValue('ClientIntake_SerMemRelationship'+sparsSlot+'_ServiceMemExpDeployed', data['ServiceMemExpDeployed'+mySlot]);
            setValue('ClientIntake_SerMemRelationship'+sparsSlot+'_ServiceMemExpInjured', data['ServiceMemExpInjured'+mySlot]);
            setValue('ClientIntake_SerMemRelationship'+sparsSlot+'_ServiceMemExpCombatStress', data['ServiceMemExpCombatStress'+mySlot]);
            setValue('ClientIntake_SerMemRelationship'+sparsSlot+'_ServiceMemExpDeceased', data['ServiceMemExpDeceased'+mySlot]);
            sparsSlot++;
        }
    }

    //then if too few people were entered into SPARS, enter missing data
    while(sparsSlot < minPeople) {
        setValue('ClientIntake_SerMemRelationship'+sparsSlot+'_ServiceMemRelationship', -9);
        setValue('ClientIntake_SerMemRelationship'+sparsSlot+'_ServiceMemExpDeployed', -9);
        setValue('ClientIntake_SerMemRelationship'+sparsSlot+'_ServiceMemExpInjured', -9);
        setValue('ClientIntake_SerMemRelationship'+sparsSlot+'_ServiceMemExpCombatStress', -9);
        setValue('ClientIntake_SerMemRelationship'+sparsSlot+'_ServiceMemExpDeceased', -9);
        sparsSlot++;
    }

    clickButton('ToolBar_Next');
    setTimeout(inputPage9, 1000, data);
}

function setCombo(inputID, value, missingValue = null, triggerChange = true) {
    if((value == null || value === "") && missingValue != null) {
        value = missingValue;
    }
    let field = (value >= 0) ? '__textbox__'+inputID : '__dropdown__'+inputID;

    if (triggerChange)
        spars.$('#' + field).val(value).trigger('change');
    else
        spars.$('#' + field).val(value);
}

function inputPage9(data) {
    console.log("page 9");
    assert(spars.$('#DAUseAlcoholIntox5Days').length === 0, "Incorrect page");
    if(data.DAUseRefused == 1) {
        setCombo('DAUseAlcoholIntox5Days', RF);
        setCombo('DAUseAlcoholIntox4Days', RF);
        setCombo('DAUseBothDays', RF);
        setCombo('DAUseAlcoholDays', RF);
        setCombo('DAUseIllegDrugsDays', RF);
    }
    else {
        setCombo('DAUseAlcoholIntox5Days', data.DAUseAlcoholIntox5Days, 0);
        setCombo('DAUseAlcoholIntox4Days', data.DAUseAlcoholIntox4Days, 0);
        let both = Math.max(parseInt(data.DAUseBothDays), parseInt(data.DAUseAlcoholDays) + parseInt(data.DAUseIllegDrugsDays) - 30);
        setCombo('DAUseBothDays', both, 0);
        setCombo('DAUseAlcoholDays', data.DAUseAlcoholDays, 0);
        setCombo('DAUseIllegDrugsDays', data.DAUseIllegDrugsDays, 0);
    }
    clickButton('ToolBar_Next');
    setTimeout(inputPage10, 1000, data);
}

function setDrugUse(daysID, routeID, daysValue, routeValue) {
    setCombo(daysID, daysValue, MV);
    setValue(routeID, routeValue, MV);
}

function inputPage10(data) {
    console.log("page 10");
    assert(spars.$('#CocaineCrackDays').length === 0, "Incorrect page");
    if(data.DAUseIllegDrugsDays > 0 || data.DAUseRefused == 1) { //if drug days on last page is 0, you can skip this section
        if (data.DrugDaysRefused == 1) {
            setCombo('CocaineCrackDays', RF);
            setCombo('MarijuanaHashDays', RF);
            setCombo('OpiatesHeroinDays', RF);
            setCombo('OpiatesMorphineDays', RF);
            setCombo('OpiatesDiluadidDays', RF);
            setCombo('OpiatesDemerolDays', RF);
            setCombo('OpiatesPercocetDays', RF);
            setCombo('OpiatesDarvonDays', RF);
            setCombo('OpiatesCodeineDays', RF);
            setCombo('OpiatesTylenolDays', RF);
            setCombo('OpiatesOxycoDays', RF);
        } else {
            setDrugUse('CocaineCrackDays', 'CocaineCrackRoute', data.CocaineCrackDays, data.CocaineCrackRoute);
            setDrugUse('MarijuanaHashDays', 'MarijuanaHashRoute', data.MarijuanaHashDays, data.MarijuanaHashRoute);
            setDrugUse('OpiatesHeroinDays', 'OpiatesHeroinRoute', data.OpiatesHeroinDays, data.OpiatesHeroinRoute);
            setDrugUse('OpiatesMorphineDays', 'OpiatesMorphineRoute', data.OpiatesMorphineDays, data.OpiatesMorphineRoute);
            setDrugUse('OpiatesDiluadidDays', 'OpiatesDiluadidRoute', data.OpiatesDiluadidDays, data.OpiatesDiluadidRoute);
            setDrugUse('OpiatesDemerolDays', 'OpiatesDemerolRoute', data.OpiatesDemerolDays, data.OpiatesDemerolRoute);
            setDrugUse('OpiatesPercocetDays', 'OpiatesPercocetRoute', data.OpiatesPercocetDays, data.OpiatesPercocetRoute);
            setDrugUse('OpiatesDarvonDays', 'OpiatesDarvonRoute', data.OpiatesDarvonDays, data.OpiatesDarvonRoute);
            setDrugUse('OpiatesCodeineDays', 'OpiatesCodeineRoute', data.OpiatesCodeineDays, data.OpiatesCodeineRoute);
            setDrugUse('OpiatesTylenolDays', 'OpiatesTylenolRoute', data.OpiatesTylenolDays, data.OpiatesTylenolRoute);
            setDrugUse('OpiatesOxycoDays', 'OpiatesOxycoRoute', data.OpiatesOxycoDays, data.OpiatesOxycoRoute);
        }
    }
    clickButton('ToolBar_Next');
    setTimeout(inputPage11, 1000, data);
}

function inputPage11(data) {
    console.log("page 11");
    assert(spars.$('#NonPresMethadoneDays').length === 0, "Incorrect page");
    if(data.DAUseIllegDrugsDays > 0 || data.DAUseRefused == 1) { //if drug days on last page is 0, you can skip this section
        if (data.DrugDaysRefused == 1) {
            setCombo('NonPresMethadoneDays', RF);
            setCombo('HallucPsychDays', RF);
            setCombo('MethamDays', RF);
            setCombo('BenzodiazepinesDays', RF);
            setCombo('BarbituatesDays', RF);
            setCombo('NonPrescGhbDays', RF);
            setCombo('KetamineDays', RF);
            setCombo('OtherTranquilizersDays', RF);
            setCombo('InhalantsDays', RF);
            setCombo('OtherIllegalDrugsDays', RF);
        } else {
            setDrugUse('NonPresMethadoneDays', 'NonPresMethadoneRoute', data.NonPresMethadoneDays, data.NonPresMethadoneRoute);
            setDrugUse('HallucPsychDays', 'HallucPsychRoute', data.HallucPsychDays, data.HallucPsychRoute);
            setDrugUse('MethamDays', 'MethamRoute', data.MethamDays, data.MethamRoute);
            setDrugUse('BenzodiazepinesDays', 'BenzodiazepinesRoute', data.BenzodiazepinesDays, data.BenzodiazepinesRoute);
            setDrugUse('BarbituatesDays', 'BarbituatesRoute', data.BarbituatesDays, data.BarbituatesRoute);
            setDrugUse('NonPrescGhbDays', 'NonPrescGhbRoute', data.NonPrescGhbDays, data.NonPrescGhbRoute);
            setDrugUse('KetamineDays', 'KetamineRoute', data.KetamineDays, data.KetamineRoute);
            setDrugUse('OtherTranquilizersDays', 'OtherTranquilizersRoute', data.OtherTranquilizersDays, data.OtherTranquilizersRoute);
            setDrugUse('InhalantsDays', 'InhalantsRoute', data.InhalantsDays, data.InhalantsRoute);
            setDrugUse('OtherIllegalDrugsDays', 'OtherIllegalDrugsRoute', data.OtherIllegalDrugsDays, data.OtherIllegalDrugsRoute);
        }
        setValue('OtherIllegalDrugsSpec', data.OtherIllegalDrugsSpec);
    }
    setValue('InjectedDrugs', data.InjectedDrugs, MV);
    setValue('ParaphenaliaUsedOthers', data.ParaphenaliaUsedOthers, MV);

    clickButton('ToolBar_Next');
    setTimeout(inputPage12, 1000, data);
}

function inputPage12(data) {
    console.log("page 12");
    assert(spars.$('#LivingWhere').length === 0, "Incorrect page");
    setValue('LivingWhere', data.LivingWhere, MV);
    setTimeout(function() {
        setValue('LivingHoused', data.LivingHoused, MV);
        setValue('LivingHousedSpec', data.LivingHousedSpec);
        setValue('LivingConditionsSatisfaction', data.LivingConditionsSatisfaction, MV);
        setValue('ImpactStress', data.ImpactStress, MV);
        setValue('ImpactActivity', data.ImpactActivity, MV);
        setValue('ImpactEmotional', data.ImpactEmotional, MV);
        setValue('Pregnant', data.Pregnant, MV);
        setValue('Children', data.Children, MV);
        if(data.Children == 1) {
            setCombo('ChildrenNr', data.ChildrenNr, MV);
            setValue('ChildrenCustody', data.ChildrenCustody, MV);
            setCombo('ChildrenCustodyNr', data.ChildrenCustodyNr, MV);
            setCombo('ChildrenCustodyLost', data.ChildrenCustodyLost, MV);
        }
        clickButton('ToolBar_Next');
        setTimeout(inputPage13, 1000, data);
    }, 1000, data);
}

function inputPage13(data) {
    console.log("page 13");
    assert(spars.$('#TrainingProgram').length === 0, "Incorrect page");
    setValue('TrainingProgram', data.TrainingProgram, MV);
    setValue('TrainingProgramSpec', data.TrainingProgramSpec);
    setValue('EducationYears', data.EducationYears, MV);
    setValue('EmployStatus', data.EmployStatus, MV);
    setValue('EmployStatusSpec', data.EmployStatusSpec);
    if(data.IncomeRefused == 1) {
        setCombo('IncomeWages', RF);
        setCombo('IncomePubAssist', RF);
        setCombo('IncomeRetirement', RF);
        setCombo('IncomeDisability', RF);
        setCombo('IncomeNonLegal', RF);
        setCombo('IncomeFamFriends', RF);
        setCombo('IncomeOther', RF);
    }
    else {
        setCombo('IncomeWages', data.IncomeWages, 0);
        setCombo('IncomePubAssist', data.IncomePubAssist, 0);
        setCombo('IncomeRetirement', data.IncomeRetirement, 0);
        setCombo('IncomeDisability', data.IncomeDisability, 0);
        setCombo('IncomeNonLegal', data.IncomeNonLegal, 0);
        setCombo('IncomeFamFriends', data.IncomeFamFriends, 0);
        setCombo('IncomeOther', data.IncomeOther, 0);
        setValue('IncomeOtherSpec', data.IncomeOtherSpec);
    }
    setValue('EnoughMoneyForNeeds', data.EnoughMoneyForNeeds, MV);
    clickButton('ToolBar_Next');
    setTimeout(inputPage14, 1000, data);
}

function inputPage14(data) {
    console.log("page 14");
    assert(spars.$('#ArrestedDays').length === 0, "Incorrect page");
    if(data.CrimeRefused == 1) {
        setCombo('ArrestedDays', RF);
        setCombo('ArrestedDrugDays', RF);
        setCombo('ArrestedConfineDays', RF);
        setCombo('NrCrimes', RF);
    }
    else {
        setCombo('ArrestedDays', data.ArrestedDays, 0);
        setCombo('ArrestedDrugDays', data.ArrestedDrugDays, 0);
        setCombo('ArrestedConfineDays', data.ArrestedConfineDays, 0);
        if(data.NrCrimes === "") //can't parseInt a blank
            data.NrCrimes = "0";
        if(parseInt(data.DAUseIllegDrugsDays) > parseInt(data.NrCrimes))
            data.NrCrimes = data.DAUseIllegDrugsDays;
        setCombo('NrCrimes', data.NrCrimes, 0);
    }
    setValue('AwaitTrial', data.AwaitTrial, MV);
    setValue('ParoleProbation', data.ParoleProbation, MV);
    clickButton('ToolBar_Next');
    setTimeout(inputPage15, 1000, data);
}

//our system only has text box for number
//it can only be 0 or a positive number
function setTreatmentValue(dropdownID, textID, times) {
    if(times == 0) {
        setValue(dropdownID, 0);
    }
    else {
        setValue(dropdownID, 1);
        setCombo(textID, times);
    }
}

function inputPage15(data) {
    console.log("page 15");
    assert(spars.$('#HealthStatus').length === 0, "Incorrect page");
    setValue('HealthStatus', data.HealthStatus, MV);

    if(data.TreatmentRefused == 1) {
        setValue('InpatientPhysical', RF);
        setValue('InpatientMental', RF);
        setValue('InpatientAlcoholSA', RF);
        setValue('OutpatientPhysical', RF);
        setValue('OutpatientMental', RF);
        setValue('OutpatientAlcoholSA', RF);
        setValue('ERPhysical', RF);
        setValue('ERMental', RF);
        setValue('ERAlcoholSA', RF);
    }
    else {
        setTreatmentValue('InpatientPhysical','InpatientPhysicalNights',data.InpatientPhysicalNights);
        setTreatmentValue('InpatientMental','InpatientMentalNights',data.InpatientMentalNights);
        setTreatmentValue('InpatientAlcoholSA','InpatientAlcoholSANights',data.InpatientAlcoholSANights);
        setTreatmentValue('OutpatientPhysical','OutpatientPhysicalTimes',data.OutpatientPhysicalTimes);
        setTreatmentValue('OutpatientMental','OutpatientMentalTimes',data.OutpatientMentalTimes);
        setTreatmentValue('OutpatientAlcoholSA','OutpatientAlcoholSATimes',data.OutpatientAlcoholSATimes);
        setTreatmentValue('ERPhysical','ERPhysicalTimes',data.ERPhysicalTimes);
        setTreatmentValue('ERMental','ERMentalTimes',data.ERMentalTimes);
        setTreatmentValue('ERAlcoholSA','ERAlcoholSATimes',data.ERAlcoholSATimes);
    }
    clickButton('ToolBar_Next');
    setTimeout(inputPage16, 1000, data);
}

function inputPage16(data) {
    console.log("page 16");
    assert(spars.$('#SexActivity').length === 0, "Incorrect page");
    setValue('SexActivity', data.SexActivity, MV); //this refreshes the page
    setTimeout(function() {
        if (data.SexActivity == 1) {
            setCombo('SexContacts', data.SexContacts, 0);
            setCombo('SexUnprot', data.SexUnprot, 0);
            setCombo('SexUnprotHIVAids', data.SexUnprotHIVAids, 0);
            setCombo('SexUnprotInjDrugUser', data.SexUnprotInjDrugUser, 0);
            setCombo('SexUnprotHigh', data.SexUnprotHigh, 0);
        }
        setValue('HIVTest', data.fHIVTest, MV);
        if(data.fHIVTestResult == -8)
            data.fHIVTestResult = -9;
        setValue('HIVTestResult', data.fHIVTestResult, MV);
        clickButton('ToolBar_Next');
        setTimeout(inputPage17, 1000, data);
    }, 1000, data);
}

function inputPage17(data) {
    console.log("page 17");
    assert(spars.$('#LifeQuality').length === 0, "Incorrect page");
    setValue('LifeQuality', data.LifeQuality, MV);
    setValue('HealthSatisfaction', data.HealthSatisfaction, MV);
    setValue('EnoughEnergyForEverydayLife', data.EnoughEnergyForEverydayLife, MV);
    setValue('PerformDailyActivitiesSatisfaction', data.PerformDailyActivitiesSatisfaction, MV);
    setValue('SelfSatisfaction', data.SelfSatisfaction, MV);
    clickButton('ToolBar_Next');
    setTimeout(inputPage18, 1000, data);
}

function inputPage18(data) {
    console.log("page 18");
    assert(spars.$('#Depression').length === 0, "Incorrect page");
    if(data.TreatmentRefused == 1) {
        setCombo('Depression', RF);
        setCombo('Anxiety', RF);
        setCombo('Hallucinations', RF);
        setCombo('BrainFunction', RF);
        setCombo('ViolentBehavior', RF);
        setCombo('Suicide', RF);
        setCombo('PsycholEmotMedication', RF);
    }
    else {
        setCombo('Depression', data.Depression, MV);
        setCombo('Anxiety', data.Anxiety, MV);
        setCombo('Hallucinations', data.Hallucinations, MV);
        setCombo('BrainFunction', data.BrainFunction, MV);
        setCombo('ViolentBehavior', data.ViolentBehavior, MV);
        setCombo('Suicide', data.Suicide, MV);
        setCombo('PsycholEmotMedication', data.PsycholEmotMedication, MV);
    }
    setValue('PsycholEmotImpact', data.PsycholEmotImpact, MV);
    clickButton('ToolBar_Next');
    setTimeout(inputPage19, 1000, data);
}

function inputPage19(data) {
    console.log("page 19");
    assert(spars.$('#AnyViolence').length === 0, "Incorrect page");
    setValue('AnyViolence', data.AnyViolence, MV);
    setValue('Nightmares', data.Nightmares, MV);
    setValue('TriedHard', data.TriedHard, MV);
    setValue('ConstantGuard', data.ConstantGuard, MV);
    setValue('NumbandDetach', data.NumbAndDetach, MV);
    setValue('PhysicallyHurt', data.PhysicallyHurt, MV);
    clickButton('ToolBar_Next');
    setTimeout(inputPage20, 1000, data);
}

function inputPage20(data) {
    console.log("page 20");
    assert(spars.$('#AttendVoluntary').length === 0, "Incorrect page");
    setTreatmentValue('AttendVoluntary','AttendVoluntaryTimes',data.AttendVoluntaryTimes);
    setTreatmentValue('AttendReligious','AttendReligiousTimes',data.AttendReligiousTimes);
    setTreatmentValue('AttendOtherOrg','AttendOtherOrgTimes',data.AttendOtherOrgTimes);
    setValue('InteractFamilyFriends', data.InteractFamilyFriends, MV);
    setValue('WhomInTrouble', data.WhomInTrouble, MV);
    setValue('WhomInTroubleSpec', data.WhomInTroubleSpec);
    setValue('RelationshipSatisfaction', data.RelationshipSatisfaction, MV);
    clickButton('ToolBar_Next');
    if(data.gpra_type === 1)
        setTimeout(inputPage21, 1000, data);
    else if(data.gpra_type === 2)
        setTimeout(dischargeSectionJ, 1000, data);
    else if(data.gpra_type === 3 || data.gpra_type === 4)
        setTimeout(followupSectionI, 1000, data);
}

function dischargeSectionJ(data) {
    console.log("Discharge Section J");
    assert(spars.$('#DischargeDate').length === 0, "Incorrect page");
    setValue('DischargeDate', data.DischargeDate, null, true);
    setValue('DischargeStatusCompl', data.DischargeStatusCompl);
    if(data.DischargeStatusCompl === "2") {
        if(data.DischargeStatusTermReason.length === 1)
            data.DischargeStatusTermReason = "0"+data.DischargeStatusTermReason;
        setValue('DischargeStatusTermReason', data.DischargeStatusTermReason);
        if(data.DischargeStatusTermReason === "13") {
            setValue('OtherDischargeStatTermRsnSpec', data.OtherDischargeStatTermRsnSpec);
        }
    }
    setValue('HIVTest', data.jHIVTest, MV);
    if(data.jHIVTest === "0") {
        setValue('HIVTestResult', data.jHIVTestResult, MV);
    }
    clickButton('ToolBar_Next');
    setTimeout(servicesReceivedPage1, 1000, data);
}

function servicesReceivedPage1(data) {
    console.log("Services Received Page 1");
    assert(spars.$('#Modality1CaseManagement').length === 0, "Incorrect page");
    setValue('Modality1CaseManagement', data.SvcCaseManagementDis);
    setValue('Modality2DayTreatment', data.SvcDayTreatmentDis);
    setValue('Modality3InpatientHospital', data.SvcInpatientDis);
    setValue('Modality4Outpatient', data.SvcOutpatientDis);
    setValue('Modality5Outreach', data.SvcOutreachDis);
    setValue('Modality6IntensiveOutpatient', data.SvcIntensiveOutpatientDis);
    setValue('Modality7Methadone', data.SvcMethadoneDis);
    setValue('Modality8ResidentialRehabilitation', data.SvcResidentialRehabDis);
    setValue('ModalityDetoxification9AHospital', data.SvcHospitalInpatientDis);
    setValue('ModalityDetoxification9BFree', data.SvcFreeStandingResDis);
    setValue('ModalityDetoxification9CAmbulatory', data.SvcAmbulatoryDetoxDis);
    setValue('Modality10AfterCare', data.SvcAfterCareDis);
    setValue('Modality11RecoverySupport', data.SvcRecoverySupportDis);
    setValue('Modality12Other', data.SvcOtherModalitiesDis);
    setValue('Modality12OtherSpec', data.SvcOtherModalitesSpecDis);
    clickButton('ToolBar_Next');
    setTimeout(servicesReceivedPage2, 1000, data);
}

function servicesReceivedPage2(data) {
    console.log("Services Received Page 2");
    assert(spars.$('#Treatment1Screening').length === 0, "Incorrect page");
    setValue('Treatment1Screening', data.SvcScreeningDis);
    setValue('Treatment2BriefIntervention', data.SvcBriefInterventionDis);
    setValue('Treatment3BriefTreatment', data.SvcBriefTreatmentDis);
    setValue('Treatment4ReferralToTreatment', data.SvcReferralTreatmentDis);
    setValue('Treatment5Assessment', data.SvcAssessmentDis);
    setValue('Treatment6RecoveryPlanning', data.SvcTreatmentPlanningDis);
    setValue('Treatment7IndividualCounseling', data.SvcIndividualCounsDis);
    setValue('Treatment8GroupCounseling', data.SvcGroupCounsDis);
    setValue('Treatment9FamilyCounseling', data.SvcFamilyMarriageCounsDis);
    setValue('Treatment10CoOccurringTreatment', data.SvcCoOccurringDis);
    setValue('Treatment11PharmacologicalInterventions', data.SvcPharmacologicalDis);
    setValue('Treatment12AIDSCounseling', data.SvcHIVAIDSCounsDis);
    setValue('Treatment13Other', data.SvcOtherClinicalCounsDis);
    setValue('Treatment13OtherSpec', data.SvcOtherClinicalCounsSpecDis);
    clickButton('ToolBar_Next');
    setTimeout(servicesReceivedPage3, 1000, data);
}

function servicesReceivedPage3(data) {
    console.log("Services Received Page 3");
    assert(spars.$('#CaseManagement1FamilyServices').length === 0, "Incorrect page");
    setValue('CaseManagement1FamilyServices', data.SvcFamilyServicesDis);
    setValue('CaseManagement2ChildCare', data.SvcChildCareDis);
    setValue('CaseManagement3APreEmployment', data.SvcPreEmploymentDis);
    setValue('CaseManagement3BEmploymentCoaching', data.SvcEmploymentCoachingDis);
    setValue('CaseManagement4IndividualCoordination', data.SvcIndividualCoordDis);
    setValue('CaseManagement5Transportation', data.SvcTransportationDis);
    setValue('CaseManagement6AIDSService', data.SvcHIVAIDSServicesDis);
    setValue('CaseManagement7SupportiveTransitional', data.SvcDrugFreeHousingDis);
    setValue('CaseManagement8Other', data.SvcOtherCaseMgmtDis);
    setValue('CaseManagement8OtherSpec', data.SvcOtherCaseMgmtSpecDis);
    setValue('Medical1Care', data.SvcMedicalCareDis);
    setValue('Medical2AlcoholDrugTesting', data.SvcAlcoholDrugTestingDis);
    setValue('Medical3AIDSMedicalSupport', data.SvcHIVAIDSMedicalDis);
    setValue('Medical4Other', data.SvcOtherMedicalDis);
    setValue('Medical4OtherSpec', data.SvcOtherMedicalSpecDis);
    setValue('AfterCare1ContinuingCare', data.SvcContinuingCareDis);
    setValue('AfterCare2RelapsePrevention', data.SvcRelapsePreventionDis);
    setValue('AfterCare3RecoveryCoaching', data.SvcRecoveryCoachingDis);
    setValue('AfterCare4SelfHelp', data.SvcSelfHelpSupportDis);
    setValue('AfterCare5SpiritualSupport', data.SvcSpiritualSupportDis);
    setValue('AfterCare6Other', data.SvcOtherAfterCareDis);
    setValue('AfterCare6OtherSpec', data.SvcOtherAfterCareSpecDis);
    clickButton('ToolBar_Next');
    setTimeout(servicesReceivedPage4, 1000, data);
}

function servicesReceivedPage4(data) {
    console.log("Services Received Page 4");
    assert(spars.$('#Education1SubstanceAbuse').length === 0, "Incorrect page");
    setValue('Education1SubstanceAbuse', data.SvcSubstanceAbuseEduDis);
    setValue('Education2AIDSEducation', data.SvcHIVAIDSEduDis);
    setValue('Education3Other', data.SvcOtherEduDis);
    setValue('Education3OtherSpec', data.SvcOtherEduSpecDis);
    setValue('PeerToPeer1Coaching', data.SvcPeerCoachingDis);
    setValue('PeerToPeer2HousingSupport', data.SvcHousingSupportDis);
    setValue('PeerToPeer3DrugFreeActivities', data.SvcDrugFreeSocialDis);
    setValue('PeerToPeer4InformationAndReferral', data.SvcInformationReferralDis);
    setValue('PeerToPeer5Other', data.SvcOtherRecoveryDis);
    setValue('PeerToPeer5OtherSpec', data.SvcOtherRecoverySpecDis);
    clickButton('ToolBar_Next');
    setTimeout(inputPage21, 1000, data);
}

function followupSectionI(data) {
    console.log("Followup Section I");
    assert(spars.$('#FollowUpStatusCode').length === 0, "Incorrect page");
    setValue('FollowUpStatusCode', data.FLWPStatus);
    if(data.FLWPStatus === "32") {
        setValue('FollowUpOtherSpecify', data.FLWPStatusSpec);
    }
    setValue('ReceivingServices', data.ReceivingServices);
    clickButton('ToolBar_Next');
    setTimeout(inputPage21, 1000, data);
}

function inputPage21(data) {
    console.log("page 21");
    assert(spars.$('#ToolBar_Finish').length === 0, "Incorrect page");
    clickButton('ToolBar_Finish');
    setTimeout(inputPage22, 1000, data);
}

function inputPage22(data) {
    console.log("page 22");
    assert(spars.$('#Back').length === 0, "Incorrect page");
    clickButton('Back');
    setTimeout(startNextGPRA, 1000);
}