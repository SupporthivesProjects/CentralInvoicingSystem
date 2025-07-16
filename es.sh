#create a shell script to run the laravel application and show detailed logs
# Save this script as es.sh and make it executable with chmod +x es.sh
#!/bin/bash

php artisan serve --verbose
#add error handling
if [ $? -ne 0 ]; then
  echo "Failed to start the Laravel application. Please check the logs for more details."
  exit 1
fi
