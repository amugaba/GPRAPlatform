<?php

class GPRA extends Assessment
{
    //GPRA types
    const INTAKE = 1;
    const DISCHARGE = 2;
    const FOLLOWUP_3MONTH = 3;
    const FOLLOWUP_6MONTH = 4;
    const TYPES = [AssessmentTypes::GPRAIntake, AssessmentTypes::GPRADischarge, AssessmentTypes::GPRAFollowup];

    /**
     * The sections in a GPRA varies by type and whether an interview was conducted or not
     * @param int $type
     * @param bool $didInterview
     * @return array
     */
    public static function getSections($type, $didInterview = true) {
        if($type == AssessmentTypes::GPRAIntake)
            return [0,1,2,3,4,5,6,7,8,9,10];
        if($type == AssessmentTypes::GPRADischarge && $didInterview)
            return [0,1,4,5,6,7,8,9,10,12,13];
        if($type == AssessmentTypes::GPRADischarge && !$didInterview)
            return [0,12,13];
        if($type == AssessmentTypes::GPRAFollowup && $didInterview)
            return [0,1,4,5,6,7,8,9,10,11];
        if($type == AssessmentTypes::GPRAFollowup && !$didInterview)
            return [0,11];
        return [];
    }

    public static function getAssessmentType($gpra_type) {
        if($gpra_type == GPRA::INTAKE)
            return AssessmentTypes::GPRAIntake;
        if($gpra_type == GPRA::DISCHARGE)
            return AssessmentTypes::GPRADischarge;
        if($gpra_type == GPRA::FOLLOWUP_3MONTH || $gpra_type == GPRA::FOLLOWUP_6MONTH)
            return AssessmentTypes::GPRAFollowup;
        return null;
    }

