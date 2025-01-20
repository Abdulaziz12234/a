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

-- عرض الغرف المتاحة فقط
SELECT RoomNumber, RoomType, Price
FROM Rooms
WHERE IsAvailable = TRUE;

-- استعلام للتحقق من الغرف المتاحة لحجز معين
SELECT RoomID, RoomNumber, RoomType, Price
FROM Rooms
WHERE IsAvailable = TRUE
  AND RoomID NOT IN (
    SELECT RoomID
    FROM Bookings
    WHERE (CheckInDate <= '2025-01-15' AND CheckOutDate > '2025-01-10')
  );

-- ==============================
-- وظائف إدارة الحجوزات للمشرف (Admin)
-- ==============================

-- 1. عرض جميع الحجوزات مع التفاصيل
SELECT 
    b.BookingID,
    u.Name AS CustomerName,
    u.Email AS CustomerEmail,
    r.RoomNumber,
    r.RoomType,
    r.Price,
    b.CheckInDate,
    b.CheckOutDate,
    b.Status,
    b.BookingDate
FROM 
    Bookings b
JOIN 
    Users u ON b.UserID = u.UserID
JOIN 
    Rooms r ON b.RoomID = r.RoomID
ORDER BY 
    b.BookingDate DESC;

-- 2. إضافة حجز جديد (من قبل المشرف)
INSERT INTO Bookings (UserID, RoomID, CheckInDate, CheckOutDate, Status)
VALUES 
    (1, 2, '2025-03-01', '2025-03-05', 'Confirmed');

-- 3. تحديث حالة الحجز (إلغاء حجز)
UPDATE Bookings
SET Status = 'Cancelled'
WHERE BookingID = 1;

-- 4. حذف حجز معين
DELETE FROM Bookings
WHERE BookingID = 2;

-- 5. إجراء مخزن لإضافة حجز جديد مع التحقق من توفر الغرفة
DELIMITER //

CREATE PROCEDURE AddBooking(
    IN p_UserID INT,
    IN p_RoomID INT,
    IN p_CheckInDate DATE,
    IN p_CheckOutDate DATE
)
BEGIN
    -- تحقق من توفر الغرفة
    IF EXISTS (
        SELECT 1 
        FROM Rooms 
        WHERE RoomID = p_RoomID
          AND IsAvailable = TRUE
          AND RoomID NOT IN (
              SELECT RoomID 
              FROM Bookings 
              WHERE (CheckInDate <= p_CheckOutDate AND CheckOutDate > p_CheckInDate)
          )
    ) THEN
        -- إدراج الحجز
        INSERT INTO Bookings (UserID, RoomID, CheckInDate, CheckOutDate, Status)
        VALUES (p_UserID, p_RoomID, p_CheckInDate, p_CheckOutDate, 'Confirmed');
    ELSE
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Room is not available for the selected dates.';
    END IF;
END //

DELIMITER ;

-- استدعاء الإجراء المخزن لإضافة حجز جديد
CALL AddBooking(1, 2, '2025-03-10', '2025-03-15');
