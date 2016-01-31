# Symfony Swagger Microservice Edition [![Build Status](https://travis-ci.org/kleijnweb/symfony-swagger-microservice-edition.svg?branch=master)](https://travis-ci.org/kleijnweb/symfony-swagger-microservice-edition) 

Symfony edition for "interface first" microservices that's as lean and mean as it is unofficial.  

For a more complete example, have a look at [swagger-bundle-example](https://github.com/kleijnweb/swagger-bundle-example).

## Lean

The Symfony Standard Editions bundles no less than 125MB worth of bytes. This edition comes in at 32MB (both installed with --no-dev). Components are cherry picked from Symfony, instead of including the whole framework with all the trimmings and then some 3rd part stuff*. 

*Less is more*. An nginx config template reflecting this philosophy is included.

__* NOTE:__ The symfony/framework bundle adds plenty of unneeded dependencies. Without them, this edition comes in at around 15MB (see [this issue](https://github.com/symfony/symfony/issues/15748)).

 
## Mean

This edition uses [kleijnweb/swagger-bundle](https://github.com/kleijnweb/swagger-bundle) to integrate routing and input validation from Swagger into Symfony. On top of its (very modest) dependencies, this edition only adds [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv). Monolog is added as the logger, as SwaggerBundle will work with any PSR logger and depends only on the interface package.

This package only uses the minimal capabilities of SwaggerBundle. Refer to [kleijnweb/swagger-bundle](https://github.com/kleijnweb/swagger-bundle) for an overview of implementation options.

## Unofficial

I am not affiliated with SensioLabs in any way, and not particularly connected to the Symfony community. This is anarchy city, beware.

## Quick Start

1. `composer install`
2. Rename `.env.dist` to `.env`
3. Confirm all is good to start screwing things up: `phpunit -c app` 
4. Replace `app/config/swagger.yml` with your own Swagger
6. Start hacking away at the pet store :)

__Note:__ To change the root namespace from Acme to your own, update composer.json autoload config and `install`.

## Docker

To follow this section your need [Docker](http://docs.docker.com/) installed. This one-liner should do the trick:

```bash
curl -sSL https://get.docker.com/ | sh
```

Want awesomeness without delay? Then `./kickstart.sh` first, ask questions later.

### PHP 7.0 + FPM Docker container

This runs pretty damn fast. A full round-trip will generally stay under 50ms (not accounting for initial cache warmup, external resources and varying hardware).

To build your app, run `docker build -t my-service-name .`. Edit php.ini if needed.
Then run the container as a background process: `docker run -d my-service-name`. Now you can use any fcgi frontend, eg nginx.

### Redundant FCGI Service

On a single server, load balancing using docker containers does not make much sense. But having a redundant setup not only protects you from downtime,
it also makes for 0 downtime deployments.
 
Jason Wilder has created an easy to use lib that updates config when certain Docker events are triggered. You can use it to autoupdate your upstream fcgi server list in Nginx. Instructions:

If you haven't done so already, build your service image:

```bash
docker build -t my-service-name-v1 .
```

Create a default, dummy nginx config (it will be replaced as soon as docker-gen comes up):

```bash
echo 'events {
          worker_connections 1024;
      }' >  /tmp/nginx/nginx.conf
```

Run a standard nginx container, expose port 8000 to the host (80 if you prefer), but add its config directory as a volume:

```bash
docker run -d --name nginx -p 8000:80 -v /tmp/nginx:/etc/nginx -t nginx
```

Confirm the container is running (`docker ps`). Put bundled nginx.tmpl somewhere docker-gen can access it:

```bash
rm -rf /tmp/templates && mkdir /tmp/templates && cp nginx.tmpl /tmp/templates
```

__NOTE__: This nginx config has been pretty much stripped down to the necessities for running a microservice. You may want to edit it. Any containers exposing port 9000 will be added as upstream server using this template. Again, you may want to edit it.

Run a docker-gen container that'll monitor docker for changes in containers, and update the ngnix.conf.

```bash
docker run -d --name my-app-name-nginx-gen --volumes-from nginx  \
   -v /var/run/docker.sock:/tmp/docker.sock \
   -v /tmp/templates:/etc/docker-gen/templates \
   -t jwilder/docker-gen:0.3.4 -notify-sighup nginx -watch --only-exposed /etc/docker-gen/templates/nginx.tmpl /etc/nginx/nginx.conf
```

__NOTE__: If the container doesn't start, you probably edited the ngnix.tmpl and it has a parse error. Run without `-d` to debug.

To see the magic working, watch nginx.conf on the host system:

```bash
tail -n 50 /tmp/nginx/nginx.conf
```

Start running containers based on your service image:

```bash
docker run -d my-app-name-v1
docker run -d my-app-name-v1
docker run -d my-app-name-v1
```

The `upstream` section will look something like this:

```
upstream phpfpm_upstream {

    # kickass_payne
    server 172.17.1.108:9000;

    # backstabbing_yonath
    server 172.17.1.105:9000;

    # jovial_fermat
    server 172.17.1.97:9000;
}
```

Try stopping and starting containers to see the config being updated, eg `docker stop kickass_payne`.

You can test the demo API by requesting `http://127.0.0.1:8000/v2/pet/findByStatus?status=pending`.

Deploying a new version of your service could not be easier. Build the new version, then repeatedly stop an old and start a new container until all containers are replaced.

Enjoy :) 


## License

MIT
