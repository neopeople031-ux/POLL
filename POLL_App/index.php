<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>홈페이지 방문 피드백</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pretendard:wght@400;600;800&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <header>
            <h1>홈페이지 방문 피드백</h1>
            <p>소중한 시간 내어 피드백 주셔서 감사합니다. 여러분의 의견은 더 나은 사이트를 만드는 데 큰 도움이 됩니다.</p>
        </header>

        <form action="submit.php" method="POST">
            <!-- Question 1 -->
            <section class="question-box">
                <label class="question-title">1. 어떤 경로로 이 사이트를 방문하셨나요?</label>
                <div class="options">
                    <label class="option"><input type="radio" name="q1_path" value="검색 엔진" required> <span>검색 엔진
                            (Google, Naver 등)</span></label>
                    <label class="option"><input type="radio" name="q1_path" value="SNS"> <span>SNS (Instagram, Facebook
                            등)</span></label>
                    <label class="option"><input type="radio" name="q1_path" value="지인 추천"> <span>지인 추천</span></label>
                    <label class="option"><input type="radio" name="q1_path" value="포트폴리오/작품 링크"> <span>포트폴리오/작품
                            링크</span></label>
                    <label class="option"><input type="radio" name="q1_path" value="우연히 발견"> <span>우연히 발견</span></label>
                    <label class="option"><input type="radio" name="q1_path" value="기타"> <span>기타:</span> <input
                            type="text" name="q1_path_other" placeholder="직접 입력"></label>
                </div>
            </section>

            <!-- Question 2 -->
            <section class="question-box">
                <label class="question-title">2. 어떤 정보를 찾으러 오셨나요? (중복 선택 가능)</label>
                <div class="optionsGrid">
                    <label class="option"><input type="checkbox" name="q2_info[]" value="바이브 코딩 학습 자료"> <span>바이브 코딩 학습
                            자료</span></label>
                    <label class="option"><input type="checkbox" name="q2_info[]" value="디자인/일러스트 작품"> <span>디자인/일러스트
                            작품</span></label>
                    <label class="option"><input type="checkbox" name="q2_info[]" value="강의/워크샵 정보"> <span>강의/워크샵
                            정보</span></label>
                    <label class="option"><input type="checkbox" name="q2_info[]" value="교수/전문가 프로필"> <span>교수/전문가
                            프로필</span></label>
                    <label class="option"><input type="checkbox" name="q2_info[]" value="프로젝트 협업 문의"> <span>프로젝트 협업
                            문의</span></label>
                    <label class="option"><input type="checkbox" name="q2_info[]" value="그냥 둘러보기"> <span>그냥
                            둘러보기</span></label>
                </div>
            </section>

            <!-- Question 3 -->
            <section class="question-box">
                <label class="question-title">3. 사이트의 첫인상은 어떠셨나요?</label>
                <div class="options horizontal">
                    <label class="option emoji-option"><input type="radio" name="q3_impression" value="매우 인상적" required>
                        <div class="card"><span>😍</span>
                            <p>매우 인상적</p>
                        </div>
                    </label>
                    <label class="option emoji-option"><input type="radio" name="q3_impression" value="깔끔/전문적">
                        <div class="card"><span>😊</span>
                            <p>깔끔/전문적</p>
                        </div>
                    </label>
                    <label class="option emoji-option"><input type="radio" name="q3_impression" value="평범/무난">
                        <div class="card"><span>😐</span>
                            <p>평범/무난</p>
                        </div>
                    </label>
                    <label class="option emoji-option"><input type="radio" name="q3_impression" value="약간 혼란">
                        <div class="card"><span>😕</span>
                            <p>약간 혼란</p>
                        </div>
                    </label>
                    <label class="option emoji-option"><input type="radio" name="q3_impression" value="개선 필요">
                        <div class="card"><span>😞</span>
                            <p>개선 필요</p>
                        </div>
                    </label>
                </div>
            </section>

            <!-- Question 4 -->
            <section class="question-box">
                <label class="question-title">4. 원하는 정보를 찾기 쉬웠나요?</label>
                <div class="options">
                    <label class="option"><input type="radio" name="q4_ease" value="매우 쉬움" required> <span>매우 쉬웠다
                            (직관적)</span></label>
                    <label class="option"><input type="radio" name="q4_ease" value="쉬움"> <span>쉬웠다 (조금 탐색
                            필요)</span></label>
                    <label class="option"><input type="radio" name="q4_ease" value="보통"> <span>보통이다</span></label>
                    <label class="option"><input type="radio" name="q4_ease" value="어려움"> <span>어려웠다 (구조 파악
                            힘듦)</span></label>
                    <label class="option"><input type="radio" name="q4_ease" value="찾지 못함"> <span>찾지 못했다</span></label>
                </div>
            </section>

            <!-- Question 5 -->
            <section class="question-box">
                <label class="question-title">5. 가장 인상 깊었거나 유용했던 콘텐츠는?</label>
                <p class="desc">예: 바이브 코딩 튜토리얼, 프로젝트 갤러리, 블로그 글 제목 등</p>
                <textarea name="q5_useful_content" placeholder="의견을 남겨주세요..."></textarea>
            </section>

            <!-- Question 6 -->
            <section class="question-box">
                <label class="question-title">6. 추가되었으면 하는 기능이나 콘텐츠는?</label>
                <div class="optionsGrid">
                    <label class="option"><input type="checkbox" name="q6_features[]" value="온라인 코딩 에디터"> <span>온라인 코딩
                            에디터</span></label>
                    <label class="option"><input type="checkbox" name="q6_features[]" value="강의 신청 시스템"> <span>강의 신청
                            시스템</span></label>
                    <label class="option"><input type="checkbox" name="q6_features[]" value="커뮤니티 기능"> <span>커뮤니티
                            기능</span></label>
                    <label class="option"><input type="checkbox" name="q6_features[]" value="작품 다운로드/공유"> <span>작품
                            다운로드/공유</span></label>
                    <label class="option"><input type="checkbox" name="q6_features[]" value="뉴스레터 구독"> <span>뉴스레터
                            구독</span></label>
                    <label class="option"><input type="radio" name="q6_features[]" value="기타"> <span>기타:</span> <input
                            type="text" name="q6_features_other" placeholder="직접 입력"></label>
                </div>
            </section>

            <!-- Question 7 -->
            <section class="question-box">
                <label class="question-title">7. 이 사이트를 추천하실 의향이 있나요?</label>
                <p class="desc">0(전혀 아님) ~ 10(적극 추천)</p>
                <div class="score-range">
                    <?php for ($i = 0; $i <= 10; $i++): ?>
                        <label class="score-item">
                            <input type="radio" name="q7_score" value="<?php echo $i; ?>" required>
                            <span>
                                <?php echo $i; ?>
                            </span>
                        </label>
                    <?php endfor; ?>
                </div>
            </section>

            <div class="submit-area">
                <button type="submit" class="btn-submit">피드백 제출하기</button>
            </div>
        </form>

        <footer>
            <p>🙏 감사합니다! 소중한 피드백은 사이트 개선에 직접 반영됩니다.</p>
            <p>문의: <a href="mailto:jvisualschool@gmail.com">jvisualschool@gmail.com</a> | 웹사이트: <a
                    href="https://jvibeschool.net/" target="_blank">jvibeschool.net</a></p>
        </footer>
    </div>
</body>

</html>