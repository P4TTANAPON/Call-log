update jobs set last_call_category_id=sa_rw_call_category_id where last_call_category_id is null;
update jobs set last_primary_system_id=sa_rw_primary_system_id where last_primary_system_id is null;
update jobs set last_secondary_system_id=sa_rw_secondary_system_id where last_secondary_system_id is null;

update jobs set last_call_category_id=call_category_id where last_call_category_id is null;
update jobs set last_primary_system_id=primary_system_id where last_primary_system_id is null;
update jobs set last_secondary_system_id=secondary_system_id where last_secondary_system_id is null;