FROM mysql/mysql-server:8.0

ENV MYSQL_DATABASE=todo \
  MYSQL_USER=user \
  MYSQL_PASSWORD=password \
  MYSQL_ROOT_PASSWORD=secret \
  TZ=Asia/Tokyo

COPY ./my.cnf /etc/mysql/conf.d/my.cnf
RUN chmod 644 /etc/mysql/conf.d/my.cnf
