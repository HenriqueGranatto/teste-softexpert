#/bin/bash

createdb market
psql market < /docker-entrypoint-initdb.d/market.dump