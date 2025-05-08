# 📞 Phonebook Manager

A simple CLI + Web-based phonebook manager written in C (for performance) with a PHP frontend. Cross-platform support for:

- **Android (Termux)**
- **Ubuntu/Linux**
- **Windows (via WSL2)**

## ✅ Features

- Add / Search / Edit / Delete Contacts
- Binary-tree optimized contact storage
- Simple web interface using PHP
- Command-line interface support

---

## 📁 File Structure

```
Phonebook/
├── src/
│   ├── phonebook.c       # Core app logic (C)
│   └── index.php         # Web UI
├── README.md
```

---

## 🚀 Installation Instructions

### 📱 Termux (Android)

```bash
pkg update && pkg upgrade
pkg install php gcc git -y

git clone https://github.com/workforakng/Phonebook.git
cd Phonebook

# Compile the binary
gcc src/phonebook.c -o ~/www/phonebook/phonebook
chmod +x ~/www/phonebook/phonebook

# Setup web folder
mkdir -p ~/www/phonebook_data
cp src/index.php ~/www/

# Start the PHP web server
php -S localhost:8080 -t ~/www
```

**Access**: [http://localhost:8080](http://localhost:8080)

---

### 🐧 Ubuntu/Linux

#### 1. Install Dependencies

```bash
sudo apt update
sudo apt install php gcc apache2 -y
```

#### 2. Setup Project

```bash
git clone https://github.com/workforakng/Phonebook.git
cd Phonebook
```

#### 3. Update Paths

Edit `phonebook.c`:

```c
#define FILE_NAME "/var/www/phonebook_data/contacts.txt"
```

Edit `index.php`:

```php
$ROOT_PATH = "/var/www";
$PHONEBOOK = "$ROOT_PATH/phonebook/phonebook";
```

#### 4. Compile and Deploy

```bash
sudo mkdir -p /var/www/phonebook_data
sudo chown -R www-data:www-data /var/www/phonebook_data
sudo chmod 755 /var/www/phonebook_data

sudo mkdir -p /var/www/phonebook
sudo gcc src/phonebook.c -o /var/www/phonebook/phonebook
sudo chmod +x /var/www/phonebook/phonebook

sudo cp src/index.php /var/www/html/index.php
```

#### 5. Start Apache

```bash
sudo systemctl start apache2
sudo systemctl enable apache2
```

**Access**: [http://localhost/index.php](http://localhost/index.php)

---

## 🖥 CLI Usage

```bash
phonebook add "John Doe" "1234567890"
phonebook list
phonebook search "John"
phonebook edit "John Doe" "9876543210"
phonebook delete "John Doe"
```

> Replace `phonebook` with `/var/www/phonebook/phonebook` or `~/www/phonebook/phonebook` depending on OS.

---

## ⚙️ Troubleshooting

### PHP/Web Issues

```bash
sudo chown -R www-data:www-data /var/www/phonebook_data
sudo chmod 755 /var/www/phonebook/phonebook
```

### Apache Error Logs

```bash
sudo tail -f /var/log/apache2/error.log
```

### Termux-Specific

```bash
termux-setup-storage
termux-change-repo
```

---

## 🔐 Suggestions for Production

- Add `.htaccess` to restrict access
- Add simple password-based login to `index.php`
- Use SQLite or JSON backend for more structure

---

## 🧾 License

MIT License © 2024 [@workforakng](https://github.com/workforakng)
