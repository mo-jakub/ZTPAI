FROM postgres

ARG POSTGRES_DB

RUN apt-get update && apt-get install -y \
       postgresql-17-cron

#RUN echo "shared_preload_libraries = 'pg_cron'" >> /usr/share/postgresql/postgresql.conf.sample
#RUN echo "cron.database_name = '${POSTGRES_DB}'" >> /usr/share/postgresql/postgresql.conf.sample

#COPY ./docker/db/init.sql /docker-entrypoint-initdb.d/
#COPY ./docker/db/sampleData.sql /docker-entrypoint-initdb.d/