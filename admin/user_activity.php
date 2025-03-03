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
        <a href="javascript:history.back()" class="btn btn-secondary mb-3">
            ← Back
        </a>
        <h2 class="text-center mb-4">User Time Spent Analytics</h2>

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
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['name'] ?></td>
                        <td>
                            <button class="btn btn-primary show-graph" data-user="<?= $user['id'] ?>" data-name="<?= $user['name'] ?>">
                                Show Time Spent
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
        let userActivityChart;

        document.querySelectorAll(".show-graph").forEach(button => {
            button.addEventListener("click", function() {
                const userId = this.getAttribute("data-user");
                const userName = this.getAttribute("data-name");
                document.getElementById("chartTitle").innerText = `Time Spent by ${userName}`;

                fetch(`fetch_user_data.php?user_id=${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (userActivityChart) userActivityChart.destroy();

                        userActivityChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.weekDays, // X-axis: Short days of the week
                                datasets: [{
                                    label: "Time Spent",
                                    data: data.timeSpent, // Y-axis: Time spent in hours (numeric)
                                    backgroundColor: 'rgba(54, 162, 235, 0.6)', 
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                }]
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
                                    y: {
                                        beginAtZero: true,
                                        suggestedMax: Math.max(...data.timeSpent, 1),
                                        ticks: {
                                            stepSize: 0.5, // Every 30 minutes
                                            callback: function(value) {
                                                if (value < 1) {
                                                    return Math.round(value * 60) + " min"; // Convert <1h to minutes
                                                }
                                                return value + " h"; // Show hours
                                            }
                                        },
                                        title: {
                                            display: true,
                                            text: "Time Spent (Hours & Minutes)"
                                        }
                                    }
                                },
                                plugins: {
                                    tooltip: {
                                        callbacks: {
                                            label: function(tooltipItem) {
                                                let value = tooltipItem.raw; // Numeric time spent value
                                                let index = tooltipItem.dataIndex; // Get index of hovered bar
                                                let date = data.fullDates[index]; // Get corresponding full date (from fetch_user_data.php)

                                                // Convert hours into minutes if less than 1 hour
                                                let timeText = value < 1 ? Math.round(value * 60) + " min" : value.toFixed(2) + " h";

                                                return `${date}: ${timeText}`;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    });
            });
        });
    });
    </script>

</body>
</html>
