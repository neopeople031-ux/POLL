<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    die("Access Denied");
}
include 'db_connect.php';

// 파일명 설정 (날짜 포함)
$filename = "설문응답_데이터_" . date('Ymd') . ".csv";

// CSV 파일 다운로드를 위한 헤더 설정
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

// 출력 스트림 열기
$output = fopen('php://output', 'w');

// 엑셀에서 한글 깨짐 방지를 위한 UTF-8 BOM 추가
fputs($output, "\xEF\xBB\xBF");

// 엑셀 상단 제목 열(Header) 작성
fputcsv($output, array('순번', '방문 경로', '기타 경로', '찾는 정보', '첫인상', '편의성', '유용한 콘텐츠', '추가 필요 기능', '기타 기능', '추천 점수', '참여 일시'));

// 데이터베이스에서 모든 응답 가져오기
$query = "SELECT * FROM responses ORDER BY created_at DESC";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, array(
        $row['id'],
        $row['q1_path'],
        $row['q1_path_other'],
        $row['q2_info'],
        $row['q3_impression'],
        $row['q4_ease'],
        $row['q5_useful_content'],
        $row['q6_features'],
        $row['q6_features_other'],
        $row['q7_score'],
        $row['created_at']
    ));
}

fclose($output);
exit;
