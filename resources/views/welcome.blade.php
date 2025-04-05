<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Central Invoice System</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
            color: #333;
            font-family: 'Poppins', sans-serif;
            text-align: center;
            overflow: hidden;
            position: relative;
        }
        .container {
            background: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 1s, transform 1s;
        }
        .container.show {
            opacity: 1;
            transform: translateY(0);
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            font-size: 20px;
            background: linear-gradient(90deg, #ff758c, #ff7eb3);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s ease, background 0.3s;
        }
        .button:hover {
            background: linear-gradient(90deg, #ff5f6d, #ffc371);
            transform: scale(1.05);
        }
        .emoji-animation {
            position: absolute;
            font-size: 60px;
            animation: moveEmoji 4s infinite alternate ease-in-out;
        }
        @keyframes moveEmoji {
            0% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(60px, -40px) rotate(15deg); }
            50% { transform: translate(-60px, 40px) rotate(-15deg); }
            75% { transform: translate(40px, 60px) rotate(10deg); }
            100% { transform: translate(-40px, -60px) rotate(-10deg); }
        }
    </style>
</head>
<body>
    <div class="emoji-animation" style="top: 10%; left: 20%;">📄</div>
    <div class="emoji-animation" style="top: 30%; left: 60%;">💰</div>
    <div class="emoji-animation" style="top: 50%; left: 10%;">🖊️</div>
    <div class="emoji-animation" style="top: 70%; left: 80%;">📊</div>
    <div class="emoji-animation" style="top: 90%; left: 50%;">💳</div>
    <div class="emoji-animation" style="top: 40%; left: 30%;">🧾</div>
    <div class="emoji-animation" style="top: 20%; left: 75%;">📂</div>
    <div class="emoji-animation" style="top: 60%; left: 15%;">💼</div>
    
    <div class="container" id="welcome-container">
        <h1>🎉 Welcome to Central Invoice System 🎉</h1>
        <p>📢 Manage Your Invoices With Ease and Efficiency 🚀</p>
        <p>📢 Its easy and very simple to use 🚀</p>
        <button class="button">✨ Get Started ✨</button>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                document.getElementById("welcome-container").classList.add("show");
            }, 1000);
        });
    </script>
</body>
</html>