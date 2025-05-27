<?php
session_start();
include './DB/database.php';

if (isset($_POST['cities'])) {
    if (count($_POST['cities']) > 10) {
        echo "Error: Please select up to 10 cities only.";
        header("refresh: 3; url = selectcities.php");
        exit;
    }

    $selectedCityIDs = $_POST['cities'];
    $cityData = [];

    // Prepare IDs for SQL (safe way using IN clause)
    $idList = implode(",", array_map('intval', $selectedCityIDs));
    $sql = "SELECT city_name, country, aqi FROM cities WHERE id IN ($idList)";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $cityData[] = $row;
        }
        $_SESSION['selected_cities'] = $cityData;
    } else {
        echo "No city data found.";
        exit;
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Selected Cities</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6ff;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h2 {
            margin-top: 30px;
            color: #333;
        }

        table {
            margin: 30px auto;
            width: 90%;
            max-width: 800px;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        thead {
            background-color: #6c47ff;
            color: white;
        }

        th, td {
            padding: 15px 10px;
            text-align: center;
            font-size: 15px;
            border-bottom:1px solid white;
        }

        /* tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        } */

        .green {
            background-color: green;
            color:white;
        }

        .orange {
            background-color: orange;
            
        }

        .red {
            background-color: red;
            color:white;
        }

        .btn-container {
            margin: 20px auto;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #6c47ff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #5935cc;
        }
    </style>
</head>
<body>

<h2>Selected Cities & Air Quality Index</h2>

<table>
    <thead>
        <tr>
            <th>City</th>
            <th>Country</th>
            <th>AQI & Grade</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($_SESSION['selected_cities'])) {
            foreach ($_SESSION['selected_cities'] as $city) {
                $aqi = $city['aqi'];

                // Grade & color
                if ($aqi <= 50) {
                    $class = 'green';
                    $grade = 'Good';
                } elseif ($aqi <= 70) {
                    $class = 'orange';
                    $grade = 'Moderate';
                } else {
                    $class = 'red';
                    $grade = 'Unhealthy';
                }

                echo "<tr class='$class'>
                        <td>{$city['city_name']}</td>
                        <td>{$city['country']}</td>
                        <td>$aqi ($grade)</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No cities selected.</td></tr>";
        }
        ?>
    </tbody>
</table>

<!-- Buttons -->
<div class="btn-container">
    <a href="selectcities.php" class="btn">⬅ Back</a>
    <!-- <form action="save_selected_cities.php" method="post" style="display:inline;">
        <button type="submit" class="btn">💾 Save</button>
    </form> -->
    <button onclick="exportTableToCSV('aqi_data.csv')" class="btn">📁 Export CSV</button>
    <button onclick="exportTableToPDF()" class="btn">📄 Export PDF</button>
</div>


<!-- Include jsPDF and autoTable from CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

<script>
function exportTableToCSV(filename) {
    let csv = [];
    const rows = document.querySelectorAll("table tr");
    
    for (let row of rows) {
        const cols = row.querySelectorAll("td, th");
        let rowData = [];
        cols.forEach(col => rowData.push(col.innerText));
        csv.push(rowData.join(","));
    }

    const blob = new Blob([csv.join("\n")], { type: "text/csv" });
    const link = document.createElement("a");
    link.download = filename;
    link.href = URL.createObjectURL(blob);
    link.click();
}

function exportTableToPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.text("Air Quality Report", 14, 15);

    doc.autoTable({
        html: 'table',
        startY: 25,
        theme: 'grid',
        styles: {
            halign: 'center'
        },
        headStyles: {
            fillColor: [108, 71, 255]
        }
    });

    doc.save("aqi_report.pdf");
}
</script>


</body>
</html>

