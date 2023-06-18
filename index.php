<?php
require 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= SITE_NAME; ?> - Create Paste</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.4.0/styles/atom-one-dark.min.css">
    <style>
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
            <form class="paste-wrap" method="post" action="save.php">
                <div class="paste-head">
                    <input type="text" name="name" placeholder="Untitled Paste" autocomplete="off" required>
                    <select name="syntax">
                        <option value="text">Text</option>
                        <option value="bash">Bash</option>
                        <option value="brainfuck">Brainfuck</option>
                        <option value="c">C</option>
                        <option value="cpp">C++</option>
                        <option value="csharp">C#</option>
                        <option value="css">CSS</option>
                        <option value="dart">Dart</option>
                        <option value="go">Go</option>
                        <option value="html">HTML</option>
                        <option value="java">Java</option>
                        <option value="javascript">JavaScript</option>
                        <option value="json">JSON</option>
                        <option value="kotlin">Kotlin</option>
                        <option value="lua">Lua</option>
                        <option value="markdown">Markdown</option>
                        <option value="php">PHP</option>
                        <option value="python">Python</option>
                        <option value="ruby">Ruby</option>
                        <option value="rust">Rust</option>
                        <option value="sql">SQL</option>
                        <option value="typescript">TypeScript</option>
                    </select>

                    <div class="paste-action">
                        <button name="button" type="submit">Create Paste</button>
                    </div>
                </div>
            
                <textarea name="content" placeholder="Create a new paste..."></textarea>
            </form>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.4.0/highlight.min.js"></script>
    <script>
        hljs.highlightAll();

    
    </script>
    </body>
</html>
