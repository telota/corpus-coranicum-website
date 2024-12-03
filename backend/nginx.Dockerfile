FROM nginx:latest

COPY ./nginx.conf /etc/nginx/conf.d/default.conf

# For debugging nginx
#CMD ["nginx-debug", "-g", "daemon off;"]