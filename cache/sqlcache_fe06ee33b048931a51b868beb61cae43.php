<?php exit;?>1358418537s:271:"SELECT ec_memdays.*,ec_users.user_name,ec_memdays.memdaysid as crmid
				FROM ec_memdays
				INNER JOIN ec_account
					ON ec_account.accountid = ec_memdays.accountid
				LEFT JOIN ec_users
					ON ec_memdays.smownerid = ec_users.id
				WHERE ec_memdays.deleted = 0";