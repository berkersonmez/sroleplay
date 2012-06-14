<?php

abstract class M_Player_Base extends M_DBModel {

    protected $playerID;
    protected $playerLevel;
    protected $playerName;
    protected $playerPassword;
    protected $playerEmail;
    protected $playerMoney;
    protected $playerBanned;
    protected $playerPublicProfile;
    protected $playerAdminLevel;
    protected $playerRegistrationDate;
    protected $playerSkin;
    protected $playerPosX;
    protected $playerPosY;
    protected $playerPosZ;
    protected $playerBankMoney;
    protected $playerHealth;
    protected $playerArmour;
    protected $playerAccent;
    protected $playerSeconds;
    protected $playerInterior;
    protected $playerVirutalWorld;
    protected $playerJob;
    protected $playerWeapon0;
    protected $playerWeapon1;
    protected $playerWeapon2;
    protected $playerWeapon3;
    protected $playerWeapon4;
    protected $playerWeapon5;
    protected $playerWeapon6;
    protected $playerWeapon7;
    protected $playerWeapon8;
    protected $playerWeapon9;
    protected $playerWeapon10;
    protected $playerWeapon11;
    protected $playerWeapon12;
    protected $playerJobSkill1;
    protected $playerJobSkill2;
    protected $playerMaterials;
    protected $playerGroupRank;
    protected $playerHours;
    protected $playerWarning1;
    protected $playerWarning2;
    protected $playerWarning3;
    protected $playerHospitalized;
    protected $playerAdminName;
    protected $playerFirstLogin;
    protected $playerGender;
    protected $playerPrisonID;
    protected $playerPrisonTime;
    protected $playerPhoneNumber;
    protected $playerPhoneBook;
    protected $playerIP;
    protected $playerHelperLevel;
    protected $playerRope;
    protected $playerAdminDuty;
    protected $playerCrimes;
    protected $playerArrests;
    protected $playerWarrants;
    protected $playerPasswordToken;
    protected $playerCarModel;
    protected $playerCarMod0;
    protected $playerCarMod1;
    protected $playerCarMod2;
    protected $playerCarMod3;
    protected $playerCarMod4;
    protected $playerCarMod5;
    protected $playerCarMod6;
    protected $playerCarMod7;
    protected $playerCarMod8;
    protected $playerCarMod9;
    protected $playerCarMod10;
    protected $playerCarMod11;
    protected $playerCarMod12;
    protected $playerCarPosX;
    protected $playerCarPosY;
    protected $playerCarPosZ;
    protected $playerCarPosZAngle;
    protected $playerCarColour;
    protected $playerCarColour1;
    protected $playerCarColour2;
    protected $playerAge;
    protected $playerCarPaintJob;
    protected $playerCarLock;
    protected $playerStatus;
    protected $playerBiography;
    protected $playerFightStyle;
    protected $playerVIP;
    protected $playerExpireVIP;
    protected $playerCarWeapon1;
    protected $playerCarWeapon2;
    protected $playerCarWeapon3;
    protected $playerCarWeapon4;
    protected $playerCarWeapon5;
    protected $playerCarTrunk1;
    protected $playerCarTrunk2;
    protected $playerPhoneCredit;
    protected $playerWalkieTalkie;
    protected $playerAdminTitle;
    protected $playerCarLicensePlate;
    protected $playerAdminPIN;
    protected $sqlid;

    public function __construct() {
        parent::__construct();
    }

    public function initWithID($id) {
        $result = C_Database_SQL::executeSQL(self::$_dbo, C_Database_SQL::getSelectQuery1Where1Limit("*", "playeraccounts", "playerID", 1, "playerID"), array($id));
        if (empty($result)) {return false;}
        $this->initSelf($result[0]);
        return true;
    }

    public function getFieldsArray() {
        return get_object_vars($this);
        /*
        $array = array();
        foreach($this as $key => $value) {
            $array[$key] = $value;
        }
        return $array;
        */
    }

    public function edit($newFieldsArray) {
        //print_r($newFieldsArray);
        $this->initSelf($newFieldsArray);
        $this->updateSelf($newFieldsArray);
    }

    public function updateSelf($newFieldsArray) {
        C_Database_SQL::executeSQL(self::$_dbo, C_Database_SQL::getUpdateQuery1Where(array_keys($newFieldsArray), "playeraccounts", count($newFieldsArray), "playerID"), array_merge(array_values($newFieldsArray), array($this->playerID)));
        print_r(array_keys($newFieldsArray));
        print_r(count($newFieldsArray));
        print_r(array_values($newFieldsArray));
        print_r(array_merge(array_values($newFieldsArray), array($this->playerID)));
    }

}