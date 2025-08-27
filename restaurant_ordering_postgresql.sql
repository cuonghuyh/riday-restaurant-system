-- PostgreSQL version của restaurant_ordering.sql
-- Thay thế MySQL syntax bằng PostgreSQL

-- Database: restaurant_ordering

-- Table structure for table categories
DROP TABLE IF EXISTS categories CASCADE;
CREATE TABLE categories (
  id SERIAL PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  status VARCHAR(20) DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table structure for table menu_items  
DROP TABLE IF EXISTS menu_items CASCADE;
CREATE TABLE menu_items (
  id SERIAL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  category_id INTEGER REFERENCES categories(id),
  image VARCHAR(500),
  status VARCHAR(20) DEFAULT 'available',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table structure for table orders
DROP TABLE IF EXISTS orders CASCADE;
CREATE TABLE orders (
  id SERIAL PRIMARY KEY,
  table_number INTEGER NOT NULL,
  customer_name VARCHAR(255),
  customer_phone VARCHAR(20),
  total_amount DECIMAL(10,2) NOT NULL,
  status VARCHAR(20) DEFAULT 'pending',
  notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table structure for table order_items
DROP TABLE IF EXISTS order_items CASCADE;
CREATE TABLE order_items (
  id SERIAL PRIMARY KEY,
  order_id INTEGER REFERENCES orders(id) ON DELETE CASCADE,
  menu_item_id INTEGER REFERENCES menu_items(id),
  quantity INTEGER NOT NULL DEFAULT 1,
  price DECIMAL(10,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table structure for table tables
DROP TABLE IF EXISTS tables CASCADE;
CREATE TABLE tables (
  id SERIAL PRIMARY KEY,
  table_number INTEGER UNIQUE NOT NULL,
  seats INTEGER DEFAULT 4,
  status VARCHAR(20) DEFAULT 'available',
  qr_code VARCHAR(500),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO categories (name, status) VALUES 
('Món chính', 'active'),
('Đồ uống', 'active'),
('Tráng miệng', 'active');

INSERT INTO menu_items (name, description, price, category_id, status) VALUES
('Phở Bò', 'Phở bò truyền thống với nước dầm đậm đà', 45000, 1, 'available'),
('Bún Chả', 'Bún chả Hà Nội với thịt nướng thơm ngon', 50000, 1, 'available'),
('Cà phê đen', 'Cà phê đen đậm đà', 25000, 2, 'available'),
('Trà đá', 'Trà đá mát lạnh', 10000, 2, 'available');

INSERT INTO tables (table_number, seats, status) VALUES
(1, 4, 'available'),
(2, 2, 'available'),
(3, 6, 'available'),
(4, 4, 'available'),
(5, 8, 'available');
