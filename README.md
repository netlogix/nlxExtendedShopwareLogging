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
`NLX_LOG_LEVEL` is the log level of the used features.

Available log levels are:

- basic
- info
- debug

#### Example

    NLX_LOG_LEVEL=info
