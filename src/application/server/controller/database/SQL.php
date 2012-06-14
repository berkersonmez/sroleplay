<?php

class C_Database_SQL {

    public static function getSelectQuery1Where1Limit( $select,  $from,  $where1, $limit1, $orderBy = 'id', $desc = 0) {
        return 'SELECT '.$select.' FROM '.$from.' WHERE '.$where1.' = ? ORDER BY '.$orderBy.' '.($desc ? 'DESC' : 'ASC').' LIMIT '.$limit1;
    }

    public static function getSelectQuery1Where( $select,  $from,  $where1, $orderBy = 'id', $desc = 0) {
        return 'SELECT '.$select.' FROM '.$from.' WHERE '.$where1.' = ? ORDER BY '.$orderBy.' '.($desc ? 'DESC' : 'ASC');
    }

    public static function getSelectQuery( $select,  $from, $orderBy = 'id', $desc = 0) {
        return 'SELECT '.$select.' FROM '.$from.' ORDER BY '.$orderBy.' '.($desc ? 'DESC' : 'ASC');
    }

    public static function getSelectQuery2Where_OR( $select,  $from,  $where1,  $where2, $orderBy = 'id', $desc = 0) {
        return 'SELECT '.$select.' FROM '.$from.' WHERE '.$where1.' = ? OR '.$where2.' = ? ORDER BY '.$orderBy.' '.($desc ? 'DESC' : 'ASC');
    }

    public static function getSelectQuery3Where_OR_AND( $select,  $from,  $where1,  $where2,  $where3, $orderBy = 'id', $desc = 0) {
        return 'SELECT '.$select.' FROM '.$from.' WHERE ('.$where1.' = ? OR '.$where2.' = ?) AND '.$where3.' = ? ORDER BY '.$orderBy.' '.($desc ? 'DESC' : 'ASC');
    }

    public static function getInsertQuery(array $columns,  $into, $columnsCount) {
        $query = 'INSERT INTO '.$into.' (';
        for ($i = 0 ; $i < $columnsCount ; $i++) {
            $query .= $columns[$i];
            if (!($i == $columnsCount-1)) {$query .= ",";}
        }
        $query .= ") VALUES (";
        for ($i = 0 ; $i < $columnsCount ; $i++) {
            $query .= "?";
            if (!($i == $columnsCount-1)) {$query .= ",";}
        }
        $query .= ")";
        return $query;
    }

    public static function getUpdateQuery1Where(array $columns, $update, $columnsCount,  $where1) {
        $query = 'UPDATE '.$update.' SET ';
        for ($i = 0 ; $i < $columnsCount ; $i++) {
            $query .= $columns[$i] . ' = ?';
            if (!($i == $columnsCount-1)) {$query .= ",";}
        }
        $query .= ' WHERE '.$where1.' = ?';
        return $query;
    }

    public static function getDeleteQuery1Where($from, $where1) {
        return 'DELETE FROM '.$from. ' WHERE '.$where1.' = ?';
    }

    public static function getDeleteQuery2Where_AND($from, $where1, $where2) {
        return 'DELETE FROM '.$from. ' WHERE '.$where1.' = ? AND '.$where2.' = ?';
    }

    public static function getSearchQuery1LikeWhere( $select,  $from,  $likeWhere1, $orderBy = 'id', $desc = 0) {
        return "SELECT ".$select." FROM ".$from." WHERE ".$likeWhere1." LIKE CONCAT('%',?,'%') ORDER BY ".$orderBy." ".($desc ? "DESC" : "ASC");
    }

    public static function getSelectQuery1NotWhere( $select,  $from,  $notWhere1, $orderBy = 'id', $desc = 0) {
        return 'SELECT '.$select.' FROM '.$from.' WHERE '.$notWhere1.' <> ? ORDER BY '.$orderBy.' '.($desc ? 'DESC' : 'ASC');
    }

    public static function getSelectQuery1Where1NotWhere_AND( $select,  $from,  $where1,  $notWhere1, $orderBy = 'id', $desc = 0) {
        return 'SELECT '.$select.' FROM '.$from.' WHERE '.$where1.' = ? AND '.$notWhere1.' <> ? ORDER BY '.$orderBy.' '.($desc ? 'DESC' : 'ASC');
    }

    public static function getSearchQuery1LikeWhere1NotWhere_AND( $select,  $from,  $likeWhere1,  $notWhere1, $orderBy = 'id', $desc = 0) {
        return "SELECT ".$select." FROM ".$from." WHERE ".$likeWhere1." LIKE CONCAT('%',?,'%') AND ".$notWhere1." <> ? ORDER BY ".$orderBy." ".($desc ? "DESC" : "ASC");
    }

    public static function getCountQuery( $from) {
        return 'SELECT COUNT(*) FROM '.$from;
    }

    public static function getSelectQueryCustom( $selectText,  $fromText,  $whereText, $orderBy = 'id', $desc = 0) {
        return 'SELECT '.$selectText.' FROM '.$fromText.' WHERE '.$whereText.' ORDER BY '.$orderBy.' '.($desc ? 'DESC' : 'ASC');
    }

    public static function getDeleteQueryCustom( $fromText,  $whereText) {
        return 'DELETE FROM '.$fromText. ' WHERE '.$whereText;
    }

    public static function getInsertQueryCustom( $intoText,  $valuesText) {
        return 'INSERT INTO '.$intoText.' VALUES ('.$valuesText.')';
    }

    public static function executeSQL(PDO $pdoInstance, $query, array $parameters) {
        $q = $pdoInstance->prepare($query);
        $q->execute($parameters);
        return $q->fetchAll();
    }

    public static function executeInsertSQL(PDO $pdoInstance, $query, array $parameters) {
        $q = $pdoInstance->prepare($query);
        $q->execute($parameters);
        return $pdoInstance->lastInsertId();
    }
}