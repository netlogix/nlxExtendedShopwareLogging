## nlxExtendedShopwareLogging

A Shopware 5 Plugin to extend the shopware logging.

### ENV Variablen

There are 2 environment variables:

    NLX_LOG_FEATURES=cron
    NLX_LOG_LEVEL=debug

### NLX_LOG_FEATURES
`NLX_LOG_FEATURES` is a comma seperated list of logger that should be loaded.

Available features are:

- cron
- routing

#### Example

    NLX_LOG_FEATURES=cron,routing

### NLX_LOG_LEVEL
`NLX_LOG_LEVEL` is the log level of the used features. Log level can be upper or lowercase.

Available log levels are:

- EMERGENCY
- ALERT
- CRITICAL
- ERROR
- WARNING
- NOTICE
- INFO
- DEBUG

#### Example

    NLX_LOG_LEVEL=INFO

Or

    NLX_LOG_LEVEL=info