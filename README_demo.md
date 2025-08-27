# Grand Corporation IMS - Demo Application

A comprehensive **read-only demo** of an International Management System (IMS) built with Laravel 12 and Blade templates. This demo showcases end-to-end business workflow navigation across all modules with static, pre-seeded data.

## 🎯 Demo Features

### **Complete Business Workflow**

-   **Data Bank & Sourcing** → Search products and prepare offers
-   **CRM** → Manage customers, principals, and products
-   **Sales Operations** → Quotations → Indents → Letters of Credit
-   **Logistics** → Shipments with documents and certificates
-   **Finance** → Debit Notes and Account Summaries
-   **Reports** → 8 predefined business reports
-   **Admin** → Teams, users, parameters, and branding

### **Role-Based Access Control**

-   **SuperAdmin**: Full access to all modules
-   **Admin**: All modules except branding management
-   **Staff**: Read-only access to CRM, Data Bank, Sales Ops, and Logistics

### **Interactive Demo Elements**

-   ✅ **Fuzzy Search** across product names and aliases
-   ✅ **Working Filters** with pagination
-   ✅ **Clickable CTAs** that navigate through the workflow
-   ✅ **Static Charts** with realistic data
-   ✅ **Status Tracking** for business processes
-   ✅ **Demo Banner** clearly indicating read-only mode

## 🚀 Quick Start

### Prerequisites

-   PHP 8.2+
-   Laravel 12
-   SQLite (or MySQL/PostgreSQL)

### Installation

```bash
# Clone and setup
git clone <repository>
cd grand-cop
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan demo:seed

# Start the application
php artisan serve
```

### Demo Login Credentials

```
SuperAdmin: super@grand.test / password
Admin:      admin@grand.test / password
Staff:      staff@grand.test / password
```

## 📊 Demo Data Overview

### **Core Entities**

-   **12 Customers** across different regions
-   **10 Principals** from various countries
-   **40 Products** across 6 categories
-   **25 Quotations** with items
-   **18 Indents** with status tracking
-   **14 Letters of Credit** with expiry dates
-   **20 Shipments** with documents
-   **12 Debit Notes** for invoicing
-   **200+ Data Bank Records** for sourcing

### **Sample IDs for Navigation**

-   **Quotation**: Q-0001 (Approved status)
-   **Indent**: IN-0001 (LC_Issued status)
-   **L/C**: LC-00001 (Active)
-   **Shipment**: SH-0001 (Delivered with documents)
-   **Debit Note**: DN-0001 (Issued)

## 🔄 Demo Workflow Navigation

### **1. Data Bank & Sourcing**

-   Visit: `/data-bank`
-   Search for products using fuzzy search
-   Filter by region, price range, reliability
-   Click "Prepare Offer" → navigates to Quotation #1

### **2. Sales Operations Workflow**

-   **Quotations**: `/quotations` → View list with status filters
-   **Quotation Details**: `/quotations/1` → Shows items and "Create Indent" button
-   **Indent Details**: `/indents/1` → Shows status and "Issue L/C" button
-   **L/C Details**: `/lcs/1` → Shows bank details and "Create Shipment" button

### **3. Logistics Workflow**

-   **Shipments**: `/shipments` → View with status tracking
-   **Shipment Details**: `/shipments/1` → Shows documents and "Finalize & Create Debit Note" button

### **4. Finance Workflow**

-   **Debit Notes**: `/debit-notes` → View issued notes
-   **Accounts**: `/finance/accounts` → View account summaries

### **5. Reports**

-   **Reports Index**: `/reports` → 8 predefined business reports
-   **Export Demo**: `/reports/export/{slug}` → Downloads sample files

### **6. Admin Modules**

-   **Teams Management**: `/admin/teams` → View team structure and hierarchy
-   **Users Management**: `/admin/users` → View user accounts and roles
-   **System Parameters**: `/admin/parameters` → View system configuration
-   **Company Branding**: `/admin/branding` → View company branding (SuperAdmin only)

## 🎨 UI/UX Features

### **Dashboard**

-   **KPI Cards**: Total counts for all major entities
-   **Charts**: Indent volume, shipment performance, customer business
-   **Alerts**: Pending quotations, expiring L/Cs, pending shipments
-   **Quick Actions**: Direct navigation to key modules

### **Navigation**

-   **Collapsible Sidebar**: Organized by business modules
-   **Role-Based Menu**: Items hidden based on user role
-   **Breadcrumbs**: Clear navigation path
-   **Demo Banner**: Always visible at top

### **Tables & Lists**

-   **Search & Filters**: Working filters with pagination
-   **Status Badges**: Color-coded status indicators
-   **Action Buttons**: Navigate to next step in workflow
-   **Responsive Design**: Works on all screen sizes

## 🔧 Technical Implementation

### **Architecture**

-   **Laravel 12** with Blade templates
-   **SQLite** database for simplicity
-   **Material Dashboard** UI framework
-   **Chart.js** for data visualization
-   **Role-based Gates** for authorization

### **Key Models**

```php
// Core Business Models
Customer, Principal, Product, ProductPrincipal
Quotation, QuotationItem, Indent, LetterOfCredit
Shipment, ShipmentDocument, Certificate
DebitNote, AccountEntry

// Support Models
Team, User, Parameter, Branding
DataBankRecord, PriceHistory
```

### **Demo Commands**

```bash
# Seed all demo data
php artisan demo:seed

# Reset and reseed
php artisan migrate:fresh --seed
```

## 📋 Acceptance Checklist

-   ✅ App boots to Dashboard after login
-   ✅ Demo banner visible on all pages
-   ✅ Sidebar shows role-appropriate menu items
-   ✅ All index pages load with filters and pagination
-   ✅ All show pages display realistic data
-   ✅ Data Bank search works with fuzzy matching
-   ✅ Complete workflow navigation (Q→I→LC→S→DN→A)
-   ✅ Dashboard KPIs match seeded counts
-   ✅ Charts render with static data
-   ✅ Alerts populate with real counts
-   ✅ Reports page shows 8 report stubs
-   ✅ Export buttons return sample files
-   ✅ Users can log in with seeded credentials

## 🎯 Demo Limitations

### **Read-Only Nature**

-   All "Create/Edit" buttons are disabled with tooltips
-   No actual database writes during demo
-   All actions simulate navigation only

### **Static Data**

-   Charts use pre-defined data arrays
-   All counts are from seeded records
-   No real-time updates or calculations

### **File Handling**

-   Document downloads return placeholder files
-   No actual file uploads or processing
-   Export files are pre-generated samples

## 🚀 Future Enhancements

### **Potential Real Implementation**

-   Replace static data with dynamic queries
-   Implement actual CRUD operations
-   Add real file upload/download
-   Integrate with external APIs
-   Add real-time notifications
-   Implement audit trails

### **Additional Features**

-   Email notifications
-   PDF generation
-   API endpoints
-   Mobile responsiveness
-   Advanced reporting
-   Workflow automation

## 📞 Support

This is a **demo application** designed to showcase business workflow and UI/UX patterns. For questions about the implementation or extending to a real system, refer to the Laravel documentation and best practices.

---

**Built with ❤️ using Laravel 12 and Material Dashboard**
