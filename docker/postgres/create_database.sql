SELECT 'CREATE DATABASE laravel_portfolio'
    WHERE NOT EXISTS (SELECT FROM pg_database WHERE datname = 'laravel_portfolio')
