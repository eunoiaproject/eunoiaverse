# Database Schema Documentation

## Overview

The Eunoiaverse database is built on MySQL with the following main tables handling authentication, profiles, wallets, transactions, and products.

## Tables

### users
Stores user account information.

```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_verified BOOLEAN DEFAULT FALSE,
    verification_token VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    two_factor_secret VARCHAR(255),
    last_login TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_username (username),
    INDEX idx_email (email)
);
```

#### Fields
| Field | Type | Description |
|-------|------|-------------|
| id | INT | Primary key |
| username | VARCHAR(50) | Unique username |
| email | VARCHAR(100) | User email address |
| password | VARCHAR(255) | Hashed password |
| is_verified | BOOLEAN | Email verification status |
| verification_token | VARCHAR(255) | Email verification token |
| is_active | BOOLEAN | Account active status |
| two_factor_secret | VARCHAR(255) | 2FA secret |
| last_login | TIMESTAMP | Last login time |
| created_at | TIMESTAMP | Account creation time |
| updated_at | TIMESTAMP | Last update time |
| deleted_at | TIMESTAMP | Account deletion time (soft delete) |

---

### profiles
Stores detailed user profile information.

```sql
CREATE TABLE profiles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL UNIQUE,
    full_name VARCHAR(100),
    phone VARCHAR(20),
    address VARCHAR(255),
    city VARCHAR(50),
    country VARCHAR(50),
    bio TEXT,
    avatar_url VARCHAR(255),
    date_of_birth DATE,
    gender ENUM('male', 'female', 'other'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id)
);
```

#### Fields
| Field | Type | Description |
|-------|------|-------------|
| id | INT | Primary key |
| user_id | INT | Foreign key to users |
| full_name | VARCHAR(100) | Full name |
| phone | VARCHAR(20) | Phone number |
| address | VARCHAR(255) | Street address |
| city | VARCHAR(50) | City |
| country | VARCHAR(50) | Country |
| bio | TEXT | User biography |
| avatar_url | VARCHAR(255) | Avatar image URL |
| date_of_birth | DATE | Date of birth |
| gender | ENUM | Gender |
| created_at | TIMESTAMP | Creation time |
| updated_at | TIMESTAMP | Update time |

---

### wallets
Stores wallet and balance information.

```sql
CREATE TABLE wallets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL UNIQUE,
    balance DECIMAL(15, 2) DEFAULT 0,
    frozen_balance DECIMAL(15, 2) DEFAULT 0,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id)
);
```

#### Fields
| Field | Type | Description |
|-------|------|-------------|
| id | INT | Primary key |
| user_id | INT | Foreign key to users |
| balance | DECIMAL(15,2) | Current balance |
| frozen_balance | DECIMAL(15,2) | Frozen/pending balance |
| last_updated | TIMESTAMP | Last update time |
| created_at | TIMESTAMP | Creation time |

---

### transactions
Records all wallet transactions.

```sql
CREATE TABLE transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    from_user_id INT,
    to_user_id INT,
    type ENUM('purchase', 'transfer', 'topup', 'withdrawal', 'refund') NOT NULL,
    amount DECIMAL(15, 2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'IDR',
    description VARCHAR(255),
    status ENUM('pending', 'completed', 'failed', 'cancelled') DEFAULT 'pending',
    reference_id VARCHAR(50),
    metadata JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (from_user_id) REFERENCES users(id),
    FOREIGN KEY (to_user_id) REFERENCES users(id),
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
);
```

#### Fields
| Field | Type | Description |
|-------|------|-------------|
| id | INT | Primary key |
| user_id | INT | User performing transaction |
| from_user_id | INT | Sender (for transfers) |
| to_user_id | INT | Recipient (for transfers) |
| type | ENUM | Transaction type |
| amount | DECIMAL(15,2) | Transaction amount |
| currency | VARCHAR(3) | Currency code |
| description | VARCHAR(255) | Transaction description |
| status | ENUM | Transaction status |
| reference_id | VARCHAR(50) | Reference/tracking ID |
| metadata | JSON | Additional metadata |
| created_at | TIMESTAMP | Creation time |
| updated_at | TIMESTAMP | Update time |

---

### products
Stores product information.

```sql
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    seller_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(15, 2) NOT NULL,
    original_price DECIMAL(15, 2),
    discount_percentage INT DEFAULT 0,
    image_url VARCHAR(255),
    category_id INT,
    is_featured BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    stock_quantity INT DEFAULT 0,
    sold_count INT DEFAULT 0,
    rating DECIMAL(3, 2) DEFAULT 0,
    review_count INT DEFAULT 0,
    shipping_cost DECIMAL(10, 2),
    weight DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (seller_id) REFERENCES users(id),
    FOREIGN KEY (category_id) REFERENCES categories(id),
    INDEX idx_name (name),
    INDEX idx_category_id (category_id),
    INDEX idx_is_active (is_active),
    FULLTEXT INDEX ft_search (name, description)
);
```

#### Fields
| Field | Type | Description |
|-------|------|-------------|
| id | INT | Primary key |
| seller_id | INT | Seller user ID |
| name | VARCHAR(255) | Product name |
| description | TEXT | Product description |
| price | DECIMAL(15,2) | Current price |
| original_price | DECIMAL(15,2) | Original price |
| discount_percentage | INT | Discount percentage |
| image_url | VARCHAR(255) | Product image |
| category_id | INT | Product category |
| is_featured | BOOLEAN | Featured product |
| is_active | BOOLEAN | Product active status |
| stock_quantity | INT | Available stock |
| sold_count | INT | Number sold |
| rating | DECIMAL(3,2) | Average rating |
| review_count | INT | Number of reviews |
| shipping_cost | DECIMAL(10,2) | Shipping cost |
| weight | DECIMAL(10,2) | Product weight |
| created_at | TIMESTAMP | Creation time |
| updated_at | TIMESTAMP | Update time |

