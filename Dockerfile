# Usa una imagen base con PHP y Composer ya instalado (pero quizás viejo)
FROM php:8.2-cli-bookworm

# Instala dependencias necesarias para tu proyecto y para Composer
RUN apt-get update && \
    apt-get install -y \
    git \
    unzip \
    curl

# **Instala o actualiza Composer a la última versión**
# 1. Descarga el instalador de Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# 2. (Opcional) Actualiza Composer a su última versión inmediatamente.
# Esto asegura que incluso si la imagen base traía una versión, esta será la más nueva.
RUN composer self-update

# ... el resto de tu configuración (como instalar IonCube Loader, como vimos antes)
COPY --from=ioncube /ioncube/ioncube_loader_lin_${PHP_VERSION} /usr/local/lib/php/extensions/ioncube.so
RUN echo "zend_extension=ioncube.so" > /usr/local/etc/php/conf.d/00-ioncube.ini

# Establece el directorio de trabajo
WORKDIR /workspace

# Copia los archivos de tu proyecto y instala las dependencias
COPY . .
RUN composer install
