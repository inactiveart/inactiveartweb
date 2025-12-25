<?php
/**
 * @architect    Inactiveart (System Architect & UI Engineer)
 * @project      Inactiveart Official Portfolio (V1.0)
 * @copyright    2025 Inactiveart. All rights reserved.
 * @description  Admin panel for portfolio content management.
 */

require_once 'auth.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
}


$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Güvenlik Hatası: Geçersiz İstek (CSRF Token Mismatch)');
    }
    if (login($_POST['username'], $_POST['password'])) {
        header("Location: admin.php");
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}


if (isAuthenticated() && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Güvenlik Hatası: Geçersiz İstek (CSRF Token Mismatch)');
    }
    $data = json_decode(file_get_contents('data.json'), true);
    $needsSave = false;

    if (isset($_POST['add_project'])) {
        $categoryKey = $_POST['category_key'];
        $title = $_POST['project_title'];

        if (isset($_FILES['project_image']) && $_FILES['project_image']['error'] === UPLOAD_ERR_OK) {

            $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            $fileInfo = pathinfo($_FILES['project_image']['name']);
            $ext = strtolower($fileInfo['extension'] ?? '');

            $checkImage = getimagesize($_FILES['project_image']['tmp_name']);

            if (!in_array($ext, $allowedExts)) {
                $error = "GÜVENLİK UYARISI: Sadece JPG, PNG, GIF veya WEBP formatında resim yükleyebilirsiniz.";
            } elseif ($checkImage === false) {
                $error = "GÜVENLİK UYARISI: Yüklenen dosya geçerli bir resim dosyası değil.";
            } else {
                $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '', basename($_FILES['project_image']['name']));
                $name = time() . '_' . $safeName;
                $target = "assets/img/" . $name;

                if (move_uploaded_file($_FILES['project_image']['tmp_name'], $target)) {

                    $newItem = [
                        "id" => time(),
                        "title" => $title,
                        "img" => $target
                    ];

                    if (!isset($data['portfolio'][$categoryKey]['items']) || !is_array($data['portfolio'][$categoryKey]['items'])) {
                        $data['portfolio'][$categoryKey]['items'] = [];
                    }

                    $data['portfolio'][$categoryKey]['items'][] = $newItem;
                    $needsSave = true;
                    $message = "Proje ve görsel güvenli bir şekilde eklendi.";
                } else {
                    $error = "Dosya sunucuya taşınırken bir hata oluştu.";
                }
            }
        } elseif (isset($_FILES['project_image']) && $_FILES['project_image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $error = "Dosya yükleme hatası oluştu. Kod: " . $_FILES['project_image']['error'];
        }
    }


    if (isset($_POST['delete_project'])) {
        $categoryKey = $_POST['category_key'];
        $projectId = $_POST['project_id'];

        $newItems = array_filter($data['portfolio'][$categoryKey]['items'], function ($item) use ($projectId) {
            return $item['id'] != $projectId;
        });

        $data['portfolio'][$categoryKey]['items'] = array_values($newItems);
        $needsSave = true;
        $message = "Project deleted.";
    }


    if (isset($_POST['save_general'])) {
        $data['meta']['motto'] = $_POST['motto'];

        $data['philosophy']['title'] = $_POST['phil_title'];
        $data['philosophy']['content'] = $_POST['phil_content'];

        $data['social']['x'] = $_POST['social_x'];
        $data['social']['instagram'] = $_POST['social_instagram'];
        $data['social']['github'] = $_POST['social_github'];

        $needsSave = true;
        $message = "General settings saved.";
    }

    if ($needsSave) {
        file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

if (!isAuthenticated()) {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Inactive Access</title>
        <style>
            :root {
                --bg: #0a0a0a;
                --text: #ededed;
            }

            body {
                background: var(--bg);
                color: var(--text);
                font-family: 'Courier New', sans-serif;
                display: flex;
                height: 100vh;
                justify-content: center;
                align-items: center;
            }

            form {
                display: flex;
                flex-direction: column;
                gap: 1rem;
                width: 300px;
            }

            input {
                background: #111;
                border: 1px solid #333;
                color: white;
                padding: 1rem;
            }

            button {
                background: white;
                color: black;
                border: none;
                padding: 1rem;
                cursor: pointer;
                font-weight: bold;
            }
        </style>
    </head>

    <body style="flex-direction:column">
        <h2>// SYSTEM LOCKED</h2>
        <?php if ($error)
            echo "<p style='color:red'>$error</p>"; ?>
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="text" name="username" placeholder="USER" required>
            <input type="password" name="password" placeholder="PASS" required>
            <button type="submit" name="login">UNLOCK</button>
        </form>
    </body>

    </html>
    <?php
    exit;
}


$data = json_decode(file_get_contents('data.json'), true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Inactive Admin | System Control</title>
    <meta name="author" content="Inactiveart Systems">
    <meta name="copyright" content="Inactiveart © 2025">
    <meta name="generator" content="Inactiveart Core Engine">
    <style>
        :root {
            --bg: #0a0a0a;
            --text: #ededed;
            --border: #222;
            --accent: #3b82f6;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 40px;
        }

        h1,
        h2,
        h3 {
            font-weight: 300;
        }

        a {
            color: var(--accent);
            text-decoration: none;
        }

        .header {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid var(--border);
            padding-bottom: 20px;
            margin-bottom: 40px;
        }

        .section {
            margin-bottom: 50px;
            padding: 20px;
            border: 1px solid var(--border);
            border-radius: 8px;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            opacity: 0.6;
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        input[type="text"],
        textarea {
            width: 100%;
            background: #111;
            border: 1px solid #333;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            font-family: inherit;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        button {
            background: #ededed;
            color: #000;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }

        button.delete {
            background: #ef4444;
            color: white;
            font-size: 0.8rem;
            padding: 5px 10px;
        }

        .admin-card {
            background: #111;
            padding: 10px;
            border-radius: 4px;
        }

        .admin-card img {
            width: 100%;
            aspect-ratio: 16/9;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .admin-card h4 {
            margin: 0 0 10px 0;
            font-size: 0.9rem;
        }

        .cat-header {
            border-left: 3px solid var(--accent);
            padding-left: 15px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Admin Control</h1>
        <nav>
            <a href="index.php" target="_blank">View Site -></a> |
            <a href="?action=logout">Logout</a>
        </nav>
    </div>

    <?php if (isset($error) && $error): ?>
        <div style="background: #ef4444; color: white; padding: 15px; margin-bottom: 30px; border-radius: 4px;">
            Error: <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($message) && $message): ?>
        <div style="background: #22c55e; color: white; padding: 15px; margin-bottom: 30px; border-radius: 4px;">
            Success: <?php echo $message; ?>
        </div>
    <?php endif; ?>

        <div class="section">
        <h2>General Content</h2>
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <label>Motto</label>
            <input type="text" name="motto" value="<?php echo htmlspecialchars($data['meta']['motto']); ?>">

            <label>Philosophy Title</label>
            <input type="text" name="phil_title" value="<?php echo htmlspecialchars($data['philosophy']['title']); ?>">

            <label>Philosophy Text</label>
            <textarea name="phil_content"><?php echo htmlspecialchars($data['philosophy']['content']); ?></textarea>

            <div style="margin: 30px 0; border-top: 1px solid #333; padding-top: 20px;">
                <h3 style="margin-top:0">Social Connections</h3>

                <label>X (Twitter) URL</label>
                <input type="text" name="social_x" value="<?php echo htmlspecialchars($data['social']['x'] ?? ''); ?>"
                    placeholder="https://x.com/username">

                <label>Instagram URL</label>
                <input type="text" name="social_instagram"
                    value="<?php echo htmlspecialchars($data['social']['instagram'] ?? ''); ?>"
                    placeholder="https://instagram.com/username">

                <label>GitHub URL</label>
                <input type="text" name="social_github"
                    value="<?php echo htmlspecialchars($data['social']['github'] ?? ''); ?>"
                    placeholder="https://github.com/username">
            </div>

            <button type="submit" name="save_general">SAVE TEXT</button>
        </form>
    </div>

        <div class="section">
        <h2>Portfolio Management</h2>

        <?php foreach ($data['portfolio'] as $catKey => $category): ?>
            <div style="margin-bottom: 4rem;">
                <div class="cat-header">
                    <h3><?php echo $category['title_en']; ?> <span style="opacity:0.5; font-size:0.8em">/
                            <?php echo $category['title_tr']; ?></span></h3>
                    <small style="color:var(--accent)"><?php echo $category['desc']; ?></small>
                </div>

                <form method="POST" enctype="multipart/form-data"
                    style="margin-bottom: 20px; background: #161616; padding: 15px;">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="category_key" value="<?php echo $catKey; ?>">
                    <input type="hidden" name="add_project" value="1">

                    <div class="row">
                        <div>
                            <label>New Project Title</label>
                            <input type="text" name="project_title" required>
                        </div>
                        <div>
                            <label>Project Image</label>
                            <input type="file" name="project_image" required style="color: white;">
                        </div>
                    </div>
                    <button type="submit">+ ADD TO <?php echo $category['title_en']; ?></button>
                </form>

                <div class="admin-grid">
                    <?php if (isset($category['items'])):
                        foreach ($category['items'] as $item): ?>
                            <div class="admin-card">
                                <img src="<?php echo $item['img']; ?>">
                                <h4><?php echo $item['title']; ?></h4>

                                <form method="POST" onsubmit="return confirm('Are you sure?');">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <input type="hidden" name="category_key" value="<?php echo $catKey; ?>">
                                    <input type="hidden" name="project_id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" name="delete_project" class="delete">DELETE</button>
                                </form>
                            </div>
                        <?php endforeach; endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>

</html>