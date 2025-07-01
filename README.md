# MyItinerary

**MyItinerary** is a Laravel-based web application that allows users to create, manage, and save personalized travel itineraries with multiple stages (stops). Registered users can build, edit, and explore itineraries, while admins manage cities. The app includes advanced search features, live filters, and full form validation to ensure a smooth and user-friendly experience.

---

## Features & Development Status

> ✅ = fully implemented and tested as of **June 26, 2025**

### User Roles

#### ✅ Guest (All Visitors)

* 🔎 **Search** itineraries by name or city (with pagination)
* ✅ View search results
* If logged in:

  * View recent searches
  * Save itineraries to favorites
  * Remove saved itineraries

#### ✅ Registered User

* ✏️ **Manage Itineraries**

  * Create itinerary with title and city

    * Add stages (stops)
    * ✅ Client-side validation
  * View & filter own itineraries (live search by title/city)
  * View itinerary details
  * Edit itinerary:

    * ✅ Edit basic info
    * ✅ Edit/add/delete stages
    * ✅ Changes trigger update button dynamically
  * Delete itinerary (with confirmation)
* **Stages (Stops)**

  * Add stages when creating or editing an itinerary
  * ✅ Edit or delete individual stages
* **Saved Itineraries**

  * ✅ View and manage saved itineraries
  * ✅ Live search and detail view
* **Authentication**

  * ✅ Login
  * ✅ Register
  * ✅ Logout
  * ✅ All form validations implemented (missing fields, invalid formats, duplicate emails, etc.)

#### ✅ Admin

* **Manage Cities**

  * ✅ Search by country and region (AJAX)
  * ✅ Live city search
  * ✅ Pagination with JavaScript
  * ✅ Add, edit, delete (with confirmation)
  * ✅ Full form validation (required fields, duplicate names, format checks)

---

## Database Schema

| Entity             | Fields                                                                           |
| ------------------ | -------------------------------------------------------------------------------- |
| **User**           | id, name, email, password, role (`registered_user` / `admin`)                    |
| **Itinerary**      | id, title, city\_id, visibility (`public` / `private`), creator\_id              |
| **Stage**          | id, location, cost (nullable), description, duration (in minutes), itinerary\_id |
| **SavedItinerary** | id, user\_id, itinerary\_id                                                      |
| **City**           | id, name, region, country                                                        |
| **Search**         | id, search\_string, user\_id                                                     |

---

## Available APIs

> Authentication and role checks required.

### Admin-Only

* Get cities
* Search cities by:

  * Country name
  * Country + Region name

### Registered Users

* Get all itineraries
* Search itineraries by title

---

## Tech Stack

* **Backend**: Laravel
* **Frontend**: Blade + JavaScript (AJAX, live search, pagination)
* **Database**: MySQL
* **Authentication**: Laravel Auth (Breeze and Sanctum)
* **Validation**: Server-side + client-side (JS, required fields, format control)

---

## 📅 Project Status

All core functionalities and validations were **completed and tested as of June 26, 2025**.
MyItinerary is ready to be deployed or extended with additional features.