    public $GrantNo;
    public $ClientID;
    public $ClientType;
    public $InterviewTypeCode;
    public $IntakeSeqNum;
    public $InterviewDate;
    public $ICD10CodeOne;
    public $ICD10CodeOneCategory;
    public $ICD10CodeTwo;
    public $ICD10CodeTwoCategory;
    public $ICD10CodeThree;
    public $ICD10CodeThreeCategory;
    public $OpioidDisorder;
    public $MethadoneMedication;
    public $MethadoneMedicationDays;
    public $BuprenorphineMedication;
    public $BuprenorphineMedicationDays;
    public $NaltrexoneMedication;
    public $NaltrexoneMedicationDays;
    public $NaltrexoneXRMedication;
    public $NaltrexoneXRMedicationDays;
    public $AlcoholDisorder;
    public $NaltrexoneAlcMedication;
    public $NaltrexoneAlcMedicationDays;
    public $NaltrexoneXRAlcMedication;
    public $NaltrexoneXRAlcMedicationDays;
    public $DisulfiramMedication;
    public $DisulfiramMedicationDays;
    public $AcamprosateMedication;
    public $AcamprosateMedicationDays;
    public $ClientIntake_CooccurringScreen;
    public $ClientIntake_CooccurringScreenStatus;
    public $ClientIntake_ClientIntakeSBIRT_ClientScreen;
    public $ClientIntake_ClientIntakeSBIRT_ScoreType1;
    public $ClientIntake_ClientIntakeSBIRT_ScoreValue1;
    public $SbirtOtherspec1;
    public $ClientIntake_ClientIntakeSBIRT_ScoreType2;
    public $ClientIntake_ClientIntakeSBIRT_ScoreValue2;
    public $SbirtOtherspec2;
    public $ClientIntake_ClientIntakeSBIRT_ScoreType3;
    public $ClientIntake_ClientIntakeSBIRT_ScoreValue3;
    public $SbirtOtherspec3;
    public $ClientIntake_ClientIntakeSBIRT_ClientSBIRTCont;
    public $SBIRTclasscode;
    public $GrantInactFlag;
    public $InactFlag;
    public $FFY;
    public $Quarter;
    public $Month;
    public $ConductedInterview;
    public $GenderCode;
    public $GenderOtherSpecify;
    public $HispanicLatino;
    public $EthnicCentralAmerican;
    public $EthnicCuban;
    public $EthnicDominican;
    public $EthnicMexican;
    public $EthnicPuertoRican;
    public $EthnicSouthAmerican;
    public $EthnicOther;
    public $EthnicOtherSpec;
    public $RaceBlack;
    public $RaceAsian;
    public $RaceAmericanIndian;
    public $RaceNativeHawaiian;
    public $RaceAlaskaNative;
    public $RaceWhite;
    public $BirthYear;
    public $BirthMonth;
    public $Age;
    public $AgeGroup;
    public $Veteran;
    public $MilitaryServed;
    public $ActiveDuty;
    public $NeverDeployed;
    public $IraqAfghanistan;
    public $PersianGulf;
    public $VietnamSoutheastAsia;
    public $Korea;
    public $WWII;
    public $DeployedCombatZone;
    public $FamilyActiveDuty;
    public $ServiceMemRelationship1;
    public $ServiceMemExpOther1;
    public $ServiceMemExpDeployed1;
    public $ServiceMemExpInjured1;
    public $ServiceMemExpCombatStress1;
    public $ServiceMemExpDeceased1;
    public $ServiceMemRelationship2;
    public $ServiceMemExpOther2;
    public $ServiceMemExpDeployed2;
    public $ServiceMemExpInjured2;
    public $ServiceMemExpCombatStress2;
    public $ServiceMemExpDeceased2;
    public $ServiceMemRelationship3;
    public $ServiceMemExpOther3;
    public $ServiceMemExpDeployed3;
    public $ServiceMemExpInjured3;
    public $ServiceMemExpCombatStress3;
    public $ServiceMemExpDeceased3;
    public $ServiceMemRelationship4;
    public $ServiceMemExpOther4;
    public $ServiceMemExpDeployed4;
    public $ServiceMemExpInjured4;
    public $ServiceMemExpCombatStress4;
    public $ServiceMemExpDeceased4;
    public $ServiceMemRelationship5;
    public $ServiceMemExpOther5;
    public $ServiceMemExpDeployed5;
    public $ServiceMemExpInjured5;
    public $ServiceMemExpCombatStress5;
    public $ServiceMemExpDeceased5;
    public $ServiceMemRelationship6;
    public $ServiceMemExpOther6;
    public $ServiceMemExpDeployed6;
    public $ServiceMemExpInjured6;
    public $ServiceMemExpCombatStress6;
    public $ServiceMemExpDeceased6;
    public $DAUseAlcoholDays;
    public $DAUseAlcoholIntox5Days;
    public $DAUseAlcoholIntox4Days;
    public $DAUseIllegDrugsDays;
    public $DAUseBothDays;
    public $CocaineCrackDays;
    public $CocaineCrackRoute;
    public $MarijuanaHashDays;
    public $MarijuanaHashRoute;
    public $OpiatesHeroinDays;
    public $OpiatesHeroinRoute;
    public $OpiatesMorphineDays;
    public $OpiatesMorphineRoute;
    public $OpiatesDiluadidDays;
    public $OpiatesDiluadidRoute;
    public $OpiatesDemerolDays;
    public $OpiatesDemerolRoute;
    public $OpiatesPercocetDays;
    public $OpiatesPercocetRoute;
    public $OpiatesDarvonDays;
    public $OpiatesDarvonRoute;
    public $OpiatesCodeineDays;
    public $OpiatesCodeineRoute;
    public $OpiatesTylenolDays;
    public $OpiatesTylenolRoute;
    public $OpiatesOxycoDays;
    public $OpiatesOxycoRoute;
    public $NonPresMethadoneDays;
    public $NonPresMethadoneRoute;
    public $HallucPsychDays;
    public $HallucPsychRoute;
    public $MethamDays;
    public $MethamRoute;
    public $BenzodiazepinesDays;
    public $BenzodiazepinesRoute;
    public $BarbituatesDays;
    public $BarbituatesRoute;
    public $NonPrescGhbDays;
    public $NonPrescGhbRoute;
    public $KetamineDays;
    public $KetamineRoute;
    public $OtherTranquilizersDays;
    public $OtherTranquilizersRoute;
    public $InhalantsDays;
    public $InhalantsRoute;
    public $OtherIllegalDrugsDays;
    public $OtherIllegalDrugsRoute;
    public $OtherIllegalDrugsSpec;
    public $InjectedDrugs;
    public $ParaphenaliaUsedOthers;
    public $LivingWhere;
    public $LivingHoused;
    public $LivingHousedSpec;
    public $LivingConditionsSatisfaction;
    public $ImpactStress;
    public $ImpactActivity;
    public $ImpactEmotional;
    public $Pregnant;
    public $Children;
    public $ChildrenNr;
    public $ChildrenCustody;
    public $ChildrenCustodyNr;
    public $ChildrenCustodyLost;
    public $TrainingProgram;
    public $TrainingProgramSpec;
    public $EducationYears;
    public $EmployStatus;
    public $EmployStatusSpec;
    public $Employment;
    public $IncomeWages;
    public $IncomePubAssist;
    public $IncomeRetirement;
    public $IncomeDisability;
    public $IncomeNonLegal;
    public $IncomeFamFriends;
    public $IncomeOther;
    public $IncomeOtherSpec;
    public $EnoughMoneyForNeeds;
    public $ArrestedDays;
    public $ArrestedDrugDays;
    public $ArrestedConfineDays;
    public $NrCrimes;
    public $AwaitTrial;
    public $ParoleProbation;
    public $HealthStatus;
    public $InpatientPhysical;
    public $InpatientPhysicalNights;
    public $InpatientMental;
    public $InpatientMentalNights;
    public $InpatientAlcoholSA;
    public $InpatientAlcoholSANights;
    public $OutpatientPhysical;
    public $OutpatientPhysicalTimes;
    public $OutpatientMental;
    public $OutpatientMentalTimes;
    public $OutpatientAlcoholSA;
    public $OutpatientAlcoholSATimes;
    public $ERPhysical;
    public $ERPhysicalTimes;
    public $ERMental;
    public $ERMentalTimes;
    public $ERAlcoholSA;
    public $ERAlcoholSATimes;
    public $SexActivity;
    public $SexContacts;
    public $SexUnprot;
    public $SexUnprotHIVAids;
    public $SexUnprotInjDrugUser;
    public $SexUnprotHigh;
    public $fHIVTest;
    public $fHIVTestResult;
    public $LifeQuality;
    public $HealthSatisfaction;
    public $EnoughEnergyForEverydayLife;
    public $PerformDailyActivitiesSatisfaction;
    public $SelfSatisfaction;
    public $Depression;
    public $Anxiety;
    public $Hallucinations;
    public $BrainFunction;
    public $ViolentBehavior;
    public $Suicide;
    public $PsycholEmotMedication;
    public $PsycholEmotImpact;
    public $AnyViolence;
    public $Nightmares;
    public $TriedHard;
    public $ConstantGuard;
    public $NumbAndDetach;
    public $PhysicallyHurt;
    public $AttendVoluntary;
    public $AttendVoluntaryTimes;
    public $AttendReligious;
    public $AttendReligiousTimes;
    public $AttendOtherOrg;
    public $AttendOtherOrgTimes;
    public $InteractFamilyFriends;
    public $WhomInTrouble;
    public $WhomInTroubleSpec;
    public $RelationshipSatisfaction;
    public $FLWPStatus;
    public $FLWPStatusSpec;
    public $ReceivingServices;
    public $DischargeDate;
    public $DischargeStatusCompl;
    public $DischargeStatusTermReason;
    public $OtherDischargeStatTermRsnSpec;
    public $jHIVTest;
    public $jHIVTestResult;
    public $SvcCaseManagement;
    public $SvcDayTreatment;
    public $SvcInpatient;
    public $SvcOutpatient;
    public $SvcOutreach;
    public $SvcIntensiveOutpatient;
    public $SvcMethadone;
    public $SvcResidentialRehab;
    public $SvcHospitalInpatient;
    public $SvcFreeStandingRes;
    public $SvcAmbulatoryDetox;
    public $SvcAfterCare;
    public $SvcRecoverySupport;
    public $SvcOtherModalities;
    public $SvcOtherModalitesSpec;
    public $SvcScreening;
    public $SvcBriefIntervention;
    public $SvcBriefTreatment;
    public $SvcReferralTreatment;
    public $SvcAssessment;
    public $SvcTreatmentPlanning;
    public $SvcIndividualCouns;
    public $SvcGroupCouns;
    public $SvcFamilyMarriageCouns;
    public $SvcCoOccurring;
    public $SvcPharmacological;
    public $SvcHIVAIDSCouns;
    public $SvcOtherClinicalCouns;
    public $SvcOtherClinicalCounsSpec;
    public $SvcFamilyServices;
    public $SvcChildCare;
    public $SvcPreEmployment;
    public $SvcEmploymentCoaching;
    public $SvcIndividualCoord;
    public $SvcTransportation;
    public $SvcHIVAIDSServices;
    public $SvcDrugFreeHousing;
    public $SvcOtherCaseMgmt;
    public $SvcOtherCaseMgmtSpec;
    public $SvcMedicalCare;
    public $SvcAlcoholDrugTesting;
    public $SvcHIVAIDSMedical;
    public $SvcOtherMedical;
    public $SvcOtherMedicalSpec;
    public $SvcContinuingCare;
    public $SvcRelapsePrevention;
    public $SvcRecoveryCoaching;
    public $SvcSelfHelpSupport;
    public $SvcSpiritualSupport;
    public $SvcOtherAfterCare;
    public $SvcOtherAfterCareSpec;
    public $SvcSubstanceAbuseEdu;
    public $SvcHIVAIDSEdu;
    public $SvcOtherEdu;
    public $SvcOtherEduSpec;
    public $SvcPeerCoaching;
    public $SvcHousingSupport;
    public $SvcDrugFreeSocial;
    public $SvcInformationReferral;
    public $SvcOtherRecovery;
    public $SvcOtherRecoverySpec;
    public $SvcCaseManagementDis;
    public $SvcDayTreatmentDis;
    public $SvcInpatientDis;
    public $SvcOutpatientDis;
    public $SvcOutreachDis;
    public $SvcIntensiveOutpatientDis;
    public $SvcMethadoneDis;
    public $SvcResidentialRehabDis;
    public $SvcHospitalInpatientDis;
    public $SvcFreeStandingResDis;
    public $SvcAmbulatoryDetoxDis;
    public $SvcAfterCareDis;
    public $SvcRecoverySupportDis;
    public $SvcOtherModalitiesDis;
    public $SvcOtherModalitesSpecDis;
    public $SvcScreeningDis;
    public $SvcBriefInterventionDis;
    public $SvcBriefTreatmentDis;
    public $SvcReferralTreatmentDis;
    public $SvcAssessmentDis;
    public $SvcTreatmentPlanningDis;
    public $SvcIndividualCounsDis;
    public $SvcGroupCounsDis;
    public $SvcFamilyMarriageCounsDis;
    public $SvcCoOccurringDis;
    public $SvcPharmacologicalDis;
    public $SvcHIVAIDSCounsDis;
    public $SvcOtherClinicalCounsDis;
    public $SvcOtherClinicalCounsSpecDis;
    public $SvcFamilyServicesDis;
    public $SvcChildCareDis;
    public $SvcPreEmploymentDis;
    public $SvcEmploymentCoachingDis;
    public $SvcIndividualCoordDis;
    public $SvcTransportationDis;
    public $SvcHIVAIDSServicesDis;
    public $SvcDrugFreeHousingDis;
    public $SvcOtherCaseMgmtDis;
    public $SvcOtherCaseMgmtSpecDis;
    public $SvcMedicalCareDis;
    public $SvcAlcoholDrugTestingDis;
    public $SvcHIVAIDSMedicalDis;
    public $SvcOtherMedicalDis;
    public $SvcOtherMedicalSpecDis;
    public $SvcContinuingCareDis;
    public $SvcRelapsePreventionDis;
    public $SvcRecoveryCoachingDis;
    public $SvcSelfHelpSupportDis;
    public $SvcSpiritualSupportDis;
    public $SvcOtherAfterCareDis;
    public $SvcOtherAfterCareSpecDis;
    public $SvcSubstanceAbuseEduDis;
    public $SvcHIVAIDSEduDis;
    public $SvcOtherEduDis;
    public $SvcOtherEduSpecDis;
    public $SvcPeerCoachingDis;
    public $SvcHousingSupportDis;
    public $SvcDrugFreeSocialDis;
    public $SvcInformationReferralDis;
    public $SvcOtherRecoveryDis;
    public $SvcOtherRecoverySpecDis;
    public $InterviewCreateDate;
    public $DAUseRefused;
    public $DrugDaysRefused;
    public $IncomeRefused;
    public $CrimeRefused;
    public $TreatmentRefused;
    public $MentalHealthRefused;
}