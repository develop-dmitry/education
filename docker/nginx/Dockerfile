FROM nginx:latest

COPY ./conf.d/education.loc.conf /etc/nginx/conf.d/education.loc.conf

WORKDIR /var/www/html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]