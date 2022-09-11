<?php
require 'StaffModel.php';

$data = $_POST['data'];

$staff_income = json_decode($data, true);

$staff_obj = new StaffModel();
$staff_obj->insertData($staff_income);