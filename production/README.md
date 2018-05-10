
## Usage

1. set your own mysql password

```bash
cp example.mysql.env .mysql.env
vi .mysql.env
```

2. let the php know all containers

```bash
cp example.php.env .php.env
# you also can add whatever you want to this file
vim .php.env
```

## Data

All datas should be in `/data/*` directory.

## Configurations

There are some in the `docker-compose.yml` file, containers's conf is in the `/conf/*`. I also write some examples, to make sure I don't foget how to use.
