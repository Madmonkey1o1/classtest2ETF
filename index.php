<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Student Records</title>
    <script>
        $(document).ready(function() {
            // Function to fetch all students
            function showAllStudents() {
                $.ajax({
                    type: 'GET',
                    url: 'server.php', // Change this to the appropriate endpoint
                    cache: false,
                    success: function(response) {
                        var students = JSON.parse(response);
                        if (students.length > 0) {
                            var studentList = $("#student-list");
                            studentList.empty(); // Clear previous results
                            students.forEach(function(student) {
                                studentList.append("<div><p>SID: " + student.sid + "</p><p>Name: " + student.name + "</p><p>Age: " + student.age + "</p><p>Address: " + student.address + "</p><p>CGPA: " + student.cgpa + "</p></div>");
                            });
                        } else {
                            alert("No students found.");
                        }
                    },
                    error: function(jqXhr, textStatus, errorMessage) {
                        console.log(errorMessage);
                    }
                });
            }

            // Event listener for the form submission
            $("#form").submit(function(e){
                e.preventDefault();
                var sid = $("#sid").val();
                // AJAX request to find a specific student
                $.ajax({
                    type: 'GET',
                    url: 'server.php',
                    data: {
                        sid: sid
                    },
                    cache: false,
                    success: function(response) {
                        if (response == 0) {
                            alert("Student not found");
                        } else {
                            var studentDetails = JSON.parse(response);
                            displayStudentDetails(studentDetails);
                        }
                    },
                    error: function(jqXhr, textStatus, errorMessage) {
                        console.log(errorMessage);
                    }
                });
            });

            // Function to display student details
            function displayStudentDetails(studentDetails) {
                $("#form").hide();
                $("#student-details").show();
                $("#student-sid").text("SID: " + studentDetails.sid);
                $("#student-name").text("Name: " + studentDetails.name);
                $("#student-age").text("Age: " + studentDetails.age);
                $("#student-address").text("Address: " + studentDetails.address);
                $("#student-cgpa").text("CGPA: " + studentDetails.cgpa);
            }

            // Event listener for "Show all students" button
            $("#show-all-btn").click(function() {
                showAllStudents();
            });
        });
    </script>
</head>
<body>
    <main>
        <form id="form">
            <input type="text" id="sid" placeholder="Enter the SID">
            <button>Find student</button>
            <button id="show-all-btn">Show all students</button>
        </form>
        <form id="student-details" style="display: none;">
            <p id="student-sid">SID: </p>
            <p id="student-name">Name: </p>
            <p id="student-age">Age: </p>
            <p id="student-address">Address: </p>
            <p id="student-cgpa">CGPA: </p>
            <button id="return-btn">Return to Search</button>
        </form>
        <div id="student-list"></div>
    </main>
</body>
</html>
