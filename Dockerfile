FROM php:8.1

# Install necessary extensions
#RUN docker-php-ext-install

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www/html

# Copy the application code and install dependencies
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-progress

# Copy the application code
COPY . .

# Expose the web server port
EXPOSE 8000

# Start the PHP built-in web server
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
