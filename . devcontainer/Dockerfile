# Usa una imagen base de PHP con Apache y la versión que necesites
FROM php:8.2-apache-bookworm

# Evita preguntas interactivas durante la instalación
ENV DEBIAN_FRONTEND=noninteractive

# Actualiza e instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
        curl \
            wget \
                unzip \
                    libzip-dev \
                        libpng-dev \
                            libonig-dev \
                                libxml2-dev \
                                    && apt-get clean \
                                        && rm -rf /var/lib/apt/lists/*

                                        # Instala extensiones de PHP necesarias
                                        RUN docker-php-ext-install \
                                            pdo_mysql \
                                                mysqli \
                                                    mbstring \
                                                        xml \
                                                            zip \
                                                                gd \
                                                                    exif

                                                                    # Instala la última versión de Composer
                                                                    RUN curl -sS https://getcomposer.org/installer | php -- \
                                                                        --install-dir=/usr/local/bin --filename=composer

                                                                        # Instala IonCube Loader (Versión específica para PHP 8.2)
                                                                        RUN ARCH=$(uname -m | sed 's/x86_64/x86-64/;s/aarch64/arm64/') && \
                                                                            curl -o ioncube.tar.gz "https://downloads.ioncube.com/loader_downloads/ioncube_loaders_lin_${ARCH}.tar.gz" && \
                                                                                tar -xzf ioncube.tar.gz && \
                                                                                    PHP_EXT_DIR=$(php -r "echo ini_get('extension_dir');") && \
                                                                                        cp "ioncube/ioncube_loader_lin_8.2.so" "$PHP_EXT_DIR/" && \
                                                                                            echo "zend_extension=ioncube.so" > /usr/local/etc/php/conf.d/00-ioncube.ini && \
                                                                                                rm -rf ioncube.tar.gz ioncube

                                                                                                # Habilita mod_rewrite de Apache
                                                                                                RUN a2enmod rewrite

                                                                                                # Configura el directorio de trabajo de Apache
                                                                                                ENV APACHE_DOCUMENT_ROOT /workspace/public
                                                                                                RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
                                                                                                RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

                                                                                                # Establece el directorio de trabajo
                                                                                                WORKDIR /workspace

                                                                                                # Puerto que expone Apache
                                                                                                EXPOSE 80

                                                                                                # Comando por defecto
                                                                                                CMD ["apache2-foreground"]