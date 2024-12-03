
USE cs2team8_db;

-- registered customers table

CREATE TABLE RegCustomer (
    regCustomerID INT PRIMARY KEY AUTO_INCREMENT,
    fullName VARCHAR(255) NOT NULL,
    Email VARCHAR(255) UNIQUE NOT NULL,
    Password VARCHAR(255) NOT NULL,
    RegistrationDate DATE NOT NULL
);

-- unregistered customers table

CREATE TABLE UnregCustomer (
    unregCustomerID INT PRIMARY KEY AUTO_INCREMENT,
    fullName VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL
);

-- employee table

CREATE TABLE Employee (
    employeeID INT PRIMARY KEY AUTO_INCREMENT,
    fullName VARCHAR(255) NOT NULL,
    Email VARCHAR(255) UNIQUE NOT NULL,
    Password VARCHAR(255) NOT NULL,
    position VARCHAR(50)
);

-- categories table

CREATE TABLE Category (
    categoryID INT PRIMARY KEY AUTO_INCREMENT,
    categoryName VARCHAR(255) NOT NULL
);

-- payments table

CREATE TABLE Payment (
    paymentID INT PRIMARY KEY AUTO_INCREMENT,
    orderID INT,
    paymentDate DATE NOT NULL,
    Amount DECIMAL(10, 2) NOT NULL,
    paymentMethod VARCHAR(50) NOT NULL
);

-- basket table

CREATE TABLE Basket (
    basketID INT PRIMARY KEY AUTO_INCREMENT,
    customerID INT NOT NULL,
    createdDate DATE NOT NULL
);

-- discounts table

CREATE TABLE Discount (
    discountID INT PRIMARY KEY AUTO_INCREMENT,
    Rate DECIMAL(5, 2) NOT NULL,
    Description TEXT,
    validUntil DATE
);

-- products table

CREATE TABLE Products (
    productID INT PRIMARY KEY AUTO_INCREMENT,
    ModelNo VARCHAR(255) UNIQUE NOT NULL,
    fullName VARCHAR(255) NOT NULL,
    Description TEXT,
    Price DECIMAL(10, 2) NOT NULL,
    Supplier VARCHAR(255),
    categoryID INT NOT NULL,
    imgURL TEXT,
    stockQuantity INT NOT NULL,
    FOREIGN KEY (categoryID) REFERENCES Category(categoryID)
);

-- basket items table

CREATE TABLE BasketItem (
    basketItemID INT PRIMARY KEY AUTO_INCREMENT,
    basketID INT NOT NULL,
    productID INT NOT NULL,
    Quantity INT NOT NULL,
    FOREIGN KEY (basketID) REFERENCES Basket(basketID),
    FOREIGN KEY (productID) REFERENCES Products(productID)
);


-- inventory table

CREATE TABLE Inventory (
    inventoryID INT PRIMARY KEY AUTO_INCREMENT,
    thresholdLevel INT NOT NULL,
    productID INT NOT NULL,
    status VARCHAR(50),
    FOREIGN KEY (productID) REFERENCES Products(productID)
);

-- inventory alert table

CREATE TABLE InventoryAlert (
    alertID INT PRIMARY KEY AUTO_INCREMENT,
    inventoryID INT NOT NULL,
    alertType VARCHAR(50),
    alertDate DATE NOT NULL,
    FOREIGN KEY (inventoryID) REFERENCES Inventory(inventoryID)
);

-- orders table

CREATE TABLE Orders (
    orderID INT PRIMARY KEY AUTO_INCREMENT,
    customerID INT,
    totalPrice DECIMAL(10, 2) NOT NULL,
    orderDate DATE NOT NULL,
    orderStatus VARCHAR(50) NOT NULL,
    shippingDate DATE,
    paymentID INT,
    FOREIGN KEY (paymentID) REFERENCES Payment(paymentID)
);

-- order item table

CREATE TABLE OrderItem (
    orderItemID INT PRIMARY KEY AUTO_INCREMENT,
    orderID INT NOT NULL,
    productID INT NOT NULL,
    Quantity INT NOT NULL,
    itemPrice DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (orderID) REFERENCES Orders(orderID),
    FOREIGN KEY (productID) REFERENCES Products(productID)
);



-- -- reviews table

-- CREATE TABLE Review (
-- ReviewID INT PRIMARY KEY AUTO_INCREMENT,
-- CustomerID INT NOT NULL,
-- ProductID INT NOT NULL,
-- ReviewText TEXT,
-- Rating INT CHECK (
--     Rating BETWEEN 1 AND 5
-- ),
-- FOREIGN KEY (CustomerID) REFERENCES RegisteredCustomer(RegisteredCustomerID),
-- FOREIGN KEY (ProductID) REFERENCES Product(ProductID)
-- );


-- order history table

CREATE TABLE OrderHistory (
    orderHistoryID INT PRIMARY KEY AUTO_INCREMENT,
    customerID INT NOT NULL,
    orderID INT NOT NULL,
    Action VARCHAR(50),
    ActionDate DATE NOT NULL,
    FOREIGN KEY (customerID) REFERENCES RegCustomer(regCustomerID),
    FOREIGN KEY (orderID) REFERENCES Orders(orderID)
);
-- wishlist table

CREATE TABLE Wishlist (
    wishlistID INT PRIMARY KEY AUTO_INCREMENT,
    customerID INT NOT NULL,
    createdDate DATE NOT NULL,
    FOREIGN KEY (customerID) REFERENCES RegCustomer(regCustomerID)
);
-- wishlist item table

CREATE TABLE WishlistItem (
    wishlistItemID INT PRIMARY KEY AUTO_INCREMENT,
    wishlistID INT NOT NULL,
    productID INT NOT NULL,
    addDate DATE NOT NULL,
    FOREIGN KEY (wishlistID) REFERENCES Wishlist(wishlistID),
    FOREIGN KEY (productID) REFERENCES Products(productID)
);