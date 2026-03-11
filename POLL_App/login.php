<?php
session_start();
include 'db_connect.php';

if (isset($_POST['password'])) {
    if ($_POST['password'] === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_view.php");
        exit;
    } else {
        $error = "비밀번호가 틀렸습니다.";
    }
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>관리자 로그인</title>
    <link href="https://fonts.googleapis.com/css2?family=Pretendard:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Pretendard', sans-serif;
            background: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-card {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 360px;
            text-align: center;
        }

        h1 {
            font-size: 1.5rem;
            margin-bottom: 24px;
            color: #333;
        }

        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #4361ee;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        button:hover {
            background: #3a0ca3;
        }

        .error {
            color: #e03131;
            font-size: 0.9rem;
            margin-bottom: 16px;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <h1>🔐 관리자 로그인</h1>
        <?php if (isset($error)): ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <input type="password" name="password" placeholder="비밀번호를 입력하세요" required autofocus>
            <button type="submit">입장하기</button>
        </form>
    </div>
</body>

</html>