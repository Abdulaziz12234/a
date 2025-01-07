
-- استخدام قاعدة البيانات
USE HotelBookingSystem;

-- إنشاء جدول المستخدمين (Users)
CREATE TABLE Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Email VARCHAR(100) UNIQUE NOT NULL,
    PasswordHash VARCHAR(255) NOT NULL,
    Role ENUM('Customer', 'Admin') DEFAULT 'Customer',
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- إنشاء جدول الغرف (Rooms)
CREATE TABLE Rooms (
    RoomID INT AUTO_INCREMENT PRIMARY KEY,
    RoomNumber VARCHAR(10) UNIQUE NOT NULL,
    RoomType ENUM('Single', 'Double', 'Suite') NOT NULL,
    Price DECIMAL(10, 2) NOT NULL,
    IsAvailable BOOLEAN DEFAULT TRUE
);

-- إنشاء جدول الحجوزات (Bookings)
CREATE TABLE Bookings (
    BookingID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT NOT NULL,
    RoomID INT NOT NULL,
    CheckInDate DATE NOT NULL,
    CheckOutDate DATE NOT NULL,
    BookingDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Status ENUM('Confirmed', 'Cancelled') DEFAULT 'Confirmed',
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (RoomID) REFERENCES Rooms(RoomID)
);

-- إضافة بيانات افتراضية إلى جدول الغرف
INSERT INTO Rooms (RoomNumber, RoomType, Price, IsAvailable) VALUES
('101', 'Single', 100.00, TRUE),
('102', 'Double', 150.00, TRUE),
('201', 'Suite', 300.00, TRUE),
('202', 'Suite', 350.00, FALSE);

-- إضافة مستخدمين افتراضيين
INSERT INTO Users (Name, Email, PasswordHash, Role) VALUES
('John Doe', 'john@example.com', SHA2('password123', 256), 'Customer'),
('Admin User', 'admin@example.com', SHA2('adminpass', 256), 'Admin');

-- إضافة بيانات افتراضية إلى جدول الحجوزات
INSERT INTO Bookings (UserID, RoomID, CheckInDate, CheckOutDate) VALUES
(1, 1, '2025-01-10', '2025-01-15'),
(1, 3, '2025-02-01', '2025-02-05');
