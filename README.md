# API service based on Laravel

### Included

- Laravel using Lucid Architecture
    - Code style checkers: Psalm, Larastan, PHPMD, PHP CodeSniffer
    - Cross-Origin Resource Sharing (CORS)
- Laravel Telescope
- Documentation based on `mkdocs`
- Sentry
- API responses based on Laravel Fractal
- JWT authentication
- Logs viewer
- Swagger

### Useful links

Documentation: http://127.0.0.1:8000/docs/
Swagger: http://127.0.0.1:8000/api/v1/swagger/

### Development

What is `task`? It is: https://taskfile.dev

Init:

```
touch db.sqlite
task init_dev
```

Make checks on code style:

```
task code_style
```

Rebuild docs:

```
task docs
```

### Production

Init:

```
task init_prod
```

### A recommended config for opcache

```
[opcache]
opcache.enable=1
opcache.enable_cli=0
opcache.revalidate_freq=0
opcache.validate_timestamps=0
opcache.max_accelerated_files=7963
opcache.memory_consumption=192
opcache.interned_strings_buffer=16
opcache.fast_shutdown=1
opcache.dups_fix=1
```

#### Installing on a CentOS server

Look those instructions: https://github.com/egorsmkv/useful-stuff/tree/master/centos7-bootstrap
