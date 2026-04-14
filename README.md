# WolfNet

A Netflix-inspired video streaming platform built for the Tunisian market.
Developed as a 2nd year university project at Faculté des Sciences de Tunis,
GLSI2/LCS2, academic year 2025/2026, supervised by Prof. Faouzi MOUSSA.

---

## Problem Statement

Tunisian users cannot access international streaming platforms due to
international card requirements and resort to illegal streaming sites.
WolfNet offers legal streaming with local Tunisian payment via Flouci.

---

## Infrastructure

- **VM1** (192.168.56.101): Primary app server + Nginx load balancer + MySQL master
- **VM2** (192.168.56.102): Backup app server + MySQL slave
- **Keepalived VIP** (192.168.56.100): Active/passive failover — if VM1 goes down,
  VM2 takes over automatically. Configured in Unicast mode (required for VirtualBox)
  with `nopreempt` to prevent unnecessary VIP failback on VM1 reboot.
- **Nginx**: Sticky session load balancing (`ip_hash`) on port 80 → VM1:8080 and
  VM2:8080. Ensures each client is consistently routed to the same backend node.
- **MySQL**: Master/slave binary log replication for data redundancy
- **Ansible**: Automated deployment — single command deploys to both VMs

---

## Features

- Browse and search content catalog (title, genre, language, type)
- TMDB API integration — import real content metadata directly from admin panel
- User registration and session-based authentication (Laravel Breeze)
- Subscription plans with Flouci payment gateway integration
- Premium content paywall with subscription state enforcement
- Early renewal support — queued subscriptions start after current period ends
- Immediate cancellation with no refund (Flouci sandbox limitation)
- Video streaming with resume playback (watched_seconds tracking)
- Personal watchlist (add/remove bookmarks)
- Watch history with progress tracking
- User profile management (name and password only — email is immutable)
- Admin dashboard: content management, user management, plan management,
  subscription overview, payment log, TMDB import tool

---

## Tech Stack

- **Backend**: Laravel 11.x, PHP 8.3, Eloquent ORM
- **Frontend**: Blade templating, Tailwind CSS, vanilla JavaScript
- **Database**: MySQL 8.0 (master/slave replication)
- **Web server**: Nginx 1.24
- **Deployment**: Ansible
- **OS**: Ubuntu Server 24.04 LTS
- **Payment**: Flouci (Tunisian gateway, sandbox)
- **Auth**: Laravel Breeze (session-based)
- **Content API**: TMDB (The Movie Database)

---

## HA Cluster Configuration Notes

### Session Management
Sessions are stored in the database (`SESSION_DRIVER=database`) and shared via
the MySQL master instance. This ensures session continuity regardless of which
VM handles the request.

### Application Identity
Both VMs must share an identical `APP_KEY` in their `.env` files. Mismatched
keys cause session cookies to be rejected by the other node.

### Trusted Proxies
`bootstrap/app.php` is configured to trust all proxies:
```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->trustProxies(at: '*');
})
```
This allows Laravel to correctly read `X-Forwarded-*` headers from Nginx,
preventing 419 CSRF errors on POST requests.

### Asset Synchronization
Vite generates hashed filenames during `npm run build`. To prevent CSS/JS 404s,
the `public/build` directory must be built on VM1 and synced to VM2 via `scp`
after every production build:
```bash
scp -r /var/www/html/wolfnet/public/build vm1@192.168.56.102:/var/www/html/wolfnet/public/
```

### Unified Entry Point
Both VMs use `APP_URL=http://192.168.56.100` (the Keepalived VIP) so all
generated links and redirects point to the cluster entry point, not individual
VM IPs.

### Firewall Rules (UFW)
Both VMs allow:
- Port 80 (HTTP)
- Port 8080 (internal load balancer traffic)
- VRRP protocol (Keepalived heartbeat)
- Traffic from 192.168.56.101 and 192.168.56.102

---

## Deployment

```bash
ansible-playbook -i hosts.ini deploy.yml
```

After deployment, sync build assets from VM1 to VM2:
```bash
scp -r /var/www/html/wolfnet/public/build vm1@192.168.56.102:/var/www/html/wolfnet/public/
sudo chown -R www-data:www-data /var/www/html/wolfnet/public/build
```

---

## Local Development

```bash
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm run dev
php artisan serve
```

---

## Environment Variables Required

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=http://192.168.56.100
SESSION_DRIVER=database
DB_HOST=192.168.56.101
FLOUCI_APP_TOKEN=your_sandbox_token
FLOUCI_APP_SECRET=your_sandbox_secret
TMDB_API_KEY=your_tmdb_read_access_token
TMDB_BASE_URL=https://api.themoviedb.org/3
TMDB_IMAGE_BASE=https://image.tmdb.org/t/p/w500
```

---

## Test Credentials (Demo Only)