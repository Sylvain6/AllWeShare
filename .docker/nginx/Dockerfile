FROM alpine:3.8

RUN apk add --update --no-cache nginx=1.14.0-r1

COPY symfony.conf /etc/nginx/conf.d/default.conf
COPY nginx.conf /etc/nginx

CMD nginx -g 'daemon off';

EXPOSE 80
EXPOSE 443