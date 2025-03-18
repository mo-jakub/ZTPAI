FROM php:8.2-cli

# Install required dependencies
RUN apt-get update && apt-get install -y \
    wget \
    git \
    unzip

# Install Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash && \
    mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Copy the application code
COPY . /app

# Define a volume for the application
VOLUME ["/app"]