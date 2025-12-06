# FoodResQ

FoodResQ is a platform designed to connect food sellers (such as bakeries, restaurants, and cafes) with buyers, aiming to reduce food waste by facilitating the sale of surplus food items at discounted prices.

## API Documentation

Below is the list of available API endpoints for the FoodResQ backend, including required request fields and response structures.

### Buyers

#### 1. Register Buyer
**Endpoint:** `POST /buyers/register`
**Description:** Register a new buyer account.

**Request Body:**
- `name` (string, required): Full name of the buyer.
- `email` (string, required, unique): Valid email address.
- `password` (string, required, min: 8 chars): Password for the account.
- `phone` (string, optional): Phone number.
- `address` (string, optional): Physical address.
- `latitude` (numeric, optional): Latitude coordinate.
- `longitude` (numeric, optional): Longitude coordinate.

**Response:**
- `message`: Success message.
- `data`: created buyer object (id, name, email, phone, address, latitude, longitude, created_at, updated_at).

#### 2. Get All Buyers
**Endpoint:** `GET /buyers`
**Description:** Retrieve a list of all registered buyers.

**Response:**
- `message`: Success message.
- `data`: Array of buyer objects.

#### 3. Get Buyer Details
**Endpoint:** `GET /buyers/{id}`
**Description:** Retrieve details of a specific buyer by their UUID.

**Response:**
- `message`: Success message (or "Buyer not found").
- `data`: Buyer object.

---

### Sellers

#### 1. Register Seller
**Endpoint:** `POST /sellers/register`
**Description:** Register a new seller account.

**Request Body:**
- `email` (string, required, unique): Valid email address.
- `password` (string, required, min: 8 chars): Password.
- `phone` (string, optional): Phone number.
- `business_name` (string, required): Name of the business.
- `business_type` (string, required): Type of business. Valid values: `BAKERY`, `RESTAURANT`, `CAFE`, `GROCERY`, `CATERING`, `DESSERT`, `FAST_FOOD`, `OTHER`.
- `description` (string, optional): Description of the business.
- `address` (string, required): Business address.
- `latitude` (numeric, required): Latitude coordinate.
- `longitude` (numeric, required): Longitude coordinate.
- `operating_hours` (array, required): Array of operating hours (e.g., `[{"day": "Monday", "open": "08:00", "close": "20:00"}]`).

**Response:**
- `message`: Success message.
- `data`: Created seller object.

#### 2. Get All Sellers
**Endpoint:** `GET /sellers`
**Description:** Retrieve a paginated list of all sellers (15 per page).

**Response:**
- `message`: Success message.
- `data`: Paginated seller object (containing `data` array, `current_page`, `last_page`, etc.).

#### 3. Get Seller Details
**Endpoint:** `GET /sellers/{id}`
**Description:** Retrieve details of a specific seller by UUID.

**Response:**
- `message`: Success message.
- `data`: Seller object.

---

### Foods

#### 1. Create Food Item
**Endpoint:** `POST /foods`
**Description:** Create a new surplus food listing.

**Request Body:**
- `seller_id` (string, required): UUID of the seller (must exist).
- `title` (string, required): Name of the food item.
- `description` (string, required): Description of the item.
- `category` (string, required): Food category. Valid values: `BAKERY`, `RESTAURANT`, `CAFE`, `GROCERY`, `CATERING`, `DESSERT`, `FAST_FOOD`, `OTHER`.
- `image_url` (string, required): URL of the food image.
- `original_price` (numeric, required): Original price before discount.
- `discounted_price` (numeric, required): Price after discount.
- `discount_percentage` (integer, required): Percentage of discount.
- `quantity` (integer, required): Total quantity available.
- `available_quantity` (integer, required): Currently available quantity.
- `pickup_time_start` (date/datetime, required): Start time for pickup.
- `pickup_time_end` (date/datetime, required): End time for pickup.

**Response:**
- `message`: Success message.
- `data`: Created food object.

#### 2. Get All Foods
**Endpoint:** `GET /foods`
**Description:** Retrieve a paginated list of all food items (10 per page).

**Response:**
- `message`: Success message.
- `data`: Paginated food object.

#### 3. Get Food Details
**Endpoint:** `GET /foods/{id}`
**Description:** Retrieve details of a specific food item.

**Response:**
- `message`: Success message.
- `data`: Food object.

#### 4. Update Food Item
**Endpoint:** `PUT /foods/{id}`
**Description:** Update an existing food item.

**Request Body** (All fields are optional, provide only what needs updating):
- `title`, `description`, `category`, `image_url`, `original_price`, `discounted_price`, `discount_percentage`, `quantity`, `available_quantity`, `pickup_time_start`, `pickup_time_end`.
- `is_active` (boolean): Set to `false` to deactivate.

**Response:**
- `message`: Success message.
- `data`: Updated food object.

#### 5. Delete Food Item
**Endpoint:** `DELETE /foods/{id}`
**Description:** Delete a food item.

**Response:**
- `message`: "Food deleted successfully".

#### 6. Get Foods by Seller
**Endpoint:** `GET /sellers/{sellerId}/foods`
**Description:** Retrieve food items for a specific seller (Paginated).

**Response:**
- `message`: Success message.
- `data`: Paginated food object.

#### 7. Get Foods by Category
**Endpoint:** `GET /foods/category/{category}`
**Description:** Retrieve food items belonging to a specific category (Paginated).

**Response:**
- `message`: Success message.
- `data`: Paginated food object.

---

### Transactions

#### 1. Create Transaction
**Endpoint:** `POST /transactions`
**Description:** Create a new purchase transaction.

**Request Body:**
- `buyer_id` (string, required): UUID of the buyer.
- `seller_id` (string, required): UUID of the seller.
- `food_id` (string, required): UUID of the food item.
- `quantity` (integer, required): Quantity to purchase (must be at least 1).
- `total_price` (numeric, required): Total price for the transaction.
- `payment_method` (string, required): Payment method. Valid values: `CASH`, `TRANSFER`, `E_WALLET`, `CREDIT_CARD`.
- `pickup_time` (date/datetime, required): Scheduled pickup time.

**Response:**
- `message`: Success message or error if insufficient quantity.
- `data`: Created transaction object (includes `order_number`, `pickup_code`, `status`='PENDING').

#### 2. Get Buyer Transactions
**Endpoint:** `GET /buyers/{buyerId}/transactions`
**Description:** Retrieve transaction history for a specific buyer (Paginated).

**Response:**
- `message`: Success message.
- `data`: Paginated transaction object.

#### 3. Get Seller Transactions
**Endpoint:** `GET /sellers/{sellerId}/transactions`
**Description:** Retrieve transaction history for a specific seller (Paginated).

**Response:**
- `message`: Success message.
- `data`: Paginated transaction object.

#### 4. Update Transaction Status
**Endpoint:** `PUT /transactions/{id}/status`
**Description:** Update the status of a transaction.

**Request Body:**
- `status` (string, required): New status. Valid values: `PENDING`, `PAID`, `READY_FOR_PICKUP`, `COMPLETED`, `CANCELLED`.

**Important:**
- When status is changed to `PAID`, the system automatically reduces the `available_quantity` of the associated food item.
- `PAID` sets `paid_at` timestamp and `payment_status` to 'success'.
- `COMPLETED` sets `completed_at` timestamp.
- `CANCELLED` sets `cancelled_at` timestamp.

**Response:**
- `message`: Success message.
- `data`: Updated transaction object.
