# 📞 Phonebook Manager (CLI + Web Interface)

A simple contact management application with both CLI and web interface support.  
Supports **Add**, **Search**, **Edit**, **Delete**, and **List** contacts. Data is stored in a file using binary tree logic.

---

## ✅ Features

- Add/Search/Edit/Delete/List contacts
- CLI and browser interface
- Works on Android (Termux), Ubuntu/Linux, and Windows (WSL)
- Simple C backend with PHP frontend

---

## 📁 File Structure

```
www/
├── index.php               # Web frontend
├── phonebook/              # Backend folder
│   ├── phonebook           # Compiled C binary
│   └── phonebook.c         # Source code
└── phonebook_data/
    └── contacts.txt        # Contact storage file
```

---

## ⚙️ Termux (Android) Installation

```bash
pkg update && pkg install php gcc git -y

# Clone project
git clone https://github.com/workforakng/Phonebook.git
cd Phonebook/www

# Compile the C program
gcc phonebook/phonebook.c -o phonebook/phonebook
chmod +x phonebook/phonebook

# Start PHP server
php -S localhost:8080
```

**Visit:** `http://localhost:8080` in your Android browser

---

## 🐧 Ubuntu / Linux Installation

```bash
sudo apt update && sudo apt install php gcc apache2 -y

# Move files to Apache web root
sudo cp -r ~/Phonebook/www /var/www/phonebook
cd /var/www/phonebook

# Compile the phonebook executable
gcc phonebook/phonebook.c -o phonebook/phonebook
sudo chmod +x phonebook/phonebook

# Create and configure data directory
sudo mkdir -p /var/www/phonebook_data
sudo chown -R www-data:www-data /var/www/phonebook_data
sudo chmod 755 /var/www/phonebook_data

# Restart Apache
sudo systemctl restart apache2
```

**Visit:** `http://localhost/phonebook/index.php` in your browser

---

## ✏️ Modify File Paths

### phonebook.c

```c
#define FILE_NAME "/var/www/phonebook_data/contacts.txt"
```

### index.php

```php
$ROOT_PATH = "/var/www/phonebook";
$PHONEBOOK = "$ROOT_PATH/phonebook/phonebook";
```

---

## 🖥 CLI Commands

```bash
# Add contact
./phonebook add "John Doe" "1234567890"

# Search contact
./phonebook search "John"

# Edit contact
./phonebook edit "John Doe" "0987654321"

# Delete contact
./phonebook delete "John Doe"

# List all contacts
./phonebook list
```

---

## ⚠️ Troubleshooting

### Apache/PHP Errors:
```bash
sudo chown -R www-data:www-data /var/www/phonebook_data
sudo chmod 755 /var/www/phonebook/phonebook
sudo tail -f /var/log/apache2/error.log
```

### Termux Storage:
```bash
termux-setup-storage
```

---

## 📜 License

MIT License © 2024
