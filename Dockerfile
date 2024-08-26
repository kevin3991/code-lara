# 使用 PHP 8.2 官方映像作为基础映像
FROM php:8.2-fpm

# 设置工作目录
WORKDIR /var/www

# 安装系统依赖和 PHP 扩展，并减少镜像层数
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 安装 Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 设置环境变量以允许 Composer 作为 root 运行
ENV COMPOSER_ALLOW_SUPERUSER=1

# 复制 Laravel 应用程序到容器内（仅复制依赖文件以利用缓存机制）
COPY composer.json composer.lock /var/www/
RUN composer install --no-scripts --no-autoloader

# 复制其余的应用程序代码并安装 Laravel 依赖
COPY . /var/www
RUN composer dump-autoload --optimize

# 设置正确的权限
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# 配置 OPcache
RUN { \
    echo 'opcache.enable=1'; \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=4000'; \
    echo 'opcache.revalidate_freq=2'; \
    echo 'opcache.fast_shutdown=1'; \
    } > /usr/local/etc/php/conf.d/opcache.ini

# 暴露端口
EXPOSE 8000

# 启动容器时执行的命令
CMD ["php-fpm"]
