<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


require 'config.php';

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the paste content and syntax based on the ID from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT content, syntax FROM pastes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($content, $syntax);

    if ($stmt->fetch()) {
        $stmt->close();
        $conn->close();
    } else {
        echo "Paste not found.";
        $stmt->close();
        $conn->close();
        exit;
    }
} else {
    echo "Invalid request.";
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= SITE_NAME; ?> - View Paste</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.4.0/styles/atom-one-dark.min.css">
    <style>
    .copy-btn {
            margin-bottom: 10px;
        }
* {
    margin: 0;
    padding: 0;
    font-family: "Montserrat", sans-serif;
}

::-webkit-scrollbar {
    width: 10px;
    height: 10px;
}

::-webkit-scrollbar-track {
    background-color: #323232;
}

::-webkit-scrollbar-thumb {
    background-color: purple;
    border-radius: 15px;
}

a {
    color: #fff;
    text-decoration: none;
}

body {
    background-color: #242424;
    color: #fff;
}

.container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
}

.top-nav {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background-color: #323232;
    border-bottom: 1px solid #4a4a4a;
    height: 60px;
    z-index: 50;
}

.top-nav .container {
    display: flex;
    flex-direction: row;
    align-items: center;
    height: 100%;
}

.top-nav-logo {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
}

.top-nav-logo img {
    display: block;
    width: 100%;
    max-height: 30px;
    max-width: 170px;
}

.top-nav-links {
    margin-left: auto;
    display: flex;
    flex-direction: row;
    align-items: center;
}

.top-nav-links a {
    font-size: 17px;
    font-weight: 500;
    margin-right: 20px;
    color: #b5b5b5;
}

.top-nav-links a:last-child {
    margin-right: 0;
}

.top-nav-holder {
    width: 100%;
    height: 60px;
}

.page-title {
    margin-top: 40px;
    text-align: center;
    position: relative;
    color: #d7d7d7;
    font-size: 30px;
    font-weight: 600;
}

.page-title::after {
    content: "";
    height: 1px;
    width: 100%;
    max-width: 400px;
    background-color: purple;
    bottom: -9px;
    left: 50%;
    transform: translateX(-50%);
    position: absolute;
}

.page-overview {
    max-width: 500px;
    font-size: 15px;
    margin-top: 18px;
    text-align: center;
    color: #b5b5b5;
}

.paste-wrap {
    margin-top: 30px;
}

.paste-head {
    display: flex;
    flex-direction: row;
    align-items: center;
    padding-bottom: 20px;
}

.paste-head input {
    background-color: rgba(0, 0, 0, 0);
    border: 1px solid #4a4a4a;
    border-radius: 5px;
    color: #b5b5b5;
    outline: none;
    padding: 8px 10px;
    font-size: 14px;
}

.paste-head select {
    margin-left: 10px;
    background-color: rgba(0, 0, 0, 0);
    border: 1px solid #4a4a4a;
    border-radius: 5px;
    color: #b5b5b5;
    outline: none;
    padding: 7px 9px;
    font-size: 14px;
}

.paste-head option {
    background-color: #323232;
    color: #fff;
}

.paste-head .paste-action {
    margin-left: auto;
}

.paste-action button {
    cursor: pointer;
    background-color: purple;
    border: 1px solid purple;
    border-radius: 5px;
    font-size: 15px;
    font-weight: 500;
    color: #d7d7d7;
    padding: 6px 11px;
}

.paste-action button.alt {
    margin-right: 5px;
    background-color: rgba(0, 0, 0, 0);
    color: purple;
    font-size: 14px;
    font-weight: 600;
    padding: 7px 12px;
}

.paste-alert {
    display: flex;
    flex-direction: row;
    align-items: center;
    border-radius: 5px;
    background-color: purple;
    margin-bottom: 20px;
    padding: 8px 12px;
    font-size: 15px;
    font-weight: 500;
    color: #d7d7d7;
}

.paste-alert.alert-error {
    background-color: purple;
}

.paste-wrap textarea {
    width: calc(100% - 20px);
    min-height: 50vh;
    max-height: 70vh;
    border-radius: 5px;
    background-color: #323232;
    border: 1px solid #4a4a4a;
    padding: 10px;
    font-size: 13.5px;
    color: #b5b5b5;
    outline: none;
    resize: vertical;
}

.paste-wrap pre {
    min-height: 50vh;
    max-height: 70vh;
    border-radius: 5px;
    background-color: #323232;
    border: 1px solid #4a4a4a;
    padding: 10px 5px 5px 15px;
    font-size: 13.5px;
    overflow: auto;
}

.paste-wrap pre::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.paste-wrap code {
    background-color: rgba(0, 0, 0, 0);
    padding: 0 !important;
    overflow-x: visible !important;
}

.paste-wrap code * {
    font-family: monospace;
}

.paste-wrap code .hljs-ln-numbers {
    padding-right: 5px;
    min-width: 15px;
    border-right: 1px solid #4a4a4a;
    text-align: left;
    font-size: 13px;
    color: #b5b5b5;
}

.paste-wrap code .hljs-ln-code {
    padding-left: 10px;
}

footer {
    margin-top: 40px !important;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    padding-bottom: 20px !important;
}

footer p {
    text-align: center;
    font-size: 13px;
    color: #b5b5b5;
    font-weight: 500;
}

        </style>
</head>
<body>
<div class="container">
            <center>
                <h1 class="page-title">Create New Paste</h1>
                <p class="page-overview">Store large code & text online and share with the world.</p>
            </center>
            <div class="paste-wrap">
            <?php if($syntax === "text"): ?>
                    <textarea name="content" readonly><?= $content; ?></textarea>
                <?php else: ?>
                    <pre><code class="language-<?= $syntax; ?>"><?= htmlspecialchars($content); ?></code></pre>
                <?php endif; ?>
                <div class="paste-action">
                        <button name="button" onclick="copyCode()">Copy Code</button>
                    </div>
        </div>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.4.0/highlight.min.js"></script>
    <script>
        hljs.highlightAll();

        function copyCode() {
            var codeElement = document.querySelector('code');
            var range = document.createRange();
            range.selectNode(codeElement);
            window.getSelection().addRange(range);
            document.execCommand('copy');
            window.getSelection().removeAllRanges();
        }
    </script>
</body>
</html>
