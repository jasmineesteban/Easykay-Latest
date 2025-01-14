# EasyKay: A Transport Commuting Guide System

## Overview

**EasyKay** is a web-based application that helps commuters navigate the most efficient routes and transportation options available within Santa Maria.
It provides fare details, estimated travel times, distance., and suggestions for the best routes based on user preferences.
In addition to transportation guidance, it also provides information about **local attractions** and **upcoming tourism events**, offering users a comprehensive guide to exploring the municipality.

The system has two main interfaces:

- **User Side for Commuters**: Offers commuters easy access to real-time transportation data, route optimization, and local attractions.
- **Admin Side for the Tourism Department**: Allows authorized personnel from the Santa Maria Tourism Department to manage local attraction data, update event information, and ensure accurate transportation details.

## **Features**

### **User Side (Commuters)**

- Route optimization based on shortest distance or fastest time.
- Real-time public transport schedules (bus, jeep, tricycle).
- Interactive map integration.
- **Local attractions information** with descriptions and locations.
- **Tourism events** displaying upcoming local events.

### **Admin Side (Tourism Department)**

- Secure login for authorized tourism department personnel.
- Management of local attractions (add, edit, delete attractions).
- Ability to update and manage upcoming tourism events.
- Integration with public transportation data for accurate commuting information.

## **Installation**

### **Prerequisites**

Ensure you have the following installed on your system:

- **XAMPP** (for PHP, Apache, and MySQL)
- **Composer** (for PHP dependencies)
- **Git** (for version control)
- **Open Street Map API key** (for map integration)
- **Facebook and Google Authentication libraries** (included via Composer)

### **Steps to Install**

1. **Clone the repository:**
   ```bash
   git clone https://github.com/jasmineesteban/Easykay-Latest.git
   ```
2. **Navigate to the project directory:**
   ```bash
   cd Easykay-Latest
   ```
3. **Install PHP dependencies using Composer:**
   ```bash
   composer install
   ```

### Database Setup

1. **Create a MySQL database:**
   - Open **phpMyAdmin** by navigating to `http://localhost/phpmyadmin` in your browser.
   - Create a new database with the name: `easykay`.
2. **Import the database schema:**
   - Click on the **Import** tab in phpMyAdmin.
   - Choose the `easykay-5.sql` file located in the project’s folder.
   - Click **Go** to import the database structure and data.

### Authentication Setup (Facebook and Google)

1. **Facebook Authentication Setup:**

   - Go to the Facebook for Developers site.
   - Create a new app, and navigate to Facebook Login.
   - Get the App ID and App Secret from your Facebook app.
   - Add the Facebook Login Redirect URL (e.g., http://localhost/easykay/public/callback/facebook).
   - Add your App ID and App Secret to your .env file in the project:

   ```bash
   FACEBOOK_CLIENT_ID=your-facebook-client-id
   FACEBOOK_CLIENT_SECRET=your-facebook-client-secret
   FACEBOOK_REDIRECT_URL=http://localhost/easykay/public/callback/facebook

   ```

2. **Google Authentication Setup:**
   - Go to the Google Cloud Console.
   - Create a new project and navigate to the OAuth consent screen.
   - Create credentials for OAuth 2.0 Client IDs.
   - Get the Client ID and Client Secret.
   - Add the Redirect URI (e.g., http://localhost/easykay/public/callback/google).
   - Add your Client ID and Client Secret to your .env file:
   ```bash
   GOOGLE_CLIENT_ID=your-google-client-id
   GOOGLE_CLIENT_SECRET=your-google-client-secret
   GOOGLE_REDIRECT_URL=http://localhost/easykay/public/callback/google
   ```

### User Account Information

**Default Admin Account (Tourism Department):**

- Username: Admin
- Password: admin123

**User Authentication:**

- **Login Options:**
  - Facebook Login
  - Google Login
