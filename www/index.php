<?php
$ROOT_PATH = "/data/data/com.termux/files/home/www";
$PHONEBOOK = "$ROOT_PATH/phonebook/phonebook";

function run_command($cmd) {
    global $PHONEBOOK;
    return shell_exec("$PHONEBOOK $cmd 2>&1");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'add':
            $name = escapeshellarg($_POST['name']);
            $phone = escapeshellarg($_POST['phone']);
            echo run_command("add $name $phone");
            break;

        case 'search':
            $query = escapeshellarg($_POST['query']);
            echo run_command("search $query");
            break;

        case 'edit':
            $name = escapeshellarg($_POST['name']);
            $phone = escapeshellarg($_POST['phone']);
            echo run_command("edit $name $phone");
            break;

        case 'delete':
            $name = escapeshellarg($_POST['name']);
            echo run_command("delete $name");
            break;
    }
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Phonebook Web Interface</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --success: #4cc9f0;
            --danger: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        h1 {
            color: var(--primary);
            text-align: center;
            margin-bottom: 30px;
        }
        
        h2 {
            color: var(--primary);
            font-size: 1.3rem;
            margin-top: 0;
            border-bottom: 2px solid var(--primary);
            padding-bottom: 8px;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 25px;
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border 0.3s;
        }
        
        input[type="text"]:focus {
            border-color: var(--primary);
            outline: none;
        }
        
        button {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: #3a56d4;
        }
        
        .delete-btn {
            background-color: var(--danger);
        }
        
        .delete-btn:hover {
            background-color: #e5177e;
        }
        
        pre {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid var(--primary);
            overflow-x: auto;
        }
        
        .icon {
            margin-right: 8px;
        }
        
        /* SweetAlert-like notification */
        .alert-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }
        
        .alert-box {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            max-width: 400px;
            width: 90%;
            text-align: center;
            transform: translateY(20px);
            transition: transform 0.3s;
        }
        
        .alert-box.success {
            border-top: 4px solid var(--success);
        }
        
        .alert-box.error {
            border-top: 4px solid var(--danger);
        }
        
        .alert-box.show {
            transform: translateY(0);
        }
        
        .alert-overlay.show {
            opacity: 1;
            pointer-events: all;
        }
        
        .alert-title {
            font-size: 1.3rem;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .alert-message {
            margin-bottom: 20px;
            line-height: 1.5;
        }
        
        .alert-btn {
            padding: 8px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: 500;
        }
        
        .alert-btn.success {
            background-color: var(--success);
            color: white;
        }
        
        .alert-btn.error {
            background-color: var(--danger);
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <h1><i class="fas fa-address-book icon"></i>Phonebook Manager</h1>

    <!-- Add Contact Form -->
    <div class="card">
        <h2><i class="fas fa-user-plus icon"></i>Add Contact</h2>
        <form method="POST">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <input type="text" name="name" placeholder="Name" required>
            </div>
            <div class="form-group">
                <input type="text" name="phone" placeholder="Phone (10 digits)" required pattern="\d{10}" title="10 digit phone number">
            </div>
            <button type="submit"><i class="fas fa-save icon"></i>Add</button>
        </form>
    </div>

    <!-- Search Form -->
    <div class="card">
        <h2><i class="fas fa-search icon"></i>Search</h2>
        <form method="POST">
            <input type="hidden" name="action" value="search">
            <div class="form-group">
                <input type="text" name="query" placeholder="Name or Phone" required>
            </div>
            <button type="submit"><i class="fas fa-search icon"></i>Search</button>
        </form>
    </div>

    <!-- Edit Contact Form -->
    <div class="card">
        <h2><i class="fas fa-edit icon"></i>Edit Contact</h2>
        <form method="POST">
            <input type="hidden" name="action" value="edit">
            <div class="form-group">
                <input type="text" name="name" placeholder="Existing Name" required>
            </div>
            <div class="form-group">
                <input type="text" name="phone" placeholder="New Phone (10 digits)" required pattern="\d{10}" title="10 digit phone number">
            </div>
            <button type="submit"><i class="fas fa-edit icon"></i>Edit</button>
        </form>
    </div>

    <!-- Delete Contact Form -->
    <div class="card">
        <h2><i class="fas fa-trash-alt icon"></i>Delete Contact</h2>
        <form method="POST" id="deleteForm">
            <input type="hidden" name="action" value="delete">
            <div class="form-group">
                <input type="text" name="name" placeholder="Name to Delete" required>
            </div>
            <button type="submit" class="delete-btn"><i class="fas fa-trash-alt icon"></i>Delete</button>
        </form>
    </div>

    <!-- List of all contacts -->
    <div class="card">
        <h2><i class="fas fa-list icon"></i>All Contacts</h2>
        <pre><?= htmlspecialchars(run_command("list")) ?></pre>
    </div>
</div>

<!-- Alert Box -->
<div class="alert-overlay" id="alertOverlay">
    <div class="alert-box" id="alertBox">
        <div class="alert-title" id="alertTitle"></div>
        <div class="alert-message" id="alertMessage"></div>
        <button class="alert-btn" id="alertBtn">OK</button>
    </div>
</div>

<script>
// Custom alert function
function showAlert(title, message, isSuccess) {
    const overlay = document.getElementById('alertOverlay');
    const box = document.getElementById('alertBox');
    const alertTitle = document.getElementById('alertTitle');
    const alertMessage = document.getElementById('alertMessage');
    const alertBtn = document.getElementById('alertBtn');
    
    alertTitle.textContent = title;
    alertMessage.textContent = message;
    
    box.className = isSuccess ? 'alert-box success' : 'alert-box error';
    alertBtn.className = isSuccess ? 'alert-btn success' : 'alert-btn error';
    
    overlay.classList.add('show');
    box.classList.add('show');
    
    alertBtn.onclick = function() {
        overlay.classList.remove('show');
        box.classList.remove('show');
        if (isSuccess) {
            location.reload();
        }
    };
}

// Handle form submissions
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        
        // Special confirmation for delete
        if (form.id === 'deleteForm') {
            const name = formData.get('name');
            if (!confirm(`Are you sure you want to delete "${name}"?`)) {
                return;
            }
        }
        
        try {
            const response = await fetch('', {
                method: 'POST',
                body: formData
            });
            const result = await response.text();
            
            if (result.startsWith("ERROR")) {
                showAlert("Error", result, false);
            } else {
                showAlert("Success", result, true);
            }
        } catch (error) {
            showAlert("Error", "An error occurred while processing your request", false);
        }
    });
});
</script>
</body>
</html>
