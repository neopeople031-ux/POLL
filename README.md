# 📊 설문조사 & 인사이트 대시보드 (POLL)

웹사이트 방문자의 피드백을 수집하고, 실시간으로 시각화된 리포트를 제공하는 경량 PHP 프로젝트입니다.

## 🚀 프로젝트 개요
* **목적:** 사용자 경험(UX) 피드백 수집 및 데이터 기반 의사결정 지원
* **버전:** 2.0 (다이나믹 그래프 추가 버전)
* **라이브 데모:** [https://almodel-list.com/POLL/](https://almodel-list.com/POLL/)

## 🛠 기술 스택
* **Backend:** PHP 7.4+
* **Database:** MySQL / MariaDB
* **Frontend:** Vanilla JS, CSS3, Google Fonts (Pretendard)
* **Visualization:** [Chart.js](https://www.chartjs.org/)
* **Security:** Prepared Statements (SQL Injection 방지), htmlspecialchars (XSS 방지)

## 📋 주요 기능
1. **설문조사 페이지 (`index.php`):** 직관적인 UI의 피드백 수집 폼
2. **관리자 로그인 (`login.php`):** 세션 기반의 안전한 접근 제어
3. **인사이트 대시보드 (`admin_view.php`):**
   * **다이나믹 추이:** 최근 7일간 응답 동향 (Line Chart)
   * **응답 분포:** 방문 경로(Doughnut), 첫인상(Bar), 편의성(Pie) 시각화
   * **핵심 지표:** 누적 응답 수, 추천 지수(NPS), 금일 유입량
   * **상세 리스트:** 개별 피드백 데이터 조회 및 필터링

## ⚙️ 설치 및 설정
1. **파일 업로드:** 웹 서버(Apache/Nginx)의 `htdocs` 하위 폴더에 프로젝트 업로드
2. **DB 설정:** `POLL_App/db_connect.php` 편집
   ```php
   $servername = "localhost";
   $username = "DB계정";
   $password = "DB비밀번호";
   $dbname = "POLL";
   $admin_password = "관리자_페이지_비밀번호";
   ```
3. **DB 자동화:** 페이지 접속 시 데이터베이스 및 테이블이 자동으로 생성됩니다.
4. **결과 확인:** `POLL/admin_view.php` 접속 후 설정한 비밀번호로 로그인

## 🧪 테스트 데이터
* `POLL_App/seed_data.php`에 접속하면 50개의 가상 샘플 데이터가 자동으로 생성되어 대시보드 시각화를 즉시 확인할 수 있습니다.

## 🔒 보안 주의사항
* `.gitignore` 파일에 `db_connect.php`와 `AWS.txt`가 포함되어 있습니다. 원격 저장소 업로드 시 비밀번호가 노출되지 않도록 주의하세요.
* 서비스 배포 시 기본 비밀번호(`admin1234`)를 반드시 변경하시기 바랍니다.
