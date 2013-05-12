<?php exit;?>1358418478s:278:"SELECT ec_contacts.*,ec_users.user_name,ec_contacts.contactsid as crmid
				FROM ec_contacts
				INNER JOIN ec_account
					ON ec_account.accountid = ec_contacts.accountid
				LEFT JOIN ec_users
					ON ec_contacts.smownerid = ec_users.id
				WHERE ec_contacts.deleted = 0";