# build stage
FROM node:14-alpine as build-stage
ARG VUE_APP_BACKEND_URL
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# production stage
FROM nginx:latest as production-stage
ARG LOCALHOST
COPY --from=build-stage /app/dist /usr/share/nginx/html
COPY ./nginx.conf /etc/nginx/conf.d/default.conf
COPY ./legacy_url_redirects.conf /etc/nginx/
RUN test -z $LOCALHOST || echo "absolute_redirect off;" >> /etc/nginx/legacy_url_redirects.conf
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
