DROP DATABASE GAMEPOINT;
-- Step 1: Create the Database
CREATE DATABASE GAMEPOINT;

-- Step 2: Use the Created Database
USE GAMEPOINT;

-- Step 3: Create Tables
-- Starting with tables that don't depend on others

-- Admin Table - no dependencies
CREATE TABLE Admin (
    AdminID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255) NOT NULL,
    Email VARCHAR(255) UNIQUE NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Role VARCHAR(50)
);

-- Category Table - no dependencies
CREATE TABLE Category (
    CategoryID INT PRIMARY KEY AUTO_INCREMENT,
    CategoryName VARCHAR(255) NOT NULL
);

-- RegisteredCustomer Table - no dependencies
CREATE TABLE RegisteredCustomer (
    RegisteredCustomerID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255) NOT NULL,
    Email VARCHAR(255) UNIQUE NOT NULL,
    Password VARCHAR(255) NOT NULL,
    RegistrationDate DATE NOT NULL
);

-- UnregisteredCustomer Table - no dependencies
CREATE TABLE UnregisteredCustomer (
    UnregisteredCustomerID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL
);

-- Product Table - depends on Category
CREATE TABLE Product (
    ProductID INT PRIMARY KEY AUTO_INCREMENT,
    ModelNumber VARCHAR(255) UNIQUE NOT NULL,
    Name VARCHAR(255) NOT NULL,
    Description TEXT,
    Price DECIMAL(10, 2) NOT NULL,
    Supplier VARCHAR(255),
    CategoryID INT NOT NULL,
    ImageURL TEXT,
    StockQuantity INT NOT NULL,
    FOREIGN KEY (CategoryID) REFERENCES Category(CategoryID)
);

-- Inventory Table - depends on Product
CREATE TABLE Inventory (
    InventoryID INT PRIMARY KEY AUTO_INCREMENT,
    ProductID INT NOT NULL,
    ThresholdLevel INT NOT NULL,
    Status VARCHAR(50),
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID)
);

-- InventoryAlert Table - depends on Inventory
CREATE TABLE InventoryAlert (
    AlertID INT PRIMARY KEY AUTO_INCREMENT,
    InventoryID INT NOT NULL,
    AlertType VARCHAR(50),
    AlertDate DATE NOT NULL,
    FOREIGN KEY (InventoryID) REFERENCES Inventory(InventoryID)
);

-- Basket Table - depends on RegisteredCustomer
CREATE TABLE Basket (
    BasketID INT PRIMARY KEY AUTO_INCREMENT,
    CustomerID INT NOT NULL,
    CreatedDate DATE NOT NULL
);

-- Payment Table - needs to be created before Order due to circular reference
CREATE TABLE Payment (
    PaymentID INT PRIMARY KEY AUTO_INCREMENT,
    OrderID INT,
    PaymentDate DATE NOT NULL,
    Amount DECIMAL(10, 2) NOT NULL,
    Method VARCHAR(50) NOT NULL
);

-- Order Table - depends on Payment
CREATE TABLE `Order` (
    OrderID INT PRIMARY KEY AUTO_INCREMENT,
    CustomerID INT,
    TotalPrice DECIMAL(10, 2) NOT NULL,
    OrderDate DATE NOT NULL,
    OrderStatus VARCHAR(50) NOT NULL,
    ShippingDate DATE,
    PaymentID INT,
    FOREIGN KEY (PaymentID) REFERENCES Payment(PaymentID)
);

-- Now add the foreign key to Payment that references Order
ALTER TABLE Payment
ADD FOREIGN KEY (OrderID) REFERENCES `Order`(OrderID);

-- Checkout Table - depends on Order
CREATE TABLE Checkout (
    CheckoutID INT PRIMARY KEY AUTO_INCREMENT,
    OrderID INT,
    ShippingDate DATE,
    BillingAddress VARCHAR(255),
    ShippingAddress VARCHAR(255),
    FOREIGN KEY (OrderID) REFERENCES `Order`(OrderID)
);

-- OrderItem Table - depends on Order and Product
CREATE TABLE OrderItem (
    OrderItemID INT PRIMARY KEY AUTO_INCREMENT,
    OrderID INT NOT NULL,
    ProductID INT NOT NULL,
    Quantity INT NOT NULL,
    ItemPrice DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (OrderID) REFERENCES `Order`(OrderID),
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID)
);

-- BasketItem Table - depends on Basket and Product
CREATE TABLE BasketItem (
    BasketItemID INT PRIMARY KEY AUTO_INCREMENT,
    BasketID INT NOT NULL,
    ProductID INT NOT NULL,
    Quantity INT NOT NULL,
    FOREIGN KEY (BasketID) REFERENCES Basket(BasketID),
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID)
);

-- Review Table - depends on RegisteredCustomer and Product
CREATE TABLE Review (
    ReviewID INT PRIMARY KEY AUTO_INCREMENT,
    CustomerID INT NOT NULL,
    ProductID INT NOT NULL,
    ReviewText TEXT,
    Rating INT CHECK (Rating BETWEEN 1 AND 5),
    FOREIGN KEY (CustomerID) REFERENCES RegisteredCustomer(RegisteredCustomerID),
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID)
);

-- Discount Table - no dependencies
CREATE TABLE Discount (
    DiscountID INT PRIMARY KEY AUTO_INCREMENT,
    Rate DECIMAL(5, 2) NOT NULL,
    Description TEXT,
    ValidUntil DATE
);

-- OrderHistory Table - depends on RegisteredCustomer and Order
CREATE TABLE OrderHistory (
    OrderHistoryID INT PRIMARY KEY AUTO_INCREMENT,
    CustomerID INT NOT NULL,
    OrderID INT NOT NULL,
    Action VARCHAR(50),
    ActionDate DATE NOT NULL,
    FOREIGN KEY (CustomerID) REFERENCES RegisteredCustomer(RegisteredCustomerID),
    FOREIGN KEY (OrderID) REFERENCES `Order`(OrderID)
);

-- Wishlist Table - depends on RegisteredCustomer
CREATE TABLE Wishlist (
    WishlistID INT PRIMARY KEY AUTO_INCREMENT,
    CustomerID INT NOT NULL,
    CreatedDate DATE NOT NULL,
    FOREIGN KEY (CustomerID) REFERENCES RegisteredCustomer(RegisteredCustomerID)
);

-- WishlistItem Table - depends on Wishlist and Product
CREATE TABLE WishlistItem (
    WishlistItemID INT PRIMARY KEY AUTO_INCREMENT,
    WishlistID INT NOT NULL,
    ProductID INT NOT NULL,
    AddedDate DATE NOT NULL,
    FOREIGN KEY (WishlistID) REFERENCES Wishlist(WishlistID),
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID)
);