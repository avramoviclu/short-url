# WIP: Work in progress
## Logs
Check the logs of your PHP container for additional information on errors.
```
docker logs short_url_app
```
## Middleware 
- The _IpRateLimiterMiddleware_ middleware limits the number of requests a user can make to the application within a specified time frame, based on the user's IP address, to prevent abuse of resources and ensure fair usage of the service. 
- The _ShortenValidationMiddleware_ middleware validates if the input is in a valid URL format, ensuring that only properly formatted URLs are processed by the application.
