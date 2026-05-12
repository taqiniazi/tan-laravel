<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to TAN Network</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #00ff88;
            --secondary: #00cc6a;
            --bg: #0a0a0a;
            --card-bg: #151515;
            --text: #ffffff;
            --text-dim: #a0a0a0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* Background Animation */
        .bg-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(0, 255, 136, 0.1) 0%, rgba(0, 0, 0, 0) 70%);
            border-radius: 50%;
            filter: blur(80px);
            z-index: 1;
            animation: pulse 10s infinite alternate;
        }

        @keyframes pulse {
            0% { transform: translate(-30%, -30%) scale(1); }
            100% { transform: translate(30%, 30%) scale(1.2); }
        }

        .container {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 800px;
            padding: 2rem;
        }

        .logo-container {
            margin-bottom: 2.5rem;
            animation: fadeInDown 1s ease-out;
            display: flex;
            justify-content: center;
        }

        .logo-img {
            max-width: 250px;
            width:100%;
            height: auto;
            filter: drop-shadow(0 0 20px rgba(0, 255, 136, 0.3));
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(to bottom, #fff, #888);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -1px;
        }

        p {
            font-size: 1.25rem;
            color: var(--text-dim);
            margin-bottom: 3rem;
            line-height: 1.6;
        }

        .actions {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 1rem 2.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1.1rem;
            display: inline-block;
        }

        .btn-primary {
            background-color: var(--primary);
            color: #000;
            box-shadow: 0 10px 20px rgba(0, 255, 136, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(0, 255, 136, 0.3);
            background-color: #fff;
        }

        .btn-secondary {
            background-color: rgba(255, 255, 255, 0.05);
            color: var(--text);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .btn-secondary:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
        }

        .status-badge {
            margin-top: 4rem;
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background-color: rgba(0, 255, 136, 0.1);
            border-radius: 50px;
            border: 1px solid rgba(0, 255, 136, 0.2);
            color: var(--primary);
            font-size: 0.85rem;
            font-weight: 600;
            gap: 0.5rem;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background-color: var(--primary);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--primary);
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0% { opacity: 0.5; }
            50% { opacity: 1; }
            100% { opacity: 0.5; }
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .version {
            position: absolute;
            bottom: 2rem;
            color: rgba(255, 255, 255, 0.3);
            font-size: 0.8rem;
        }

        @media (max-width: 600px) {
            h1 { font-size: 2.5rem; }
            .btn { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="bg-glow"></div>
    
    <div class="container">
        <div class="logo-container">
            <img src="{{ asset('logo.png') }}" alt="TAN Network Logo" class="logo-img">
        </div>
        
        <h1>Welcome to TAN Network</h1>
        <p>The next generation decentralized infrastructure for high-performance blockchain operations and automated rewards.</p>
      
        
        <div class="status-badge">
            <div class="status-dot"></div>
            Laravel Backend Operational
        </div>
    </div>

    <div class="version">
        TAN Network v1.0.0 &bull; Laravel v{{ Illuminate\Foundation\Application::VERSION }}
    </div>
</body>
</html>
