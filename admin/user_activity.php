<?php
session_start();
include('connect.php');

// Fetch all registered users
$usersQuery = "SELECT id, name FROM register";
$usersResult = mysqli_query($con, $usersQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Activity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <!-- Back Button -->
        <a href="javascript:history.back()" class="btn btn-secondary mb-3">← Back</a>
        <h2 class="text-center mb-4">User Time Spent & File Uploads</h2>

        <!-- User Table -->
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = mysqli_fetch_assoc($usersResult)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td>
                            <button class="btn btn-primary show-graph" 
                                    data-user="<?= $user['id'] ?>" 
                                    data-name="<?= htmlspecialchars($user['name']) ?>">
                                Show Analytics
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Chart Section -->
        <div class="mt-4">
            <h4 id="chartTitle" class="text-center"></h4>
            <canvas id="userActivityChart"></canvas>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('userActivityChart').getContext('2d');
        let userActivityChart = null;

        document.querySelectorAll(".show-graph").forEach(button => {
            button.addEventListener("click", function() {
                const userId = this.getAttribute("data-user");
                const userName = this.getAttribute("data-name");
                document.getElementById("chartTitle").innerText = `Activity Overview for ${userName}`;

                fetch(`fetch_user_data.php?user_id=${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log("Fetched Data:", data); // Debugging

                        if (!data.weekDays || !data.timeSpent || !data.filesUploaded) {
                            alert("Error: No data available for this user.");
                            return;
                        }

                        // Destroy existing chart if exists
                        if (userActivityChart) {
                            userActivityChart.destroy();
                        }

                        userActivityChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.weekDays, // Days of the week
                                datasets: [
                                    {
                                        label: "Time Spent (Hours)",
                                        data: data.timeSpent,
                                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1,
                                        yAxisID: 'y-time' // Assign to left y-axis
                                    },
                                    {
                                        label: "Files Uploaded",
                                        data: data.filesUploaded,
                                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                                        borderColor: 'rgba(255, 99, 132, 1)',
                                        borderWidth: 1,
                                        yAxisID: 'y-files' // Assign to right y-axis
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: "Days of the Week"
                                        }
                                    },
                                    'y-time': {
                                        type: 'linear',
                                        position: 'left',
                                        beginAtZero: true,
                                        suggestedMax: Math.max(...data.timeSpent, 1),
                                        ticks: {
                                            callback: function(value) {
                                                return value < 1 ? Math.round(value * 60) + " min" : value + " h";
                                            }
                                        },
                                        title: {
                                            display: true,
                                            text: "Time Spent (Hours & Minutes)"
                                        }
                                    },
                                    'y-files': {
                                        type: 'linear',
                                        position: 'right',
                                        beginAtZero: true,
                                        suggestedMax: Math.max(...data.filesUploaded, 1),
                                        title: {
                                            display: true,
                                            text: "Files Uploaded"
                                        }
                                    }
                                },
                                plugins: {
                                    tooltip: {
                                        callbacks: {
                                            label: function(tooltipItem) {
                                                let datasetIndex = tooltipItem.datasetIndex;
                                                let value = tooltipItem.raw;
                                                let index = tooltipItem.dataIndex;
                                                let date = data.fullDates[index];

                                                if (datasetIndex === 0) { // Time spent dataset
                                                    return `${date}: ${value < 1 ? Math.round(value * 60) + " min" : value.toFixed(2) + " h"}`;
                                                } else { // Files uploaded dataset
                                                    return `${date}: ${value} files uploaded`;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => {
                        console.error("Error fetching data:", error);
                        alert("Failed to load data. Check console for details.");
                    });
            });
        });
    });
    </script>

</body>
</html>
