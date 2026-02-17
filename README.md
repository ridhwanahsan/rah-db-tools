# 🚀 RAH DB Tools – The Ultimate WordPress Database Manager

**Optimize, Clean, and Manage your WordPress Database with Professional Precision.**

RAH DB Tools is a powerful, all-in-one database management plugin designed to keep your WordPress site fast, clean, and healthy. Whether you need to visualize your data, remove bloat, or run complex SQL queries, RAH DB Tools provides a secure and intuitive interface right inside your admin dashboard.

![WordPress Version](https://img.shields.io/wordpress/v/rah-db-tools?style=flat-square) ![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-blue?style=flat-square) ![License](https://img.shields.io/badge/License-GPLv2-green?style=flat-square)

---

## ✨ Key Features

### 📊 **Advanced Dashboard Analysis**
Get a birds-eye view of your database health instantly.
*   **Real-time Stats:** Monitor total tables, row counts, and disk usage.
*   **Performance Alerts:** Instantly spot dangerous **Autoloaded Options** that slow down your site.
*   **Bloat Detection:** Identify the **Top 5 Largest Tables** clogging your storage.

### 🧹 **One-Click Database Cleanup**
Remove junk data that accumulates over time and slows down your site.
*   **Revisions Cleaner:** Delete thousands of old post revisions.
*   **Spam & Trash:** Wipe out spam comments and trashed items in seconds.
*   **Transient Remover:** Clear expired temporary data (transients).
*   **Orphaned Data:** remove metadata left behind by deleted posts/comments.

### ⚡ **Automated Scheduler** (Set & Forget)
Keep your database optimized automatically.
*   **Flexible Schedule:** Run tasks Daily, Weekly, or Monthly.
*   **Custom Tasks:** Choose exactly what to clean (e.g., only optimize tables and remove spam).
*   **Silent Operation:** Works in the background without interrupting your workflow.

### 🔍 **Smart Search & Replace**
Essential for site migrations and domain changes.
*   **Safe Dry Run:** Preview exactly what will change before it happens.
*   **Serialization Support:** Safely replaces text inside serialized PHP arrays (critical for Widgets & Theme Options).
*   **Selective Scope:** Run replacements on specific tables or the entire database.

### 🛠️ **Developer Tools**
*   **SQL Runner:** Execute custom `SELECT`, `INSERT`, `UPDATE`, or `DELETE` queries securely.
*   **Table Inspector:** Browse raw table data with a spreadsheet-like view (horizontal scrolling, sticky headers).
*   **CSV Export:** Download any table's data for external analysis or backup.
*   **Table Optimizer:** Run `OPTIMIZE TABLE` to defragment and reclaim disk space.

---

## 🚀 Installation

1.  **Upload:** Upload the `rah-db-tools` folder to the `/wp-content/plugins/` directory.
2.  **Activate:** Activate the plugin through the 'Plugins' menu in WordPress.
3.  **Manage:** Navigate to **RAH DB Tools** in the admin sidebar to start optimizing!

---

## 📸 Screenshots

| Feature | Description |
| :--- | :--- |
| **Dashboard** | Comprehensive overview of database size and health.
                |<img width="1683" height="626" alt="image" src="https://github.com/user-attachments/assets/7d3fd5de-48dc-47a9-a031-a467ba4256ce" />

| **Data Viewer** | Clean, scrollable table view for inspecting raw data. 
                  |<img width="1692" height="761" alt="image" src="https://github.com/user-attachments/assets/b19dc0ee-0ae0-469f-ad5e-5778d75adc55" />

| **Cleanup** | Simple checkboxes to remove junk data instantly. 
              |<img width="1437" height="345" alt="image" src="https://github.com/user-attachments/assets/552bf06a-914d-4b5d-a8d4-952dee039720" />

| **Scheduler** | Schedule automatic database cleanup and optimization tasks.. 
                 | <img width="868" height="501" alt="image" src="https://github.com/user-attachments/assets/b8acac75-81e4-48dc-baa5-c0033fc47c7e" />


---

## ⚠️ Requirements

*   **WordPress:** 6.0 or higher
*   **PHP:** 8.0 or higher
*   **Database:** MySQL 5.6+ or MariaDB 10.1+

---

## 🔒 Security & Safety

*   **Admin Only:** All tools are restricted to Administrators (`manage_options`).
*   **Nonce Protection:** Every action is protected against CSRF attacks.
*   **Secure Logging:** Operations are logged to a protected directory (`.htaccess` secured).
*   **Dry Run:** Search & Replace includes a preview mode to prevent accidents.

---

## 🤝 Contributing

Contributions are welcome! If you find a bug or want to add a feature, please submit a Pull Request or open an Issue.

**Author:** [ridhwanahsan](https://github.com/ridhwanahsan)  
**License:** GPLv2 or later
