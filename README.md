# WolfNet
A premium, dark-themed streaming platform built with Laravel 11. 

WolfNet offers a complete, end-to-end solution for a video-on-demand (VOD) platform, similar to Netflix or Flixer. It handles everything from user authentication and subscription management to automated content aggregation from TMDB (The Movie Database).

## Features

- **Premium UI/UX:** A "dark mode first", highly responsive interface utilizing Tailwind CSS v4 and Alpine.js. Includes a sticky glassmorphic navbar, rich content carousels, hover-based preview cards, and dynamic video progress tracking.
- **TMDB API Integration:** 
  - **Manual Import:** A dedicated Admin UI to search for any Movie or TV Show on TMDB and instantly import it with all metadata (genres, posters, backdrop images, TMDB star rating).
  - **Automated Sync:** A built-in Laravel Scheduler (`tmdb:import`) runs daily at 3:00 AM to automatically fetch and add the world's top 20 trending titles to your application.
- **Video Player & Progress Tracking:** Tracks exactly where users stopped watching via Ajax requests, and perfectly resumes playback so they never lose their spot. 
- **User Ecosystem:** Profiles, custom Watchlists (with quick add/remove), and visual watch history.
- **Integrated Payments:** Full integration with the Tunisian **Flouci Gateway** to handle premium subscription checkouts, upgrades, and payment tracking.
- **Admin Dashboard:** Total oversight over the platform. Manage users, view subscription/revenue stats, and full CRUD control over the content and plans catalogue. 

## Technology Stack
- **Backend Framework:** Laravel 11 (PHP 8.2+)
- **Database:** MySQL
- **CSS Framework:** Tailwind CSS v4
- **Javascript:** Vanilla JS (Player progress tracking), Alpine.js (UI interactions)
- **Asset Bundler:** Vite
- **External APIs:** The Movie Database (v3), Flouci Gateway

## Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone <repository_url>
   cd my-laravel-app
   ```

2. **Install Composer Dependencies:**
   ```bash
   composer install
   ```

3. **Install NPM Dependencies & Compile Assets:**
   ```bash
   npm install
   npm run build
   ```

4. **Environment Setup:**
   Duplicate the `.env.example` file, rename it to `.env`, and generate the app key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure Variables:**
   Open `.env` and fill in your details:
   - **Database Details** (`DB_CONNECTION`, `DB_DATABASE`, etc)
   - **TMDB API:** 
     `TMDB_API_KEY=your_api_key_here`
     `TMDB_BASE_URL=https://api.themoviedb.org/3`
     `TMDB_IMAGE_BASE=https://image.tmdb.org/t/p/w500`
   - **Flouci Payments:** 
     `FLOUCI_APP_TOKEN=your_token`
     `FLOUCI_APP_SECRET=your_secret`

6. **Run Migrations & Seeders:**
   ```bash
   php artisan migrate --seed
   ```

## ⏱️ Scheduled Tasks (TMDB Auto-pull)

WolfNet utilizes the Laravel Scheduler to update your catalog with trending titles automatically. 

To ensure the auto-pull triggers at 3:00 AM daily, you must add the following Cron entry to your server:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

If you ever wish to manually force an import of today's trending titles through the command line, run:
```bash
php artisan tmdb:import
```

---
*Built as a state-of-the-art streaming architecture demonstration.*
