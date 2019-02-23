
<?php
/*
 * DB Class
 * This class is used for database related (connect, insert, and update) operations
 * @author    CodexWorld.com
 * @url        http://www.codexworld.com
 * @license    http://www.codexworld.com/license
 */
class DB{
    private $dbHost     = "localhost";
    // private $dbUsername = "root";
    // private $dbPassword = "";
    // private $dbName     = "bb_otp3";
    private $dbUsername = "";
    private $dbPassword = "";
    private $dbName     = "";
    private $tblName    = "bb_players";
    
    public function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
            }
        }
    }
    
    /*
     * Returns rows from the database based on the conditions
     * @param string name of the table
     * @param array select, where, order_by, limit and return_type conditions
     */
    public function checkRow($conditions = array()){
        $sql = 'SELECT * FROM '.$this->tblName;
        if(!empty($conditions)&& is_array($conditions)){
            $sql .= ' WHERE ';
            $i = 0;
            foreach($conditions as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $sql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }

        $result = $this->db->query($sql);
        
		if(($result->num_rows) > 0)
        	return true;
		else
            return false;    
        }

    public function checkRowInThisTable($conditions = array(),$tabelName){
        $sql = 'SELECT * FROM '.$tabelName;
        if(!empty($conditions)&& is_array($conditions)){
            $sql .= ' WHERE ';
            $i = 0;
            foreach($conditions as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $sql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }

        $result = $this->db->query($sql);
        
        if(($result->num_rows) > 0)
        	return true;
		else
			return false;
    }
    
    /*
     * Insert data into the database
     * @param string name of the table
     * @param array the data for inserting into the table
     */
    public function insert($data,$tbl){
        if(!empty($data) && is_array($data)){
            $columns = '';
            $values  = '';
            $i = 0;
            foreach($data as $key=>$val){
                $pre = ($i > 0)?', ':'';
                $columns .= $pre.$key;
                $values  .= $pre."'".$val."'";
                $i++;
            }
            $query = "INSERT INTO ".$tbl." (".$columns.") VALUES (".$values.")";
            $insert = $this->db->query($query);
            return $insert?$this->db->insert_id:false;
        }else{
            return false;
        }
    }
    
    /*
     * Update data into the database
     * @param string name of the table
     * @param array the data for updating into the table
     * @param array where condition on updating data
     */
    public function update($data,$conditions){
        if(!empty($data) && is_array($data)){
            $colvalSet = '';
            $whereSql = '';
            $i = 0;
            foreach($data as $key=>$val){
                $pre = ($i > 0)?', ':'';
                $colvalSet .= $pre.$key."='".$val."'";
                $i++;
            }
            if(!empty($conditions)&& is_array($conditions)){
                $whereSql .= ' WHERE ';
                $i = 0;
                foreach($conditions as $key => $value){
                    $pre = ($i > 0)?' AND ':'';
                    $whereSql .= $pre.$key." = '".$value."'";
                    $i++;
                }
            }
            $query = "UPDATE ".$this->tblName." SET ".$colvalSet.$whereSql;
            $update = $this->db->query($query);
            return $update?$this->db->affected_rows:false;
        }else{
            return false;
        }
    }

    
    public function getColVal($tbl, $col)
    {
        $sql = 'SELECT * FROM ' . $tbl;
        $result = $this->db->query("set names 'utf8'");
        $result = $this->db->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                return $row[$col];
            }
        }
        return 0;
    }

    public function getColsVals($tbl, $cols ,$page,$items_per_page)
    {
        if($items_per_page>100)
            $items_per_page = 100;
        $offset = ($page ) * $items_per_page;

        $sql = 'SELECT ' . $cols . ' FROM '. $tbl . ' '." LIMIT " . $offset . "," . $items_per_page;
        $result = $this->db->query($sql);

        if ($result->num_rows > 0) {

            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return 0;
    }
    
}