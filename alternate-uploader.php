<?php

$status = "";
$out = "up-backup.zip";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['url'])) {
    $url = $_POST['url'];
    $fp = fopen($out, "w");
    if ($fp) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_FILE => $fp,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => "Mozilla/5.0",
        ]);
        $ok = curl_exec($ch);
        $http = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);
        fclose($fp);
        
        if ($ok && $http == 200) {
            $status = "✅ File Saved Successfully!";
        } else {
            $status = "❌ Failed! Error Code: $http";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remote File Uploader File Manager or Cpanel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0a0c10;
            --glass: rgba(255, 255, 255, 0.03);
            --border: rgba(255, 255, 255, 0.1);
            --primary: #3b82f6;
            --accent: #2dd4bf;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: var(--bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow: hidden;
            color: white;
        }

        /* Animated Background Gradients */
        body::before {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            background: var(--primary);
            filter: blur(150px);
            top: 10%;
            left: 15%;
            z-index: -1;
            opacity: 0.3;
        }

        body::after {
            content: "";
            position: absolute;
            width: 350px;
            height: 350px;
            background: var(--accent);
            filter: blur(150px);
            bottom: 10%;
            right: 15%;
            z-index: -1;
            opacity: 0.2;
        }

        .container {
            position: relative;
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .glass-card {
            background: var(--glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 28px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        h2 {
            font-weight: 800;
            font-size: 2rem;
            margin-bottom: 10px;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p { color: #94a3b8; font-size: 0.9rem; margin-bottom: 30px; }

        .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        input {
            width: 100%;
            padding: 16px 20px;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--border);
            border-radius: 14px;
            color: white;
            font-size: 1rem;
            box-sizing: border-box;
            transition: 0.3s;
            outline: none;
        }

        input:focus {
            border-color: var(--primary);
            background: rgba(0, 0, 0, 0.4);
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.2);
        }

        button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border: none;
            border-radius: 14px;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.4s;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(59, 130, 246, 0.5);
            filter: brightness(1.1);
        }

        button:active { transform: translateY(0); }

        .status {
            margin-top: 25px;
            padding: 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.05);
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="glass-card">
        <h2> Alternate Uploader </h2>
        <p>Remote Zip file fetch & upload to file manager</p>
        
        <form method="POST">
            <div class="input-group">
                <input type="url" name="url" placeholder="https://example.com/file.zip" required>
            </div>
            <button type="submit">Start Fetching ➡️ Upload</button>
        </form>

        <?php if ($status): ?>
            <div class="status"><?php echo $status; ?></div>
        <?php endif; ?>

    </div>
</div>

</body>
</html>