---

### categories
Product categories.

```sql
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    icon VARCHAR(50),
    parent_id INT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id),
    INDEX idx_name (name)
);
```

---

### reviews
Product reviews and ratings.

```sql
CREATE TABLE reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    title VARCHAR(255),
    comment TEXT,
    helpful_count INT DEFAULT 0,
    is_verified_purchase BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_product_id (product_id),
    INDEX idx_user_id (user_id),
    INDEX idx_rating (rating)
);
```

---

### orders
Stores customer orders.

```sql
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    total_amount DECIMAL(15, 2) NOT NULL,
    discount_amount DECIMAL(15, 2) DEFAULT 0,
    promo_code VARCHAR(50),
    final_amount DECIMAL(15, 2) NOT NULL,
    payment_method VARCHAR(50),
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled', 'returned') DEFAULT 'pending',
    shipping_address TEXT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
);
```

---

### order_items
Individual items in an order.

```sql
CREATE TABLE order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(15, 2) NOT NULL,
    total_price DECIMAL(15, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id),
    INDEX idx_order_id (order_id)
);
```

---

### wishlist
User wishlist items.

```sql
CREATE TABLE wishlist (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_wishlist (user_id, product_id),
    INDEX idx_user_id (user_id)
);
```

---

### promo_codes
Promotional codes.

```sql
CREATE TABLE promo_codes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(50) UNIQUE NOT NULL,
    discount_type ENUM('percentage', 'fixed') DEFAULT 'percentage',
    discount_value DECIMAL(10, 2) NOT NULL,
    max_uses INT,
    current_uses INT DEFAULT 0,
    valid_from DATE,
    valid_until DATE,
    min_purchase DECIMAL(15, 2) DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_code (code)
);
```

---

### investments
User investment records.

```sql
CREATE TABLE investments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    amount DECIMAL(15, 2) NOT NULL,
    expected_return DECIMAL(10, 2) NOT NULL,
    actual_return DECIMAL(15, 2) DEFAULT 0,
    investment_type VARCHAR(50),
    status ENUM('active', 'completed', 'cancelled') DEFAULT 'active',
    start_date DATE NOT NULL,
    end_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX idx_user_id (user_id)
);
```

---

## Relationships Diagram

```
users (1) -------- (1) profiles
   |
   |-------- (1) wallets
   |
   |-------- (N) transactions
   |
   |-------- (N) orders
   |
   |-------- (N) reviews
   |
   |-------- (N) wishlist
   |
   |-------- (N) investments
   |
   |-------- (N) products (as seller)

products (1) -------- (N) reviews
     |
     |-------- (N) order_items
     |
     |-------- (N) wishlist

categories (1) -------- (N) products

orders (1) -------- (N) order_items
```

---

## Queries

### Get User with Profile

```sql
SELECT u.*, p.* 
FROM users u
LEFT JOIN profiles p ON u.id = p.user_id
WHERE u.id = 1;
```

### Get User Statistics

```sql
SELECT 
    COUNT(DISTINCT o.id) as total_purchases,
    COALESCE(SUM(o.final_amount), 0) as total_spent,
    COUNT(DISTINCT w.id) as wishlist_items
FROM users u
LEFT JOIN orders o ON u.id = o.user_id AND o.status = 'delivered'
LEFT JOIN wishlist w ON u.id = w.user_id
WHERE u.id = 1
GROUP BY u.id;
```

### Get Recent Transactions

```sql
SELECT * FROM transactions
WHERE user_id = 1
ORDER BY created_at DESC
LIMIT 10;
```

### Get Top Selling Products

```sql
SELECT * FROM products
WHERE is_active = TRUE
ORDER BY sold_count DESC, rating DESC
LIMIT 20;
```

### Get Average Ratings by Category

```sql
SELECT 
    c.name,
    AVG(p.rating) as avg_rating,
    COUNT(p.id) as product_count
FROM categories c
LEFT JOIN products p ON c.id = p.category_id
GROUP BY c.id
ORDER BY avg_rating DESC;
```

---

## Indexes

Key indexes for performance:

```sql
-- Users
CREATE INDEX idx_users_username ON users(username);
CREATE INDEX idx_users_email ON users(email);

-- Profiles
CREATE INDEX idx_profiles_user_id ON profiles(user_id);

-- Transactions
CREATE INDEX idx_transactions_user_id ON transactions(user_id);
CREATE INDEX idx_transactions_status ON transactions(status);
CREATE INDEX idx_transactions_date ON transactions(created_at);

-- Products
CREATE INDEX idx_products_category ON products(category_id);
CREATE INDEX idx_products_active ON products(is_active);
FULLTEXT INDEX ft_products_search ON products(name, description);

-- Orders
CREATE INDEX idx_orders_user_id ON orders(user_id);
CREATE INDEX idx_orders_status ON orders(status);
CREATE INDEX idx_orders_date ON orders(created_at);
```

---

## Backup & Recovery

### Backup Database
```bash
mysqldump -u root -p eunoiaverse > backup.sql
```

### Restore Database
```bash
mysql -u root -p eunoiaverse < backup.sql
```

---

**Last Updated**: February 10, 2026
**Version**: 1.0.0
