<?php

class StaffModel
{

    public $conn;

    public function __construct()
    {
        $configDB = require_once('db_config.php');

        $this->conn = new \mysqli($configDB["DB_HOST"], $configDB["DB_USERNAME"], $configDB["DB_PASSWORD"], $configDB["DB_DATABASE"]);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }


    /**
     * @return array
     */
    public function getAll()
    {

        $sql = "SELECT * FROM `staff`";
        $result = $this->conn->query($sql);
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($data, $row);
            }
        }

        return $data;
    }

    public function insertData($data){
        $sql = "INSERT INTO `staff_income` (`staff_id`, `duration`, `total_salary`) VALUES ";


        $i = 0;
        foreach ($data as $datum){
            $staff_id = $datum['staff_id'];
            $duration = $datum['duration'];
            $salary = $datum['total_salary'];
            $sql .= "($staff_id, $duration, $salary)";

            if(count($data) > $i+1){
                $sql .= ",";
            }

            $i++;
        }

        $result = $this->conn->query($sql);
    }
}
