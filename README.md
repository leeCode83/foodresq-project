# FoodResQ

FoodResQ is a platform designed to connect food sellers (such as bakeries, restaurants, and cafes) with buyers, aiming to reduce food waste by facilitating the sale of surplus food items at discounted prices.

## API Documentation

Below is the list of available API endpoints for the FoodResQ backend.

### Buyers

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `POST` | `/buyers/register` | Register a new buyer. |
| `GET` | `/buyers` | Retrieve a list of all buyers. |
| `GET` | `/buyers/{id}` | Retrieve details of a specific buyer by UUID. |

### Sellers

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `POST` | `/sellers/register` | Register a new seller. |
| `GET` | `/sellers` | Retrieve a list of all sellers (Paginated, 15 per page). |
| `GET` | `/sellers/{id}` | Retrieve details of a specific seller by UUID. |

### Foods

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `POST` | `/foods` | Create a new food item. |
| `GET` | `/foods` | Retrieve all food items (Paginated, 10 per page). |
| `GET` | `/foods/{id}` | Retrieve details of a specific food item. |
| `PUT` | `/foods/{id}` | Update a food item. |
| `DELETE` | `/foods/{id}` | Delete a food item. |
| `GET` | `/sellers/{sellerId}/foods` | Retrieve food items for a specific seller (Paginated, 10 per page). |
| `GET` | `/foods/category/{category}` | Retrieve food items by category (Paginated, 10 per page). |

### Transactions

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `POST` | `/transactions` | Create a new transaction. |
| `GET` | `/buyers/{buyerId}/transactions` | Retrieve transactions for a specific buyer (Paginated, 10 per page). |
| `GET` | `/sellers/{sellerId}/transactions` | Retrieve transactions for a specific seller (Paginated, 10 per page). |
| `PUT` | `/transactions/{id}/status` | Update transaction status. **Note:** Setting status to `PAID` automatically reduces food stock. |
