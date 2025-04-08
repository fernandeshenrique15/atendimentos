SELECT 'CREATE DATABASE atendimentos'
WHERE NOT EXISTS (SELECT FROM pg_database WHERE datname = 'atendimentos')\gexec
