#!/usr/bin/env bash
docker build -t my-service-name-v1 .

rm -rf /tmp/templates && mkdir /tmp/templates && cp nginx.tmpl /tmp/templates

echo 'events {
          worker_connections 1024;
      }' >  /tmp/nginx/nginx.conf

docker run -d --name nginx -p 8000:80 -v /tmp/nginx:/etc/nginx -t nginx

docker run -d --name my-app-name-nginx-gen --volumes-from nginx  \
   -v /var/run/docker.sock:/tmp/docker.sock \
   -v /tmp/templates:/etc/docker-gen/templates \
   -t jwilder/docker-gen:0.3.4 -notify-sighup nginx -watch --only-exposed /etc/docker-gen/templates/nginx.tmpl /etc/nginx/nginx.conf


docker run -d my-service-name-v1
docker run -d my-service-name-v1
docker run -d my-service-name-v1