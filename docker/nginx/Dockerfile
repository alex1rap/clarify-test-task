FROM nginx:alpine

WORKDIR /var/www

COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf

CMD ["nginx", "-g", "daemon off;"]

EXPOSE 80 443
