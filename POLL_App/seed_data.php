<?php
include 'db_connect.php';

$paths = ["검색 엔진", "SNS", "지인 추천", "포트폴리오/작품 링크", "우연히 발견"];
$infos = ["바이브 코딩 학습 자료", "디자인/일러스트 작품", "강의/워크샵 정보", "교수/전문가 프로필", "프로젝트 협업 문의", "그냥 둘러보기"];
$impressions = ["매우 인상적", "깔끔/전문적", "평범/무난", "약간 혼란", "개선 필요"];
$eases = ["매우 쉬움", "쉬움", "보통", "어려움", "찾지 못함"];
$features = ["온라인 코딩 에디터", "강의 신청 시스템", "커뮤니티 기능", "작품 다운로드/공유", "뉴스레터 구독"];

$useful_comments = [
    "바이브 코딩 튜토리얼이 정말 직관적이라 초보자에게 큰 도움이 되었습니다.",
    "포트폴리오 갤러리의 작품들이 너무 멋져요. 영감을 많이 받고 갑니다!",
    "강의 정보가 깔끔하게 정리되어 있어서 신청하고 싶어지네요.",
    "전체적인 사이트 톤앤매너가 너무 고급스럽고 보기 편합니다.",
    "블로그에 올라온 디자인 팁들이 실무에서 바로 쓸 수 있을 정도로 유용해요.",
    "교수님 프로필을 보니 신뢰가 팍팍 갑니다. 협업 문의 드리고 싶어요.",
    "작품들의 퀄리티가 대단하네요. 특히 일러스트 섹션이 인상 깊었습니다.",
    "코딩 학습 로드맵이 잘 짜여 있어서 공부 방향 잡기에 좋네요.",
    "사이트가 가벼워서 모바일로 봐도 로딩이 정말 빨라요.",
    "디자인과 기술이 잘 조화된 느낌입니다. 주기적으로 방문할게요!"
];

for ($i = 0; $i < 50; $i++) {
    $q1 = $paths[array_rand($paths)];
    $q1_other = ($q1 == "기타") ? "블로그 링크" : "";

    $info_count = rand(1, 3);
    $selected_infos = array_rand(array_flip($infos), $info_count);
    $q2 = is_array($selected_infos) ? implode(", ", $selected_infos) : $selected_infos;

    $q3 = $impressions[array_rand($impressions)];
    $q4 = $eases[array_rand($eases)];
    $q5 = $useful_comments[array_rand($useful_comments)];

    $feat_count = rand(1, 2);
    $selected_feats = array_rand(array_flip($features), $feat_count);
    $q6 = is_array($selected_feats) ? implode(", ", $selected_feats) : $selected_feats;
    $q6_other = "";

    // 점수는 대체로 7~10점 사이로 (긍정적인 데이터)
    $q7 = (rand(1, 10) > 3) ? rand(7, 10) : rand(0, 6);

    $stmt = $conn->prepare("INSERT INTO responses (q1_path, q1_path_other, q2_info, q3_impression, q4_ease, q5_useful_content, q6_features, q6_features_other, q7_score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssi", $q1, $q1_other, $q2, $q3, $q4, $q5, $q6, $q6_other, $q7);
    $stmt->execute();
}

echo "50개의 샘플 데이터 입력 완료!";
$conn->close();
?>