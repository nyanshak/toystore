-- Caution: this script should ONLY be used in a development environment when testing
-- This script contains statements to generate initial test data for DB

source create_db.sql;

-- User: Id, Email, Name, BillingAddress, ShippingAddress, Password

Insert Into `User` (`Id`, `Email`, `Name`, `BillingAddress`, `ShippingAddress`, `Password`) Values
	(1, 'test1@example.com', 'test1name', 'billAddr', 'shipAddr', '$2y$10$oHaz41sa17M6GUBE6V.JR.XcaRcqC58w7u3RH2RKWahuUcUzLkL'); -- This corresponds to password 'test1pass'

-- Category: Id, Name

Insert Into `Category` (`Id`, `Name`) Values
	(1, 'Action Figures'),
	(2, 'Arts & Crafts'),
	(3, 'Baby Toys'),
	(4, 'Bikes'),
	(5, 'Books'),
	(6, 'Building Blocks'),
	(7, 'Clearance'),
	(8, 'Clothes'),
	(9, 'Dolls'),
	(10, 'Guns'),
	(11, 'Karaokes'),
	(12, 'Lego'),
	(13, 'Movies'),
	(14, 'Music'),
	(15, 'Musical Instruments'),
	(16, 'New'),
	(17, 'Other Riding Toys'),
	(18, 'Party Supplies'),
	(19, 'R/C'),
	(20, 'Robotics'),
	(21, 'Scooters'),
	(22, 'Skateboards'),
	(23, 'Stuffed Animals'),
	(24, 'Top'),
	(25, 'Toy Cars'),
	(26, 'Video Games'),
	(27, 'Walkie Talkies');

-- Product: Id, Name, Description, Price, Inventory, Picture (URL)

Insert Into `Product` (`Id`, `Name`, `Description`, `Price`, `Inventory`, `Picture`) Values
	(1, 'Generic Skateboard', '21-inch starting skateboard, perfect for beginners', 36.98, 4, 'https://farm3.staticflickr.com/2145/1877962834_7afe9e1dd1.jpg');

-- Order: Id, OrderDate, Total, Status, UserId

-- OrderItem: Id, OrderId, ProductId

-- ProductToCategory: ProductId, CategoryId
Insert Into `ProductToCategory` (`ProductId`, `CategoryId`) Values
	(1, 22),
	(1, 16);



