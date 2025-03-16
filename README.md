<div align="right">

<a href="README.md"><img src="https://flagcdn.com/w40/gb.png" width="25" alt="English"></a> | 
<a href="README-ID.md"><img src="https://flagcdn.com/w40/id.png" width="20" alt="Indonesian"></a>

</div>

# 🏥 Hospital Management System

<div align="center">

![preview](https://github.com/Ryan-infitech/Rumah-Sakit-PHP/blob/main/storage/readme/RS-PHP.gif?raw=true)

</div>

A comprehensive web application for managing hospital operations, appointments, and patient records built with Laravel.

![Laravel](https://img.shields.io/badge/Laravel-9.x-red)
![PHP](https://img.shields.io/badge/PHP-8.0+-blue)
![MySQL](https://img.shields.io/badge/MySQL-Database-orange)

## ✨ Features

### Multi-Role System
- **👩‍💼 Admin**: System management, user control, and analytics
- **👨‍⚕️ Staff**: Patient registration, appointment handling, and medical records
- **🧑‍🤝‍🧑 Patient**: Book appointments, track queue, and access medical history

### Admin Portal
![admin](./storage/readme/admin-ss.png)
- Comprehensive dashboard with real-time metrics
- User management (create, update, delete)
- Department/Poliklinik management
- Doctor scheduling
- System performance monitoring
- Reporting and analytics

### Staff Portal
![staff](./storage/readme/staff-ss.png)
- Patient registration and management
- Appointment processing
- Queue management
- Medical record access
- Daily patient reports

### Patient Portal
![patient](./storage/readme/patient-ss.png)
- Appointment booking
- Queue tracking
- Medical history access
- Prescription history
- Profile management
- Service rating system

## 🛠️ Technology Stack
<div align="center">

<a href=""><img src="https://github.com/Ryan-infitech/Rumah-Sakit-PHP/blob/main/storage/readme/Laravel%20Backend%20Framework.gif?raw=true" width="100px"></a> <a href=""><img src="https://github.com/Ryan-infitech/Rumah-Sakit-PHP/blob/main/storage/readme/JS.gif?raw=true" width="100px"></a> <a href=""><img src="https://github.com/Ryan-infitech/Rumah-Sakit-PHP/blob/main/storage/readme/Mysql%20Database.gif?raw=true" width="100px"></a>



</div>


## 📋 Requirements

- PHP >= 8.0
- MySQL
- Composer
- Node.js & NPM

## 🚀 Installation

1. **Clone the repository**
```bash
git clone https://github.com/yourusername/hospital-management-system.git
cd hospital-management-system
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install JavaScript dependencies**
```bash
npm install && npm run dev
```

4. **Configure environment**
```bash
cp .env.example .env
```

5. **Update database settings in .env**
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hospital_management
DB_USERNAME=root
DB_PASSWORD=
```

6. **Generate application key**
```bash
php artisan key:generate
```

7. **Run migrations and seeders**
```bash
php artisan migrate --seed
```

8. **Start development server**
```bash
php artisan serve
```

## 👥 Default Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | password |
| Staff | staff@example.com | password |
| Patient | patient@example.com | password |


## 📊 System Architecture

```
app/
├── Http/
│   ├── Controllers/      # Route controllers
│   ├── Middleware/       # Request middleware
│   └── Requests/         # Form requests
├── Models/               # Database models
├── Providers/            # Service providers
├── Services/             # Business logic
└── Resources/
    ├── views/            # Blade templates
    ├── js/               # JavaScript
    └── css/              # Stylesheets
```

## 🔄 Workflow

1. Patients register and book appointments
2. Staff process appointments and manage queue
3. Doctors see patients and update medical records
4. Admin oversees the entire system and generates reports

## 📚 Documentation

Detailed documentation is available in the `docs/` directory:
- [Documentation](docs/installation.md)

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👏 Acknowledgements

- Laravel Community
- Bootstrap Team
- All contributors who have helped improve this system

## Contact

If you have any questions or suggestions, please open a new issue in this repository.

[![WhatsApp](https://img.shields.io/badge/WhatsApp-25D366?style=for-the-badge&logo=whatsapp&logoColor=white)](https://wa.me/6285157517798)
[![linkedin](https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/rian-septiawan-23b0a5351/)
[![Instagram](https://img.shields.io/badge/Instagram-E4405F?style=for-the-badge&logo=instagram&logoColor=white)](https://www.instagram.com/ryan.septiawan__/)
