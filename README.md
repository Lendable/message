# Message

Fundamental building blocks for message based systems.

## Local development

The Docker-based environment is defined in `local/` and driven from the `Makefile`:

```shell
make up      # builds the image (on first run) and starts the container
make shell   # opens a shell inside the container, in /app
make down    # stops and removes the container
```

From the shell:

```shell
composer install
composer ci
```

See the `Makefile` for the remaining targets.

### Xdebug

Xdebug is installed but disabled by default. Copy `local/.env.dist` to
`local/.env`, set `XDEBUG_ENABLED=1` (optionally with `XDEBUG_HOST`,
`XDEBUG_PORT` and `XDEBUG_IDE_KEY`), then run `make restart`.
