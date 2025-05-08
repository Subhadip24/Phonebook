# 📞 Cross-Platform Phonebook Manager

A lightweight C-based contact manager with a modern PHP web interface.

Supports **Add**, **Search**, **Edit**, and **Delete** operations via **web** or **command line**. Built for **Termux**, **Linux**, and **Windows WSL**.

---

## 📂 File Structure

```
www/
├── index.php                  # Web UI
├── phonebook/
│   ├── phonebook             # Compiled C executable
│   └── phonebook.c           # Source code
└── phonebook_data/
    └── contacts.txt          # Stored contacts
```

---

## ⚙️ Installation Guide

### ✅ Termux (Android)
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
Then open [http://localhost:8080](http://localhost:8080)

---

### ✅ Ubuntu / Linux
```bash
sudo apt update && sudo apt install php gcc apache2 -y

# Move files to Apache web root
sudo cp -r ~/Phonebook/www /var/www/phonebook
cd /var/www/phonebook

# Compile the phonebook executable
gcc phonebook/phonebook.c -o phonebook/phonebook
sudo chmod +x phonebook/phonebook

# Set file permissions
sudo mkdir -p /var/www/phonebook_data
sudo chown -R www-data:www-data /var/www/phonebook_data
sudo chmod 755 /var/www/phonebook_data

# Restart Apache
sudo systemctl restart apache2
```

Access it at: [http://localhost/phonebook/index.php](http://localhost/phonebook/index.php)

---

### ✅ Windows WSL
1. Install [WSL2 + Ubuntu](https://learn.microsoft.com/en-us/windows/wsl/)
2. Follow **Ubuntu/Linux** steps above inside WSL terminal.

---

## 🛠 CLI Usage
```bash
./phonebook/phonebook add "Alice" "1234567890"
./phonebook/phonebook list
./phonebook/phonebook search "Alice"
./phonebook/phonebook edit "Alice" "0987654321"
./phonebook/phonebook delete "Alice"
```

---

## 🌐 Web Interface Features
- **Add Contact**
- **Search Contact**
- **Edit Contact**
- **Delete Contact**
- Live display of all contacts

---

## 🐞 Troubleshooting

**Common fixes:**
```bash
# Apache/PHP not seeing your files?
sudo chown -R www-data:www-data /var/www/phonebook_data
sudo chmod +x /var/www/phonebook/phonebook

# View Apache errors
sudo tail -f /var/log/apache2/error.log
```

---

## 📜 License
MIT © 2025 [@workforakng](https://github.com/workforakng)
