<?php
include 'StaffModel.php';
?>
<!doctype html>
<html lang="en">
<head>
    <script
            src="https://code.jquery.com/jquery-3.6.1.js"
            integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
            crossorigin="anonymous"></script>
    <meta charset="UTF-8">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Staff</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<table id="staff">
    <tr>
        <th>ID</th>
        <th>First name</th>
        <th>Last name</th>
        <th>Age</th>
        <th>Entry date</th>
    </tr>

    <?php

    $staff_model_obj = new StaffModel();
    $data = $staff_model_obj->getAll();

    foreach ($data as $key) {
        echo "<tr>";

            echo "<td class='id'>" . $key['id'] . "</td>";
            echo "<td>" . $key['firstName'] . "</td>";
            echo "<td>" . $key['lastName'] . "</td>";
            echo "<td>" . $key['age'] . "</td>";
            echo "<td class='hidden oneDaySalary'>" . $key['oneDaySalary'] . "</td>";
            echo "<td class='entryDate'>" . $key['entryDate'] . "</td>";
        echo "</tr>";
    }
 echo "</table>";
?>

    <button id="add_duration" onclick="addDuration()">Add Duration</button>
    <button id="get_salary" onclick="getSalary()">Get Salary</button>
    <button id='test'>Test</button>

    <script>

        var DateDiff = {

            inDays: function (d1, d2) {
                var t2 = d2.getTime();
                var t1 = d1.getTime();

                return Math.floor((t2 - t1) / (24 * 3600 * 1000));
            },
        }

        var staff_income = [];

        $(document).on('click', '#test', function(e){

            const data = [];
            const date = '2021-02-03';
            let d1 = new Date(date);

            let table = $(document).find('#staff');

            let rows = table.find('tr');

            for (let i = 0; i < rows.length; i++){
                if(i !== 0){
                    let entryDate = $(rows[i]).find('.entryDate')[0].innerText;
                    let id = $(rows[i]).find('.id')[0].innerText;
                    let d2 = new Date(entryDate);

                    let duration = DateDiff.inDays(d2, d1);

                    let oneDaySalary = $(rows[i]).find('.oneDaySalary')[0].innerText;

                    let salary = duration * oneDaySalary;

                    let obj = {
                        id: id,
                        salary: salary
                    }

                    staff_income.push({
                        staff_id: id,
                        duration: duration,
                        total_salary: salary
                    })

                    data.push(obj)
                }
            }
            add_table(staff_income);
            // test(data)
        })

        function test(data){
            const url = ' https://api.emis.am/test';

            $.ajax({
                url: url,
                type: 'post',
                contentType: "application/json",
                data: JSON.stringify(data),
                success: function(response){
                    alert(response)

                    add_table(staff_income);
                },
                error: function(){
                    alert('error')
                }
            })
        }

        function add_table(staff_income){
            $.ajax({
                url: 'staff.php',
                type: 'post',
                data: {
                    data: JSON.stringify(staff_income)
                },
                success: function(response){
                   //
                },
                error: function(){
                    alert('error')
                }
            })
        }

        function addDuration(){
            const date = '2021-02-03';
            let d1 = new Date(date);

            let table = $(document).find('#staff');

            let rows = table.find('tr');

            for (let i = 0; i < rows.length; i++){
                if(i === 0){
                    $(rows[i]).append("<th>Duration</th>")
                }
                else{
                    let entryDate = $(rows[i]).find('.entryDate')[0].innerText;
                    let d2 = new Date(entryDate);

                    let diff = DateDiff.inDays(d2, d1);

                    $(rows[i]).append("<td>"+diff+"</td>")
                }
            }

            $(document).find('#add_duration').remove();

        }

        function getSalary(){

            const date = '2021-02-03';
            let d1 = new Date(date);

            let table = $(document).find('#staff');

            let rows = table.find('tr');

            for (let i = 0; i < rows.length; i++){
                if(i === 0){
                    $(rows[i]).append("<th>Salary</th>")
                }
                else{
                    let entryDate = $(rows[i]).find('.entryDate')[0].innerText;
                    let d2 = new Date(entryDate);

                    let duration = DateDiff.inDays(d2, d1);

                    let oneDaySalary = $(rows[i]).find('.oneDaySalary')[0].innerText;

                    $(rows[i]).append("<td class='salary'>"+(duration * oneDaySalary)+"</td>")
                }
            }

            $(document).find('#get_salary').remove();

        }

    </script>
</body>
</html>