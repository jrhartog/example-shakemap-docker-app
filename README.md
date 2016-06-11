# example-shakemap-docker-app
ShakeMap is a set of programs created and maintained by the U.S. Geological Survey
that will generate maps of shaking intensity (and peak ground acceleration, etc. etc.)
by interpolating peak ground motion values measured at seismic stations as well
as DYFI reports. This application will only be interesting to
operators of seismic networks.

I do not enjoy installing and maintaining ShakeMap configurations, which is why I decided to
try to containerize it with Docker. To learn about Docker, see [http://www.docker.com](http://www.docker.com)

This example application will run two docker containers, shakemap and shakemap-db. The shakemap
container runs ShakeMap program queue and is listening on port 2345.
When started through docker-compose it will have mounted various directories on
the local host in ${SHAKE_HOME}.

The shakemap container contains all the necessary programs to run the various 
ShakeMap programs (shake, retrieve, grind, mapping, genex, transfer, etc. etc.) but
gets its configuration parameters from files on the local host, in directory 
$SHAKE_HOME. Inside the container ${SHAKE_HOME} is /home/shake, but
it can be anything on the host machine in anyone's user account. The container
also writes its output (data and logs) to $SHAKE_HOME on the host.

The ShakeMap programs running inside the container will connect to the other 
container that is started, the shakemap-db, which is an instance
of a mariadb (non-Oracle version of mysql).

Try out the application:

1. Change the MYSQL_ROOT_PASSWORD in the shakemap.env file and source it 
   (IMPORTANT: if you have a mysql server running on your host also change the MYSQL_PORT!)  
   ```source shakemap.env```

2. Start the app:  
   ```sudo docker-compose up -d```

3. connect to the shakemap-db container and create the shakemap database and shake database user:
   
 ```docker exec -i -t shakemap-db mysql -u root -p${MYSQL_ROOT_PASSWORD}```  

 ```SQL
Welcome to the MariaDB monitor.  Commands end with ; or \g.  
Your MariaDB connection id is 8   
Server version: 10.1.14-MariaDB-1~jessie mariadb.org binary distribution   

Copyright (c) 2000, 2016, Oracle, MariaDB Corporation Ab and others.  

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.  

MariaDB [(none)]>create database if not exists shakemap;  
Query OK, 1 row affected (0.00 sec)

MariaDB [(none)]> grant select,insert,update,delete,create,drop,alter on
    -> shakemap.* to shake@'%' identified by 'shake_password'; 
Query OK, 0 rows affected (0.01 sec)
```
   Note: for production use you may want to copy the data from your old mysql shakemap database 
   into the container database. Also, for production make sure to change the example passwords.

4. The first time you run this app you will have to create the database tables:  
   ```sudo docker exec -i -t shakemap /home/shake/ShakeMap/bin/mktables```

5. Preview the current configuration:  
   ```sudo docker exec shakemap shake -event 9583161 -dryrun```  

6. Trigger a shakemap by sending a message to the listening port:  
   ```util/trigger_shakemap 9583161 1```

   You can follow along by looking at output messages:  
   ```tail -f logs/shake.9583161.log```

   After it is done you may want to explore the output in data/9583161  
   Or you can point your browser to:  
   _file://${SHAKE_HOME}/data/9583161/genex/web/shake/index.html_

7. Stop the app (this completely removes the containers but not the configs and data!):  
   ```docker-compose down```

To replicate your own ShakeMap set up, you will have to modify the 
environment variables in shakemap.env and edit the various necessary
files in ${SHAKE_HOME}/config, lib, and pw. This is beyond the scope of
this README and you will need to refer to the official ShakeMap documentation.

## Prepping your environment
1. Edit shakemap.env to reflect your choices for various environment variables:  
   **SHAKE_HOME** : The directory with data, lib, logs, and pw subdirectories that the shakemap container will write to/read from.  
   **QUEUE_PORT** : The port number on the local host that you want to forward to the queue listening port.  
   **PDL_HOME** : The directory in which the ProductClient subdirectory is located (i.e. where you unzipped the ProductClient.zip).  
   **MYSQL_DATADIR** : The directory that the mysql database container will read from and write to.  
   **MYSQL_PORT** : The port number on the local host that you want to forward to the mysqld server port.  

2. ```source shakemap.env```

3. Create directory $SHAKE_HOME if it doesn't exist yet:  
   ```mkdir -p $SHAKE_HOME```

4. Create directory $PDL_HOME if it doesn't exist yet:  
   ```mkdir -p $PDL_HOME```

## Configure ShakeMap
* ```cp -r EXAMPLE_SHAKE_HOME/* $SHAKE_HOME```
* Customize config, lib, pw in $SHAKE_HOME (refer to ShakeMap documentation).
* Unzip the zip-file http://ehppdl1.cr.usgs.gov/ProductClient.zip in ${PDL_HOME} to create directory ${PDL_HOME}/ProductClient
* You may have to play with firewall rules to get it to work on a production machine.
