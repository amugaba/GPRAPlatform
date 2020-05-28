/**
 * This file, when run locally on a web browser accessing SPARS, automates the entry CSAT GPRAs
 * 1. Go to GPRA Platform > Export and export new GPRAs to a JSON text file
 * 2. Navigate to the SPARS CSAT web page
 * 3. Open console or Scratchpad
 * 4. Open this script
 * 5. Paste the JSON into the beginning of the script to save it under gpras variable
 * 6. Run script
 */

gpras = [{"id":"3","client_uid":"6707665","gpra_type":1,"ClientType":"1","InterviewDate":"06/18/2019","ICD10CodeOne":"5","ICD10CodeOneCategory":"","ICD10CodeTwo":"","ICD10CodeTwoCategory":"","ICD10CodeThree":"","ICD10CodeThreeCategory":"","OpioidDisorder":"1","MethadoneMedication":"","MethadoneMedicationDays":"0","BuprenorphineMedication":"","BuprenorphineMedicationDays":"0","NaltrexoneMedication":"","NaltrexoneMedicationDays":"0","NaltrexoneXRMedication":"","NaltrexoneXRMedicationDays":"0","AlcoholDisorder":"0","NaltrexoneAlcMedication":"","NaltrexoneAlcMedicationDays":"","NaltrexoneXRAlcMedication":"","NaltrexoneXRAlcMedicationDays":"","DisulfiramMedication":"","DisulfiramMedicationDays":"","AcamprosateMedication":"","AcamprosateMedicationDays":"","ClientIntake_CooccurringScreen":"1","ClientIntake_CooccurringScreenStatus":"1","GenderCode":"2","GenderOtherSpecify":"","HispanicLatino":"1","EthnicCentralAmerican":"0","EthnicCuban":"0","EthnicDominican":"1","EthnicMexican":"0","EthnicPuertoRican":"0","EthnicSouthAmerican":"0","EthnicOther":"1","EthnicOtherSpec":"asdf","RaceBlack":"0","RaceAsian":"0","RaceAmericanIndian":"0","RaceNativeHawaiian":"0","RaceAlaskaNative":"1","RaceWhite":"0","BirthYear":"1950","BirthMonth":"","Age":"","AgeGroup":"","Veteran":"","MilitaryServed":"","ActiveDuty":"","NeverDeployed":"","IraqAfghanistan":"","PersianGulf":"","VietnamSoutheastAsia":"","Korea":"","WWII":"","DeployedCombatZone":"","FamilyActiveDuty":"","ServiceMemRelationship1":"","ServiceMemExpOther1":"","ServiceMemExpDeployed1":"","ServiceMemExpInjured1":"","ServiceMemExpCombatStress1":"","ServiceMemExpDeceased1":"","ServiceMemRelationship2":"","ServiceMemExpOther2":"","ServiceMemExpDeployed2":"","ServiceMemExpInjured2":"","ServiceMemExpCombatStress2":"","ServiceMemExpDeceased2":"","ServiceMemRelationship3":"","ServiceMemExpOther3":"","ServiceMemExpDeployed3":"","ServiceMemExpInjured3":"","ServiceMemExpCombatStress3":"","ServiceMemExpDeceased3":"","ServiceMemRelationship4":"","ServiceMemExpOther4":"","ServiceMemExpDeployed4":"","ServiceMemExpInjured4":"","ServiceMemExpCombatStress4":"","ServiceMemExpDeceased4":"","ServiceMemRelationship5":"","ServiceMemExpOther5":"","ServiceMemExpDeployed5":"","ServiceMemExpInjured5":"","ServiceMemExpCombatStress5":"","ServiceMemExpDeceased5":"","ServiceMemRelationship6":"","ServiceMemExpOther6":"","ServiceMemExpDeployed6":"","ServiceMemExpInjured6":"","ServiceMemExpCombatStress6":"","ServiceMemExpDeceased6":"","DAUseAlcoholDays":"0","DAUseAlcoholIntox5Days":"","DAUseAlcoholIntox4Days":"","DAUseIllegDrugsDays":"0","DAUseBothDays":"","CocaineCrackDays":"0","CocaineCrackRoute":"","MarijuanaHashDays":"0","MarijuanaHashRoute":"","OpiatesHeroinDays":"0","OpiatesHeroinRoute":"","OpiatesMorphineDays":"0","OpiatesMorphineRoute":"","OpiatesDiluadidDays":"0","OpiatesDiluadidRoute":"","OpiatesDemerolDays":"0","OpiatesDemerolRoute":"","OpiatesPercocetDays":"0","OpiatesPercocetRoute":"","OpiatesDarvonDays":"0","OpiatesDarvonRoute":"","OpiatesCodeineDays":"0","OpiatesCodeineRoute":"","OpiatesTylenolDays":"0","OpiatesTylenolRoute":"","OpiatesOxycoDays":"0","OpiatesOxycoRoute":"","NonPresMethadoneDays":"0","NonPresMethadoneRoute":"","HallucPsychDays":"0","HallucPsychRoute":"","MethamDays":"0","MethamRoute":"","BenzodiazepinesDays":"0","BenzodiazepinesRoute":"","BarbituatesDays":"0","BarbituatesRoute":"","NonPrescGhbDays":"0","NonPrescGhbRoute":"","KetamineDays":"0","KetamineRoute":"","OtherTranquilizersDays":"0","OtherTranquilizersRoute":"","InhalantsDays":"0","InhalantsRoute":"","OtherIllegalDrugsDays":"0","OtherIllegalDrugsRoute":"","OtherIllegalDrugsSpec":"","InjectedDrugs":"","ParaphenaliaUsedOthers":"","LivingWhere":"","LivingHoused":"","LivingHousedSpec":"","LivingConditionsSatisfaction":"","ImpactStress":"","ImpactActivity":"","ImpactEmotional":"","Pregnant":"","Children":"","ChildrenNr":"","ChildrenCustody":"","ChildrenCustodyNr":"","ChildrenCustodyLost":"","TrainingProgram":"4","TrainingProgramSpec":"asdf","EducationYears":"","EmployStatus":"","EmployStatusSpec":"","Employment":"","IncomeWages":"0","IncomePubAssist":"0","IncomeRetirement":"0","IncomeDisability":"0","IncomeNonLegal":"0","IncomeFamFriends":"0","IncomeOther":"0","IncomeOtherSpec":"","EnoughMoneyForNeeds":"","ArrestedDays":"1","ArrestedDrugDays":"1","ArrestedConfineDays":"1","NrCrimes":"1","AwaitTrial":"","ParoleProbation":"","HealthStatus":"","InpatientPhysical":"","InpatientPhysicalNights":"0","InpatientMental":"","InpatientMentalNights":"0","InpatientAlcoholSA":"","InpatientAlcoholSANights":"0","OutpatientPhysical":"","OutpatientPhysicalTimes":"0","OutpatientMental":"","OutpatientMentalTimes":"0","OutpatientAlcoholSA":"","OutpatientAlcoholSATimes":"0","ERPhysical":"","ERPhysicalTimes":"0","ERMental":"","ERMentalTimes":"0","ERAlcoholSA":"","ERAlcoholSATimes":"0","SexActivity":"","SexContacts":"","SexUnprot":"","SexUnprotHIVAids":"","SexUnprotInjDrugUser":"","SexUnprotHigh":"","fHIVTest":"","fHIVTestResult":"","LifeQuality":"","HealthSatisfaction":"","EnoughEnergyForEverydayLife":"","PerformDailyActivitiesSatisfaction":"","SelfSatisfaction":"","Depression":"0","Anxiety":"0","Hallucinations":"0","BrainFunction":"0","ViolentBehavior":"0","Suicide":"0","PsycholEmotMedication":"0","PsycholEmotImpact":"","AnyViolence":"1","Nightmares":"0","TriedHard":"0","ConstantGuard":"1","NumbAndDetach":"1","PhysicallyHurt":"1","AttendVoluntary":"","AttendVoluntaryTimes":"3","AttendReligious":"","AttendReligiousTimes":"1","AttendOtherOrg":"","AttendOtherOrgTimes":"2","InteractFamilyFriends":"1","WhomInTrouble":"1","WhomInTroubleSpec":"","RelationshipSatisfaction":"3","SvcCaseManagement":"0","SvcDayTreatment":"0","SvcInpatient":"0","SvcOutpatient":"0","SvcOutreach":"0","SvcIntensiveOutpatient":"0","SvcMethadone":"1","SvcResidentialRehab":"0","SvcHospitalInpatient":"0","SvcFreeStandingRes":"0","SvcAmbulatoryDetox":"1","SvcAfterCare":"0","SvcRecoverySupport":"0","SvcOtherModalities":"0","SvcOtherModalitesSpec":"","SvcScreening":"0","SvcBriefIntervention":"0","SvcBriefTreatment":"0","SvcReferralTreatment":"0","SvcAssessment":"0","SvcTreatmentPlanning":"0","SvcIndividualCouns":"0","SvcGroupCouns":"0","SvcFamilyMarriageCouns":"0","SvcCoOccurring":"0","SvcPharmacological":"0","SvcHIVAIDSCouns":"0","SvcOtherClinicalCouns":"0","SvcOtherClinicalCounsSpec":"","SvcFamilyServices":"0","SvcChildCare":"1","SvcPreEmployment":"0","SvcEmploymentCoaching":"0","SvcIndividualCoord":"0","SvcTransportation":"0","SvcHIVAIDSServices":"0","SvcDrugFreeHousing":"0","SvcOtherCaseMgmt":"0","SvcOtherCaseMgmtSpec":"","SvcMedicalCare":"0","SvcAlcoholDrugTesting":"0","SvcHIVAIDSMedical":"0","SvcOtherMedical":"0","SvcOtherMedicalSpec":"","SvcContinuingCare":"0","SvcRelapsePrevention":"0","SvcRecoveryCoaching":"0","SvcSelfHelpSupport":"0","SvcSpiritualSupport":"0","SvcOtherAfterCare":"0","SvcOtherAfterCareSpec":"","SvcSubstanceAbuseEdu":"0","SvcHIVAIDSEdu":"0","SvcOtherEdu":"0","SvcOtherEduSpec":"","SvcPeerCoaching":"0","SvcHousingSupport":"0","SvcDrugFreeSocial":"0","SvcInformationReferral":"0","SvcOtherRecovery":"0","SvcOtherRecoverySpec":"","DAUseRefused":"0","DrugDaysRefused":"1","IncomeRefused":"1","CrimeRefused":"1","TreatmentRefused":"0","MentalHealthRefused":"1"},{"id":"2","client_uid":"asdf","gpra_type":1,"ClientType":"1","InterviewDate":"06/06/2019","ICD10CodeOne":null,"ICD10CodeOneCategory":null,"ICD10CodeTwo":null,"ICD10CodeTwoCategory":null,"ICD10CodeThree":null,"ICD10CodeThreeCategory":null,"OpioidDisorder":null,"MethadoneMedication":null,"MethadoneMedicationDays":null,"BuprenorphineMedication":null,"BuprenorphineMedicationDays":null,"NaltrexoneMedication":null,"NaltrexoneMedicationDays":null,"NaltrexoneXRMedication":null,"NaltrexoneXRMedicationDays":null,"AlcoholDisorder":null,"NaltrexoneAlcMedication":null,"NaltrexoneAlcMedicationDays":null,"NaltrexoneXRAlcMedication":null,"NaltrexoneXRAlcMedicationDays":null,"DisulfiramMedication":null,"DisulfiramMedicationDays":null,"AcamprosateMedication":null,"AcamprosateMedicationDays":null,"ClientIntake_CooccurringScreen":null,"ClientIntake_CooccurringScreenStatus":null,"GenderCode":null,"GenderOtherSpecify":null,"HispanicLatino":null,"EthnicCentralAmerican":null,"EthnicCuban":null,"EthnicDominican":null,"EthnicMexican":null,"EthnicPuertoRican":null,"EthnicSouthAmerican":null,"EthnicOther":null,"EthnicOtherSpec":null,"RaceBlack":null,"RaceAsian":null,"RaceAmericanIndian":null,"RaceNativeHawaiian":null,"RaceAlaskaNative":null,"RaceWhite":null,"BirthYear":null,"BirthMonth":null,"Age":null,"AgeGroup":null,"Veteran":null,"MilitaryServed":null,"ActiveDuty":null,"NeverDeployed":null,"IraqAfghanistan":null,"PersianGulf":null,"VietnamSoutheastAsia":null,"Korea":null,"WWII":null,"DeployedCombatZone":null,"FamilyActiveDuty":null,"ServiceMemRelationship1":null,"ServiceMemExpOther1":null,"ServiceMemExpDeployed1":null,"ServiceMemExpInjured1":null,"ServiceMemExpCombatStress1":null,"ServiceMemExpDeceased1":null,"ServiceMemRelationship2":null,"ServiceMemExpOther2":null,"ServiceMemExpDeployed2":null,"ServiceMemExpInjured2":null,"ServiceMemExpCombatStress2":null,"ServiceMemExpDeceased2":null,"ServiceMemRelationship3":null,"ServiceMemExpOther3":null,"ServiceMemExpDeployed3":null,"ServiceMemExpInjured3":null,"ServiceMemExpCombatStress3":null,"ServiceMemExpDeceased3":null,"ServiceMemRelationship4":null,"ServiceMemExpOther4":null,"ServiceMemExpDeployed4":null,"ServiceMemExpInjured4":null,"ServiceMemExpCombatStress4":null,"ServiceMemExpDeceased4":null,"ServiceMemRelationship5":null,"ServiceMemExpOther5":null,"ServiceMemExpDeployed5":null,"ServiceMemExpInjured5":null,"ServiceMemExpCombatStress5":null,"ServiceMemExpDeceased5":null,"ServiceMemRelationship6":null,"ServiceMemExpOther6":null,"ServiceMemExpDeployed6":null,"ServiceMemExpInjured6":null,"ServiceMemExpCombatStress6":null,"ServiceMemExpDeceased6":null,"DAUseAlcoholDays":null,"DAUseAlcoholIntox5Days":null,"DAUseAlcoholIntox4Days":null,"DAUseIllegDrugsDays":null,"DAUseBothDays":null,"CocaineCrackDays":null,"CocaineCrackRoute":null,"MarijuanaHashDays":null,"MarijuanaHashRoute":null,"OpiatesHeroinDays":null,"OpiatesHeroinRoute":null,"OpiatesMorphineDays":null,"OpiatesMorphineRoute":null,"OpiatesDiluadidDays":null,"OpiatesDiluadidRoute":null,"OpiatesDemerolDays":null,"OpiatesDemerolRoute":null,"OpiatesPercocetDays":null,"OpiatesPercocetRoute":null,"OpiatesDarvonDays":null,"OpiatesDarvonRoute":null,"OpiatesCodeineDays":null,"OpiatesCodeineRoute":null,"OpiatesTylenolDays":null,"OpiatesTylenolRoute":null,"OpiatesOxycoDays":null,"OpiatesOxycoRoute":null,"NonPresMethadoneDays":null,"NonPresMethadoneRoute":null,"HallucPsychDays":null,"HallucPsychRoute":null,"MethamDays":null,"MethamRoute":null,"BenzodiazepinesDays":null,"BenzodiazepinesRoute":null,"BarbituatesDays":null,"BarbituatesRoute":null,"NonPrescGhbDays":null,"NonPrescGhbRoute":null,"KetamineDays":null,"KetamineRoute":null,"OtherTranquilizersDays":null,"OtherTranquilizersRoute":null,"InhalantsDays":null,"InhalantsRoute":null,"OtherIllegalDrugsDays":null,"OtherIllegalDrugsRoute":null,"OtherIllegalDrugsSpec":null,"InjectedDrugs":null,"ParaphenaliaUsedOthers":null,"LivingWhere":null,"LivingHoused":null,"LivingHousedSpec":null,"LivingConditionsSatisfaction":null,"ImpactStress":null,"ImpactActivity":null,"ImpactEmotional":null,"Pregnant":null,"Children":null,"ChildrenNr":null,"ChildrenCustody":null,"ChildrenCustodyNr":null,"ChildrenCustodyLost":null,"TrainingProgram":null,"TrainingProgramSpec":null,"EducationYears":null,"EmployStatus":null,"EmployStatusSpec":null,"Employment":null,"IncomeWages":null,"IncomePubAssist":null,"IncomeRetirement":null,"IncomeDisability":null,"IncomeNonLegal":null,"IncomeFamFriends":null,"IncomeOther":null,"IncomeOtherSpec":null,"EnoughMoneyForNeeds":null,"ArrestedDays":null,"ArrestedDrugDays":null,"ArrestedConfineDays":null,"NrCrimes":null,"AwaitTrial":null,"ParoleProbation":null,"HealthStatus":null,"InpatientPhysical":null,"InpatientPhysicalNights":null,"InpatientMental":null,"InpatientMentalNights":null,"InpatientAlcoholSA":null,"InpatientAlcoholSANights":null,"OutpatientPhysical":null,"OutpatientPhysicalTimes":null,"OutpatientMental":null,"OutpatientMentalTimes":null,"OutpatientAlcoholSA":null,"OutpatientAlcoholSATimes":null,"ERPhysical":null,"ERPhysicalTimes":null,"ERMental":null,"ERMentalTimes":null,"ERAlcoholSA":null,"ERAlcoholSATimes":null,"SexActivity":null,"SexContacts":null,"SexUnprot":null,"SexUnprotHIVAids":null,"SexUnprotInjDrugUser":null,"SexUnprotHigh":null,"fHIVTest":null,"fHIVTestResult":null,"LifeQuality":null,"HealthSatisfaction":null,"EnoughEnergyForEverydayLife":null,"PerformDailyActivitiesSatisfaction":null,"SelfSatisfaction":null,"Depression":null,"Anxiety":null,"Hallucinations":null,"BrainFunction":null,"ViolentBehavior":null,"Suicide":null,"PsycholEmotMedication":null,"PsycholEmotImpact":null,"AnyViolence":null,"Nightmares":null,"TriedHard":null,"ConstantGuard":null,"NumbAndDetach":null,"PhysicallyHurt":null,"AttendVoluntary":null,"AttendVoluntaryTimes":null,"AttendReligious":null,"AttendReligiousTimes":null,"AttendOtherOrg":null,"AttendOtherOrgTimes":null,"InteractFamilyFriends":null,"WhomInTrouble":null,"WhomInTroubleSpec":null,"RelationshipSatisfaction":null,"SvcCaseManagement":null,"SvcDayTreatment":null,"SvcInpatient":null,"SvcOutpatient":null,"SvcOutreach":null,"SvcIntensiveOutpatient":null,"SvcMethadone":null,"SvcResidentialRehab":null,"SvcHospitalInpatient":null,"SvcFreeStandingRes":null,"SvcAmbulatoryDetox":null,"SvcAfterCare":null,"SvcRecoverySupport":null,"SvcOtherModalities":null,"SvcOtherModalitesSpec":null,"SvcScreening":null,"SvcBriefIntervention":null,"SvcBriefTreatment":null,"SvcReferralTreatment":null,"SvcAssessment":null,"SvcTreatmentPlanning":null,"SvcIndividualCouns":null,"SvcGroupCouns":null,"SvcFamilyMarriageCouns":null,"SvcCoOccurring":null,"SvcPharmacological":null,"SvcHIVAIDSCouns":null,"SvcOtherClinicalCouns":null,"SvcOtherClinicalCounsSpec":null,"SvcFamilyServices":null,"SvcChildCare":null,"SvcPreEmployment":null,"SvcEmploymentCoaching":null,"SvcIndividualCoord":null,"SvcTransportation":null,"SvcHIVAIDSServices":null,"SvcDrugFreeHousing":null,"SvcOtherCaseMgmt":null,"SvcOtherCaseMgmtSpec":null,"SvcMedicalCare":null,"SvcAlcoholDrugTesting":null,"SvcHIVAIDSMedical":null,"SvcOtherMedical":null,"SvcOtherMedicalSpec":null,"SvcContinuingCare":null,"SvcRelapsePrevention":null,"SvcRecoveryCoaching":null,"SvcSelfHelpSupport":null,"SvcSpiritualSupport":null,"SvcOtherAfterCare":null,"SvcOtherAfterCareSpec":null,"SvcSubstanceAbuseEdu":null,"SvcHIVAIDSEdu":null,"SvcOtherEdu":null,"SvcOtherEduSpec":null,"SvcPeerCoaching":null,"SvcHousingSupport":null,"SvcDrugFreeSocial":null,"SvcInformationReferral":null,"SvcOtherRecovery":null,"SvcOtherRecoverySpec":null,"DAUseRefused":null,"DrugDaysRefused":null,"IncomeRefused":null,"CrimeRefused":null,"TreatmentRefused":null,"MentalHealthRefused":null}];
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
        log('GPRA #' + index);
        assert(spars.document.title !== "Interview Selection", "Incorrect page");
        data = gpras[index];
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
            setTimeout(inputPage2, 1000, data);
        }
    }, 1000, data);
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
        setCombo('DAUseBothDays', data.DAUseBothDays, 0);
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
    if(data.DAUseIllegDrugsDays > 0) { //if drug days on last page is 0, you can skip this section
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
    if(data.DAUseIllegDrugsDays > 0) { //if drug days on last page is 0, you can skip this section
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
    //the HIV questions are disabled until you click next the first time
    //clickButton('ToolBar_Next');
    setTimeout(function() {
        setValue('HIVTest', data.jHIVTest, MV);
        if(data.jHIVTest === "0") {
            setValue('HIVTestResult', data.jHIVTestResult);
        }
        clickButton('ToolBar_Next');
        setTimeout(servicesReceivedPage1, 1000, data);
    }, 1000, data);
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