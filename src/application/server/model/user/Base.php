<?php

abstract class M_User_Base extends M_DBModel {

    protected $id;
    protected $name;
    protected $password;
    protected $email;
    protected $publicProfile;
    protected $age;
    protected $gender;
    protected $biography;
    protected $sqlid;
    protected $roleID;
    protected $role;
    protected $skinID;
    protected $approved;
    protected $skin;
    protected $playerID;
    protected $player;

    public function __construct($id = "", $name = "", $password = "", $email = "", $publicProfile = "", $age = "", $gender = "", $biography = "", $sqlid = "", $roleID = "", $skinID = "", $approved = "") {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->email = $email;
        $this->publicProfile = $publicProfile;
        $this->age = $age;
        $this->gender = $gender;
        $this->biography = $biography;
        $this->sqlid = $sqlid;
        $this->roleID = $roleID;
        $this->skinID = $skinID;
        $this->approved = $approved;
        $this->maintainSkin();
        $this->maintainRole();
    }

    public function initWithID($id) {
        $result = C_Database_SQL::executeSQL(self::$_dbo, C_Database_SQL::getSelectQuery1Where1Limit("*", "paneluser", "id", 1), array($id));
        if (empty($result)) {return false;}
        $this->initSelf($result[0]);
        $this->maintainRole();
        $this->maintainSkin();
        return true;
    }

    public function initWithSQLResult($sqlResult) {
        $result = $sqlResult;
        if (empty($result)) {return false;}
        $this->initSelf($result);
        $this->maintainRole();
        $this->maintainSkin();
        return true;
    }

    public function initWithUsernameOrEmailAndPass($usernameOrEmail, $password) {
        $result = C_Database_SQL::executeSQL(self::$_dbo, C_Database_SQL::getSelectQuery3Where_OR_AND("*", "paneluser", "name", "email", "password"), array($usernameOrEmail, $usernameOrEmail, $password));
        if (empty($result)) {return false;}
        $this->initSelf($result[0]);
        $this->maintainRole();
        $this->maintainSkin();
        return true;
    }

    public function initAndRegister($name, $password, $email, $publicProfile, $age, $gender, $biography, $sqlid, $skinID) {
        $result = C_Database_SQL::executeInsertSQL(self::$_dbo, C_Database_SQL::getInsertQuery(array("name", "password", "email", "publicProfile", "age", "gender", "biography", "sqlid", "skinID"),
            "paneluser", 9), array($name, $password, $email, $publicProfile, $age, $gender, $biography, $sqlid, $skinID));
        if (empty($result)) {return false;}
        if ($this->initWithID($result)) {
            return true;
        }
        return false;
    }

    public function createPlayerFromAndApproveSelf() {
        $result = C_Database_SQL::executeInsertSQL(self::$_dbo, C_Database_SQL::getInsertQuery(array("playerName", "playerPassword", "playerEmail", "playerPublicProfile", "playerAge", "playerBiography", "playerGender", "playerSkin", "sqlid"), "playeraccounts", 9),
            array($this->name, $this->password, $this->email, $this->publicProfile, $this->age, $this->biography, $this->gender, $this->skinID, $this->sqlid));
        if (empty($result)) {return false;}
        $this->playerID = $result;
        C_Database_SQL::executeSQL(self::$_dbo, C_Database_SQL::getUpdateQuery1Where(array("playerID", "approved"), "paneluser", 2, "id"), array($result, 1, $this->id));
        return true;
    }

    public function deletePlayerFromAndDisapproveSelf() {
        if ($this->isApproved())
            C_Database_SQL::executeSQL(self::$_dbo, C_Database_SQL::getDeleteQuery1Where("playeraccounts", "playerID"), array($this->playerID));
        C_Database_SQL::executeSQL(self::$_dbo, C_Database_SQL::getUpdateQuery1Where(array("playerID", "approved"), "paneluser", 2, "id"), array(NULL, -1, $this->id));
        $this->playerID = NULL;
        return true;
    }

    public function fireAdmin() {
        C_Database_SQL::executeSQL(self::$_dbo, C_Database_SQL::getUpdateQuery1Where(array("roleID"), "paneluser", 1, "id"), array(2, $this->id));
        $this->roleID = 2;
        $this->maintainRole();
        return true;
    }

    public function hireAdmin() {
        C_Database_SQL::executeSQL(self::$_dbo, C_Database_SQL::getUpdateQuery1Where(array("roleID"), "paneluser", 1, "id"), array(3, $this->id));
        $this->roleID = 3;
        $this->maintainRole();
        return true;
    }

    public function initPlayer() {
        $player = new M_Player_Regular();
        $player->initWithID($this->playerID);
        $this->player = $player;
    }

    public function login() {
        C_Security_Authenticate::loginWithApprovedUser($this);
    }

    public function maintainRole() {
        if ($this->roleID == 2) {
            $this->role = new M_Role_User();
        } else if ($this->roleID == 3) {
            $this->role = new M_Role_Admin();
        }
    }

    public function maintainSkin() {
        $this->skin = new M_Image_User($this->skinID);
    }

    public function printSkin($width, $height) {
        $this->skin->printSkin($width, $height);
    }

    public function isApproved() {
        return $this->approved;
    }

    public function getID()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPublicProfile()
    {
        return $this->publicProfile;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getBiography()
    {
        return $this->biography;
    }

    public function getSqlid()
    {
        return $this->sqlid;
    }

    public function getRoleID()
    {
        return $this->roleID;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getSkinID()
    {
        return $this->skinID;
    }

    public function getSkin()
    {
        return $this->skin;
    }

    public function getPlayerID()
    {
        return $this->playerID;
    }

    public function getPlayer()
    {
        return $this->player;
    }


}