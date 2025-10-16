# TOR Clearance Processing System

## Description
The TOR Clearance Processing System is a web-based application designed to manage and process student clearance requests for Transcript of Records (TOR) at educational institutions. It allows administrators to handle student information, department clearances, and request tracking efficiently.

## Features
- **Admin Authentication**: Secure login for master and department-specific admins.
- **Student Management**: Add, edit, and remove student records with validation.
- **Department Management**: Dynamic department creation and editing.
- **Clearance Tracking**: Monitor clearance status across multiple departments (PCD, Library, Finance, Guidance).
- **Request Processing**: Handle student TOR requests with SMS notifications.
- **Search Functionality**: Search students by ID.
- **Responsive UI**: Bootstrap-based interface for better user experience.

## Installation
1. **Prerequisites**:
   - PHP 8.0 or higher
   - MySQL/MariaDB
   - Apache/Nginx web server
   - Composer (for PHP dependencies)

2. **Clone the Repository**:
   ```bash
   git clone https://github.com/yourusername/tor-clearance-processing-system.git
   cd tor-clearance-processing-system
   ```

3. **Install Dependencies**:
   ```bash
   composer install
   ```

4. **Database Setup**:
   - Import the `tor_cps.sql` file into your MySQL database.
   - Update database credentials in `config.php`.

5. **Configure SMS API** (Optional):
   - Update SMS API key in `config.php` and relevant files.

6. **Run the Application**:
   - Place the project in your web server's root directory (e.g., `htdocs` for XAMPP).
   - Access via `http://localhost/tor-clearance-processing-system`.

## Usage
- **Admin Login**: Use `adminlogin.php` to log in as master or department admin.
- **Master Admin**: Manage departments, students, and requests via `masterhome.php`.
- **Department Admins**: Handle clearances in their respective areas (e.g., `financehome.php`).
- **Student Portal**: Students can submit requests via `login.php` and track status via `status.php`.

## Technologies Used
- **Backend**: PHP, MySQL
- **Frontend**: HTML, CSS, JavaScript, Bootstrap, jQuery
- **SMS Integration**: SMSGatewayMe API
- **Version Control**: Git

## Contributing
1. Fork the repository.
2. Create a feature branch (`git checkout -b feature/your-feature`).
3. Commit your changes (`git commit -am 'Add new feature'`).
4. Push to the branch (`git push origin feature/your-feature`).
5. Create a Pull Request.

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contact
For questions or support, please contact [your-email@example.com].
