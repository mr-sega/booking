## How would you deploy such an application?

I would deploy it using a VPS or cloud service like DigitalOcean, AWS, or Render.  
The backend (Laravel) can run under Nginx or Apache, using PHP-FPM and MySQL/PostgreSQL.  
The frontend (Inertia + Vue + Vite) can be built and served via Laravel’s public directory.  
For continuous deployment, I would use GitHub Actions or GitLab CI to run tests and push updates automatically.

---

## How would you cache frequently requested API responses?

I would use Laravel’s built-in caching system with Redis or Memcached.  
For example, cache the result of frequent queries using `Cache::remember()`.  
Additionally, HTTP-level caching (ETags, `Cache-Control` headers) could be applied to reduce load on the server.

---

## If you had more time, what strategies would you consider when building the API?

I would add versioning (`/api/v1/...`), pagination, rate limiting, and authentication (JWT or Sanctum).  
Also, I’d implement proper error handling and use API Resources for consistent response formatting.  
For scalability, I’d consider background jobs, queue workers, and database indexing for heavy operations.
