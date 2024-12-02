[⌂ Home](README.md)
[▲ Previous: Preparing](preparing.md)

## Managing schema

**Database**

```mariadb
MariaDB [(none)]> show databases;
+--------------------+
| Database           |
+--------------------+
| information_schema |
| mysql              |
| performance_schema |
| test               |
+--------------------+
4 rows in set (0,001 sec)

```

### Creating schema

**Console**

```bash
php bin/doctrine orm:schema-tool:create
```

```

 !
 ! [CAUTION] This operation should not be executed in a production environment!
 !

 Creating database schema...


 [OK] Database schema created successfully!


```

**Database**

```mariadb
MariaDB [doctrinelab]> show databases;
+--------------------+
| Database           |
+--------------------+
| doctrinelab        |
| information_schema |
| mysql              |
| performance_schema |
| test               |
+--------------------+
5 rows in set (0,001 sec)

```

### Deleting schema

**Console**

```bash
php bin/doctrine orm:schema-tool:drop --force
```

```
 Dropping database schema...


 [OK] Database schema dropped successfully!


```

**Database**

```mariadb
MariaDB [doctrinelab]> show databases;
+--------------------+
| Database           |
+--------------------+
| doctrinelab        |
| information_schema |
| mysql              |
| performance_schema |
| test               |
+--------------------+
5 rows in set (0,001 sec)

```

Database still exists but all the existing tables would be removed.

### Updating Schema

**Console**

```bash
php bin/doctrine orm:schema-tool:update --force
```
