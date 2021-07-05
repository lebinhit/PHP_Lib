<?php
mysqldump --single-transaction -u username -p database_name --triggers | sed -e 's/DEFINER[ ]*=[ ]*[^*]*\*/\*/' | gzip > database_name_.`date +"%Y%m%d"`.sql.gz