MessageLogger
======
Usage:
```
php app/main.php start
```
Starts the worker, which consumes messages in Kafka and logs the message payload

```
php app/main.php test 10
```
Generates 10 messages in kafka, then starts the worker
