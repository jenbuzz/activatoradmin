#!/bin/bash
phploc ../lib --exclude=Slim --exclude=Psr --exclude=Monolog --exclude=FastRoute --exclude=Interop --exclude=Pimple --exclude=Twig --log-csv phploc.csv
