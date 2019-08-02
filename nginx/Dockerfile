FROM nginx:1.15
COPY nginx.conf /etc/nginx/
COPY erp.conf /etc/nginx/sites/
RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf && \
    rm -f /etc/nginx/conf.d/default.conf
