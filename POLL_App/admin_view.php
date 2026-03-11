<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
include 'db_connect.php';

// 데이터 요약 (시각화용)
function getSummary($conn, $column)
{
    $data = [];
    $sql = "SELECT $column, COUNT(*) as count FROM responses GROUP BY $column";
    if ($column == 'q2_info' || $column == 'q6_features') {
        // 중복 선택 항목은 별도 처리가 필요하지만, 일단 시각화를 위해 단순 그룹화만 사용
        $sql = "SELECT $column, COUNT(*) as count FROM responses GROUP BY $column";
    }
    $res = $conn->query($sql);
    while ($row = $res->fetch_assoc()) {
        $label = $row[$column] ?: '미응답';
        $data[$label] = $row['count'];
    }
    return $data;
}

$summary_path = getSummary($conn, 'q1_path');
$summary_impression = getSummary($conn, 'q3_impression');
$summary_ease = getSummary($conn, 'q4_ease');

$sql = "SELECT * FROM responses ORDER BY created_at DESC";
$result = $conn->query($sql);

// 최근 7일간 응답 추이 데이터 추출 (다이나믹 그래프용)
$trend_labels = [];
$trend_data = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $trend_labels[] = date('m/d', strtotime($date));

    $check_sql = "SELECT COUNT(*) as count FROM responses WHERE DATE(created_at) = '$date'";
    $check_res = $conn->query($check_sql);
    $trend_data[] = $check_res->fetch_assoc()['count'];
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>설문 결과 인사이트 대시보드</title>
    <link href="https://fonts.googleapis.com/css2?family=Pretendard:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #4cc9f0;
            --bg: #f8f9fa;
            --card: #ffffff;
        }

        body {
            font-family: 'Pretendard', sans-serif;
            background: var(--bg);
            color: #333;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 800;
            margin: 0;
        }

        .logout-btn {
            text-decoration: none;
            color: #666;
            font-size: 0.9rem;
            padding: 8px 16px;
            border: 1px solid #ddd;
            border-top-right-radius: 8px;
            border-radius: 8px;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background: #eee;
        }

        .stats-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--card);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .stat-card h3 {
            color: #888;
            font-size: 0.9rem;
            margin: 0 0 10px 0;
        }

        .stat-card p {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            margin: 0;
        }

        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .chart-container {
            background: var(--card);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .chart-container h2 {
            font-size: 1.1rem;
            margin-bottom: 20px;
            color: #555;
            text-align: center;
        }

        .table-section {
            background: var(--card);
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .table-section h2 {
            padding: 25px 30px;
            margin: 0;
            border-bottom: 1px solid #eee;
            font-size: 1.2rem;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #fdfdfd;
            padding: 15px 30px;
            text-align: left;
            font-size: 0.85rem;
            color: #888;
            border-bottom: 1px solid #eee;
        }

        td {
            padding: 15px 30px;
            border-bottom: 1px solid #f5f5f5;
            font-size: 0.9rem;
            color: #444;
        }

        tr:hover {
            background: #fcfcfc;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .badge-high {
            background: #e7f5ff;
            color: #1971c2;
        }

        .badge-mid {
            background: #fff4e6;
            color: #d9480f;
        }

        .badge-low {
            background: #fff5f5;
            color: #e03131;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="header">
            <h1>📊 인사이트 대시보드</h1>
            <a href="logout.php" class="logout-btn">로그아웃</a>
        </div>

        <div class="stats-summary">
            <div class="stat-card">
                <h3>누적 응답</h3>
                <p><?php echo $result->num_rows; ?>건</p>
            </div>
            <div class="stat-card">
                <h3>추천 지수 (NPS)</h3>
                <?php
                $avg_res = $conn->query("SELECT AVG(q7_score) as avg_score FROM responses");
                $avg_val = $avg_res->fetch_assoc()['avg_score'];
                ?>
                <p><?php echo number_format($avg_val, 1); ?></p>
            </div>
            <div class="stat-card">
                <h3>오늘 유입</h3>
                <p><?php
                $today_res = $conn->query("SELECT COUNT(*) as cnt FROM responses WHERE DATE(created_at) = CURDATE()");
                echo $today_res->fetch_assoc()['cnt'];
                ?>건</p>
            </div>
        </div>

        <div class="chart-container" style="margin-bottom: 30px;">
            <h2>📈 최근 7일간 응답 동향 (다이나믹)</h2>
            <div style="height: 300px;">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <div class="charts-grid">
            <div class="chart-container">
                <h2>어떤 경로로 방문했나요?</h2>
                <canvas id="pathChart"></canvas>
            </div>
            <div class="chart-container">
                <h2>첫 인상 리포트</h2>
                <canvas id="impressionChart"></canvas>
            </div>
            <div class="chart-container">
                <h2>정보 찾기 난이도</h2>
                <canvas id="easeChart"></canvas>
            </div>
        </div>

        <div class="table-section">
            <h2>상세 피드백 기록</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>방문 경로</th>
                            <th>첫인상</th>
                            <th>편의성</th>
                            <th>유용한 콘텐츠</th>
                            <th>추천 점수</th>
                            <th>참여 일시</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($row['q1_path']); ?></strong></td>
                                <td><?php echo htmlspecialchars($row['q3_impression']); ?></td>
                                <td><?php echo htmlspecialchars($row['q4_ease']); ?></td>
                                <td><?php echo htmlspecialchars(mb_strimwidth($row['q5_useful_content'], 0, 40, "...")); ?>
                                </td>
                                <td>
                                    <span
                                        class="badge <?php echo $row['q7_score'] >= 8 ? 'badge-high' : ($row['q7_score'] <= 3 ? 'badge-low' : 'badge-mid'); ?>">
                                        <?php echo $row['q7_score']; ?> / 10
                                    </span>
                                </td>
                                <td><span
                                        style="color:#bbb"><?php echo date('m-d H:i', strtotime($row['created_at'])); ?></span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const colorPalette = ['#4361ee', '#4cc9f0', '#3a0ca3', '#7209b7', '#f72585', '#b5179e'];

        // 다이나믹 응답 추이 차트 (Line Chart)
        new Chart(document.getElementById('trendChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($trend_labels); ?>,
                datasets: [{
                    label: '일별 응답 수',
                    data: <?php echo json_encode($trend_data); ?>,
                    borderColor: '#4361ee',
                    backgroundColor: 'rgba(67, 97, 238, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#4361ee',
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f0f0f0' }, ticks: { stepSize: 1 } },
                    x: { grid: { display: false } }
                }
            }
        });

        // 방문 경로 차트
        new Chart(document.getElementById('pathChart'), {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_keys($summary_path)); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_values($summary_path)); ?>,
                    backgroundColor: colorPalette
                }]
            },
            options: { plugins: { legend: { position: 'bottom' } } }
        });

        // 첫 인상 차트
        new Chart(document.getElementById('impressionChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($summary_impression)); ?>,
                datasets: [{
                    label: '응답 수',
                    data: <?php echo json_encode(array_values($summary_impression)); ?>,
                    backgroundColor: '#4361ee'
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true } }
            }
        });

        // 편의성 차트
        new Chart(document.getElementById('easeChart'), {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_keys($summary_ease)); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_values($summary_ease)); ?>,
                    backgroundColor: colorPalette
                }]
            },
            options: { plugins: { legend: { position: 'bottom' } } }
        });
    </script>
</body>

</html>
<?php $conn->close(); ?>