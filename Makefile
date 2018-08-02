.PHONY: setup-db import-data

setup-db:
	docker exec -it activatoradmin_mysql /bin/bash -c "mysql -u root -pabcd1234 < /var/www/html/docs/db.sql"

import-data:
	docker exec -it activatoradmin_mysql /bin/bash -c "mysql -u root -pabcd1234 activatoradmin < /var/www/html/docs/db-dummy-data.sql"