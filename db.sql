CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  firstName VARCHAR(50) NOT NULL,
  lastName VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  pwd VARCHAR(255) NOT NULL,
  isVerified TINYINT(1) NOT NULL DEFAULT 0,
  phone VARCHAR(15),
  userRole ENUM('student', 'landlord', 'admin') NOT NULL DEFAULT 'student',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE user_documents(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  userId INT,
  name VARCHAR(50),
  document MEDIUMTEXT,
  FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE property (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  userId INT,
  name VARCHAR(50) NOT NULL,
  description VARCHAR(255) NOT NULL,
  type VARCHAR(50) NOT NULL,
  FOREIGN KEY (userId) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE unit (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  propertyId INT,
  type VARCHAR(50) NOT NULL,
  numberOfRooms INT NOT NULL,
  quantity INT NOT NULL,
  isAvailable BOOLEAN NOT NULL DEFAULT 1,
  monthlyPrice INT NOT NULL,
  FOREIGN KEY (propertyId) REFERENCES property(id) ON DELETE SET NULL
);

CREATE TABLE unit_images (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  unitId INT,
  image MEDIUMTEXT,
  FOREIGN KEY (unitId) REFERENCES unit(id) ON DELETE CASCADE
);

CREATE TABLE facility (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description VARCHAR(255) NOT NULL
);

CREATE TABLE unit_facility (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  propertyId INT,
  facilityId INT,
  state VARCHAR(50),
  FOREIGN KEY (propertyId) REFERENCES property(id) ON DELETE SET NULL,
  FOREIGN KEY (facilityId) REFERENCES facility(id) ON DELETE SET NULL
);

CREATE TABLE favorites (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  userId INT,
  unitId INT,
  FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (unitId) REFERENCES unit(id) ON DELETE CASCADE
);

CREATE TABLE reservation (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  userId INT,
  unitId INT,
  startDate DATETIME NOT NULL,
  endDate DATETIME NOT NULL,
  FOREIGN KEY (userId) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (unitId) REFERENCES unit(id) ON DELETE SET NULL
);

CREATE TABLE payment (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  reservationId INT,
  paymentDate DATETIME NOT NULL,
  amount INT NOT NULL,
  paymentMethod VARCHAR(50) NOT NULL,
  FOREIGN KEY (reservationId) REFERENCES reservation(id) ON DELETE SET NULL
);

CREATE TABLE message (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  senderId INT,
  receiverId INT,
  text MEDIUMTEXT,
  FOREIGN KEY (senderId) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (receiverId) REFERENCES users(id) ON DELETE SET NULL
);