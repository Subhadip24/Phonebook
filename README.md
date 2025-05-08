# 📞 Cross-Platform Phonebook Manager

A contact management system with both **CLI** and **Web Interface**, supporting:

- Add, Search, Edit, Delete contacts
- Fast lookup using a binary tree
- Persistent storage using flat files
- Web UI powered by PHP
- Platform support: Android (Termux), Linux (Ubuntu), Windows (WSL)

---

## 🌐 Web Interface

**Features:**
- Add contacts via form
- Search live by name or number
- Edit existing entries
- Delete contacts with confirmation

> Works locally via PHP built-in server or Apache.

---

## 📦 Features

| Feature        | CLI       | Web UI   |
|----------------|-----------|----------|
| Add Contact    | ✅        | ✅       |
| Search Contact | ✅        | ✅       |
| Edit Contact   | ✅        | ✅       |
| Delete Contact | ✅        | ✅       |
| List All       | ✅        | ✅       |

---

## ⚙️ Installation

### ✅ Android (Termux)

bash
pkg update && pkg upgrade
pkg install php gcc git -y

git clone https://github.com/yourusername/phonebook-app
cd phonebook-app

gcc src/phonebook.c -o $PREFIX/bin/phonebook
chmod +x $PREFIX/bin/phonebook

mkdir -p ~/www/phonebook_data
cp src/index.php ~/www/

php -S localhost:8080 -t ~/www



Open in browser: http://localhost:8080


🐧 Linux (Ubuntu)

sudo apt update && sudo apt install php gcc git apache2 -y

git clone https://github.com/yourusername/phonebook-app
cd phonebook-app

sudo gcc src/phonebook.c -o /usr/local/bin/phonebook
sudo chmod +x /usr/local/bin/phonebook

sudo mkdir -p /var/www/phonebook_data
sudo chown www-data:www-data /var/www/phonebook_data

sudo cp src/index.php /var/www/html/

sudo systemctl start apache2

Open in browser: http://localhost


---

⊞ Windows (WSL2)

Install WSL2 and Ubuntu from the Microsoft Store

Follow Linux steps inside WSL terminal

Access via browser using WSL IP or localhost



---

🖥️ CLI Usage

phonebook add "Alice" "1234567890"
phonebook search "Alice"
phonebook edit "Alice" "9876543210"
phonebook delete "Alice"
phonebook list


❗ Troubleshooting

Termux PHP server doesn't start:

php -S localhost:8080 -t ~/www

Fix permissions (Ubuntu):

sudo chown -R www-data:www-data /var/www/phonebook_data
sudo chmod 755 /usr/local/bin/phonebook

Compilation error:

gcc src/phonebook.c -o phonebook


---

📄 License

MIT License © 2025 — Free to use and modify


---

⭐ Contributions

Pull requests welcome! Please fork the repository and submit a PR with improvements.
