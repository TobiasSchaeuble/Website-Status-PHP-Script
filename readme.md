# Website Monitor

This project is a simple PHP script for monitoring the status and latency of multiple domains. It checks the status of each domain and optionally sends an email notification if a domain does not return a 200 status code. Additionally, it provides an option to generate a chart using Chart.js to visualize the status of each website.

## Features

- Monitor the status and latency of multiple domains.
- Email notifications for domains with non-200 status codes.
- Optional visualization using Chart.js.

## Installation

1. Copy the `status.php` script, `domains`, and `mailto` file to your server.
2. Configure the list of domains in the `domains` file, with one domain per line.
3. Configure the email address to receive notifications in the `mailto` file.
4. (Optional) Copy the `index.html` file to your server to see a visualization.

## Usage

### Monitoring Domains

#### Configuration
The domains file contains a list of domains to monitor, with one domain per line.

The mailto file contains the email address to which notifications will be sent if a domain has a non-200 status code.

To monitor the domains, simply run the `status.php` script. 
You can run it manually (opening it with your browser **yourdoma.in/status.php**) or set up a cron job to run it periodically.

Example of setting up a cron job to run the script every minute:
```bash
* * * * * php /path/to/status.php
```

## Email Notifications
If a domain does not return a 200 status code, an email notification will be sent to the configured email address.

## Visualization (Optional)
To visualize the status of each website, you can open the index.html file in a web browser. The page will display a chart generated using Chart.js.

## License
This project is licensed under the MIT License - see the LICENSE file for details.