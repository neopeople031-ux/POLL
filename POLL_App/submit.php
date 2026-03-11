<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $q1_path = $_POST['q1_path'];
    $q1_path_other = $_POST['q1_path_other'] ?? '';

    $q2_info = isset($_POST['q2_info']) ? implode(", ", $_POST['q2_info']) : "";

    $q3_impression = $_POST['q3_impression'];
    $q4_ease = $_POST['q4_ease'];
    $q5_useful_content = $_POST['q5_useful_content'];

    $q6_features = isset($_POST['q6_features']) ? implode(", ", $_POST['q6_features']) : "";
    $q6_features_other = $_POST['q6_features_other'] ?? '';

    $q7_score = $_POST['q7_score'];

    $stmt = $conn->prepare("INSERT INTO responses (q1_path, q1_path_other, q2_info, q3_impression, q4_ease, q5_useful_content, q6_features, q6_features_other, q7_score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssi", $q1_path, $q1_path_other, $q2_info, $q3_impression, $q4_ease, $q5_useful_content, $q6_features, $q6_features_other, $q7_score);

    if ($stmt->execute()) {
        echo "<script>alert('소중한 피드백 감사합니다!'); location.href='index.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>