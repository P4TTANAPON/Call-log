CREATE TABLE `hardware_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `create_user_id` int(10) UNSIGNED NOT NULL,
  `product` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_part_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `serial_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phase` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `departments_id`  int(10) UNSIGNED NOT NULL,
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `hardware_items`
  ADD PRIMARY KEY (`id`),
  --ADD UNIQUE KEY `hardware_items_serial_number_unique` (`serial_number`),
  ADD KEY `hardware_items_create_user_id_foreign` (`create_user_id`),
  ADD KEY `hardware_items_product_index` (`product`),
  ADD KEY `hardware_items_model_part_number_index` (`model_part_number`);

ALTER TABLE `hardware_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `hardware_items`
  ADD CONSTRAINT `hardware_items_create_user_id_foreign` FOREIGN KEY (`create_user_id`) REFERENCES `users` (`id`);

ALTER TABLE `hardware_items`
  ADD CONSTRAINT `hardware_items_create_departments_id_foreign` FOREIGN KEY (`departments_id`) REFERENCES `departments` (`id`);

----------------scs_jobs

ALTER TABLE `scs_jobs`
  ADD COLUMN `hw_id` int(10) UNSIGNED NOT NULL;

ALTER TABLE `scs_jobs`
  ADD CONSTRAINT `scs_jobs_create_hd_id_foreign` FOREIGN KEY (`hw_id`) REFERENCES `hardware_items` (`id`);

